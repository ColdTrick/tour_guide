<?php

namespace ColdTrick\TourGuide;

class Menus {
	
	/**
	 * Add menu items to the page menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:page'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerAdminPageMenu(\Elgg\Hook $hook) {
		
		if (!elgg_is_admin_logged_in() || !elgg_in_context('admin')) {
			return;
		}
		
		$result = $hook->getValue();
		
		$result[] = \ElggMenuItem::factory([
			'name' => 'feature_tours',
			'text' => elgg_echo('admin:administer_utilities:feature_tours'),
			'href' => 'admin/administer_utilities/feature_tours',
			'parent_name' => 'administer_utilities',
			'section' => 'administer',
		]);
		
		return $result;
	}
	
	/**
	 * Add menu items to the entity menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:entity'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerEntityMenu(\Elgg\Hook $hook) {

		$entity = $hook->getEntityParam();
		if (!$entity instanceof \FeatureTour || !$entity->canEdit()) {
			return;
		}
		
		$result = $hook->getValue();
		
		$result[] = \ElggMenuItem::factory([
			'name' => 'edit',
			'icon' => 'edit',
			'text' => elgg_echo('edit'),
			'href' => "ajax/form/feature_tour/save?guid={$entity->guid}",
			'link_class' => [
				'elgg-lightbox',
			],
		]);
		
		$result[] = \ElggMenuItem::factory([
			'name' => 'reset',
			'icon' => 'refresh',
			'text' => elgg_echo('reset'),
			'confirm' => true,
			'href' => elgg_generate_action_url('feature_tour/reset', ['guid' => $entity->guid]),
		]);

		return $result;
	}
}
