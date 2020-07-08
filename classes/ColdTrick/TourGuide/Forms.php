<?php

namespace ColdTrick\TourGuide;

class Forms {
	
	/**
	 * Prepares form vars
	 *
	 * @param \Elgg\Hook $hook 'view_vars', 'forms/feature_tour/save'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function prepareFeatureTourForm(\Elgg\Hook $hook) {
		
		$vars = $hook->getValue();
		$entity = elgg_extract('entity', $vars);
		
		$result = [
			'guid' => null,
			'title' => null,
			'route_name' => null,
		];
		
		// edit
		if ($entity instanceof \FeatureTour) {
			foreach ($result as $key => $value) {
				$result[$key] = $entity->$key;
			}
		}
		
		return $vars + $result;
	}
}
