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
			
			$steps = [];
			$steps_config = $entity->steps_config ?: [];
			foreach ($steps_config as $config) {
				$config = json_decode($config, true);
				$steps[] = [
					'element' => $config['element'],
					'title' => $config['popover']['title'],
					'description' => $config['popover']['description'],
					'position' => $config['popover']['position'],
				];
			}

			$result['steps'] = $steps;
		}
		
		return $vars + $result;
	}
}
