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
			'route_name' => get_input('route_name'),
			'published' => 0,
			'required' => 0,
		];
		
		// edit
		if ($entity instanceof \FeatureTour) {
			foreach ($result as $key => $value) {
				$result[$key] = $entity->$key;
			}
			
			$steps = [];
			$steps_config = $entity->getStepConfiguration();
			foreach ($steps_config as $config) {
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
