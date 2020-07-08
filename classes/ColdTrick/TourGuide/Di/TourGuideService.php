<?php

namespace ColdTrick\TourGuide\Di;

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
	public function getPendingFeatureTours() {
		$request = _elgg_services()->request;
		$route = $request->getRoute();
		if (!$route instanceof Route) {
			return [];
		}
		
		$tours = $this->getToursForRoute($route->getName());
		
		return [
			[
				'element' => '.elgg-form-search',
				'popover' => [
					'title' => 'Search',
					'description' => 'You can search here',
					'position' => 'bottom',
				],
			],
			[
				'element' => '.elgg-page-topbar',
				'popover' => [
					'title' => 'Topbar',
					'description' => 'Ohh nice menu mister',
					'position' => 'bottom',
				],
			],
			[
				'element' => '#elgg-widget-6729',
				'popover' => [
					'title' => 'Important person',
					'description' => 'Rate my boobies',
					'position' => 'right',
				],
			],
		];
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
		]);
	}
}
