<?php

namespace ColdTrick\TourGuide\Di;

use Elgg\Database\Clauses\OrderByClause;
use Elgg\Database\QueryBuilder;
use Elgg\Database\Clauses\JoinClause;
use Elgg\Database\Clauses\SelectClause;
use Elgg\Di\ServiceFacade;
use Elgg\Router\Route;

class TourGuideService {

	use ServiceFacade;
	
	/**
	 * @var \ElggSession
	 */
	protected $session;
	
	/**
	 * Create a new service
	 *
	 * @param \ElggSession $session Elgg session management
	 */
	public function __construct(\ElggSession $session) {
		$this->session = $session;
	}
	
	/**
	 * Returns registered service name
	 *
	 * @return string
	 */
	public static function name() {
		return 'tour_guide.service';
	}
	
	/**
	 * Return the feature tour (steps) for the current route that the user hasn't seen yet
	 *
	 * @return []
	 */
	public function getPendingFeatureTours(bool $show_completed_tours = false, bool $show_unpublished_tours = false) {
		$request = _elgg_services()->request;
		$route = $request->getRoute();
		if (!$route instanceof Route) {
			return [];
		}
		
		if (!$show_completed_tours) {
			$pending = $this->session->get('tour_guide');
			if (!isset($pending)) {
				$pending = $this->cachePendingFeatureTours();
			}
			
			if (empty($pending)) {
				return [];
			}
			
			$guids = elgg_extract($route->getName(), $pending);
			if (empty($guids)) {
				return [];
			}
			
			$tours = $this->getToursByGUID($guids);
		} else {
			$tours = $this->getToursForRoute($route->getName(), $show_unpublished_tours);
		}
		
		return $this->getStepsFromFeatureTours($tours, !$show_unpublished_tours);
	}
	
	/**
	 * Track that a tour was completed to prevent is from loading again during this session
	 *
	 * @param \FeatureTour $entity the completed tour
	 *
	 * @return void
	 */
	public function trackCompletedTour(\FeatureTour $entity) {
		$pending = $this->session->get('tour_guide');
		if (empty($pending)) {
			// how did we get here
			return;
		}
		
		$tours = elgg_extract($entity->route_name, $pending);
		if (empty($tours)) {
			// how did we get here
			return;
		}
		
		foreach ($tours as $index => $guid) {
			if ($guid !== $entity->guid) {
				continue;
			}
			
			unset($tours[$index]);
		}
		
		if (empty($tours)) {
			unset($pending[$entity->route_name]);
		} else {
			$pending[$entity->route_name] = $tours;
		}
		
		$this->session->set('tour_guide', $pending);
	}
	
	/**
	 * Get the feature tours for a given route name
	 *
	 * @param string $route_name the route name
	 *
	 * @return \FeatureTour[]
	 */
	protected function getToursForRoute(string $route_name, bool $show_unpublished_tours = false) {
		return elgg_call(ELGG_IGNORE_ACCESS, function() use ($route_name, $show_unpublished_tours) {
			$options = [
				'type' => 'object',
				'subtype' => \FeatureTour::SUBTYPE,
				'limit' => false,
				'metadata_name_value_pairs' => [
					[
						'name' => 'route_name',
						'value' => $route_name,
					],
				],
				'order_by' => new OrderByClause('e.time_created', 'asc'),
			];
			
			if (!$show_unpublished_tours) {
				$options['metadata_name_value_pairs'][] = [
					'name' => 'published',
					'value' => true,
				];
			}
			
			return elgg_get_entities($options);
		});
	}
	
	/**
	 * Get feature tours by guid (from cache)
	 *
	 * @param array $guids the tour guids (from cache)
	 *
	 * @return \FeatureTour[]
	 */
	protected function getToursByGUID(array $guids) {
		return elgg_call(ELGG_IGNORE_ACCESS, function () use ($guids) {
			return elgg_get_entities([
				'type' => 'object',
				'subtype' => \FeatureTour::SUBTYPE,
				'limit' => false,
				'guids' => $guids,
				'order_by' => new OrderByClause('e.time_created', 'asc'),
			]);
		});
	}
	
	/**
	 * Store all feature tours the users still needs to see in session
	 *
	 * @return array
	 */
	protected function cachePendingFeatureTours() {
		if (!$this->session->isLoggedIn()) {
			return [];
		}
		
		$tours = elgg_call(ELGG_IGNORE_ACCESS, function() {
			return elgg_get_entities([
				'type' => 'object',
				'subtype' => \FeatureTour::SUBTYPE,
				'limit' => false,
				'metadata_name_value_pairs' => [
					[
						'name' => 'published',
						'value' => true,
					],
				],
				'wheres' => [
					function (QueryBuilder $qb, $main_alias) {
						$rel = $qb->subquery('entity_relationships');
						$rel->select('guid_one')
							->andWhere($qb->compare('guid_two', '=', $this->session->getLoggedInUserGuid(), ELGG_VALUE_GUID))
							->andWhere($qb->compare('relationship', '=', 'done', ELGG_VALUE_STRING));
						
						return $qb->compare("{$main_alias}.guid", 'not in', $rel->getSQL());
					},
					function (QueryBuilder $qb, $main_alias) {
						return $qb->compare("mdr.name", '=', 'route_name', ELGG_VALUE_STRING);
					},
				],
				'joins' => [
					new JoinClause('metadata', 'mdr', function (QueryBuilder $qb, $joined_alias, $main_alias) {
						return $qb->compare("{$joined_alias}.entity_guid", '=', "{$main_alias}.guid");
					}),
				],
				'selects' => [
					new SelectClause('mdr.value AS route_name'),
				],
				'callback' => function($row) {
					return (object) [
						'guid' => (int) $row->guid,
						'route_name' => $row->route_name,
					];
				}
			]);
		});
		
		$store = [];
		foreach ($tours as $tour_data) {
			if (!isset($store[$tour_data->route_name])) {
				$store[$tour_data->route_name] = [];
			}
			
			$store[$tour_data->route_name][] = $tour_data->guid;
		}
		
		$this->session->set('tour_guide', $store);
		
		return $store;
	}
	
	/**
	 * Get the steps from the feature tours
	 *
	 * @param \FeatureTour[] $entities        the tours to check
	 * @param bool           $track_completed track the completion of a tour (default: true)
	 *
	 * @return array
	 */
	protected function getStepsFromFeatureTours(array $entities = [], bool $track_completed = true) {
		$steps = [];
		
		$required = false;
		
		foreach ($entities as $entity) {
			if (!$entity instanceof \FeatureTour) {
				continue;
			}
			
			if ($entity->required) {
				$required = true;
			}
			
			$steps = array_merge($steps, $entity->getStepConfiguration());
			
			$finish_early = (bool) elgg_get_plugin_setting('finish_early', 'tour_guide');
			
			// wrap description
			foreach ($steps as $index => $step) {
				if (!isset($step['popover']['description'])) {
					continue;
				}
				
				$steps[$index]['popover']['description'] = elgg_view('output/longtext', ['value' => $step['popover']['description']]);
				$steps[$index]['popover']['className'] = '';
				
				if ($finish_early && !$entity->required) {
					$steps[$index]['guid'] = $entity->guid;
					$steps[$index]['mark_completed_on_reset'] = true;
				}
			}
						
			if ($track_completed) {
				$last_id = count($steps) - 1;
				$steps[$last_id] += [
					'guid' => $entity->guid,
				];
			}
		}
		
		if (!empty($steps)) {
			
			$last_id = count($steps) - 1;
			
			$steps[0]['popover']['className'] .= ' popover-step-first';
			$steps[$last_id]['popover']['className'] .= ' popover-step-last';
		}
		
		if (count($steps) == 1) {
			$steps[0]['mark_completed_on_reset'] = true;
		}
		
		if ($required && !empty($steps)) {
			// track if the tour is required in the first step
			$steps[0]['required'] = true;
		}
		
		return $steps;
	}
}
