<?php

namespace ColdTrick\TourGuide;

/**
 * Form related callbacks
 */
class Forms {
	
	/**
	 * Prepares form vars
	 *
	 * @param \Elgg\Event $event 'view_vars', 'forms/feature_tour/save'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function prepareFeatureTourForm(\Elgg\Event $event) {
		
		$vars = $event->getValue();
		
		$result = [
			'guid' => null,
			'title' => null,
			'route_name' => get_input('route_name'),
			'published' => 0,
			'required' => 0,
		];
		
		// edit
		$entity = elgg_extract('entity', $vars);
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
					'stageBackground' => elgg_extract('stageBackground', $config, '#FFFFFF'),
				];
			}

			$result['steps'] = $steps;
		}
		
		return $vars + $result;
	}
}
