<?php

namespace ColdTrick\TourGuide\Di;

use Elgg\Di\ServiceFacade;
use Elgg\Router\Route;
use Elgg\Database\Clauses\OrderByClause;

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
	public function getPendingFeatureTours() {
		$request = _elgg_services()->request;
		$route = $request->getRoute();
		if (!$route instanceof Route) {
			return [];
		}
		
		$tours = $this->getToursForRoute($route->getName());
		
		$steps = [];
		foreach ($tours as $tour) {
			if (!$tour->published) {
				continue;
			}
			
			if (check_entity_relationship($tour->guid, 'done', $this->session->getLoggedInUserGuid())) {
				continue;
			}
			
			$steps = array_merge($steps, $tour->getStepConfiguration());

			$last_id = count($steps) - 1;
			$steps[$last_id] += [
				'guid' => $tour->guid,
			];
		}
		
		return $steps;
	}
	
	/**
	 * Get the feature tours for a given route name
	 *
	 * @param string $route_name the route name
	 *
	 * @return \FeatureTour[]
	 */
	protected function getToursForRoute(string $route_name) {
		return elgg_get_entities([
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
		]);
	}
}
