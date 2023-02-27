<?php

namespace ColdTrick\TourGuide;

use Elgg\Router\Route;

/**
 * Menu callbacks
 */
class Menus {
	
	/**
	 * Add menu items to the page menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:admin_header'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerAdminPageMenu(\Elgg\Event $event) {
		
		if (!elgg_is_admin_logged_in()) {
			return;
		}
		
		$result = $event->getValue();
		
		$result[] = \ElggMenuItem::factory([
			'name' => 'feature_tours',
			'text' => elgg_echo('admin:administer_utilities:feature_tours'),
			'href' => 'admin/administer_utilities/feature_tours',
			'parent_name' => 'administer_utilities',
		]);
		
		return $result;
	}
	
	/**
	 * Add menu items to the entity menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:entity'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerEntityMenu(\Elgg\Event $event) {

		$entity = $event->getEntityParam();
		if (!$entity instanceof \FeatureTour || !$entity->canEdit()) {
			return;
		}
		
		$result = $event->getValue();
		
		$result[] = \ElggMenuItem::factory([
			'name' => 'edit',
			'icon' => 'edit',
			'text' => elgg_echo('edit'),
			'href' => "admin/administer_utilities/feature_tour/save?guid={$entity->guid}",
		]);
		
		$result[] = \ElggMenuItem::factory([
			'name' => 'export',
			'icon' => 'download',
			'text' => elgg_echo('export'),
			'href' => elgg_generate_action_url('feature_tour/export', ['guid' => $entity->guid]),
		]);
		
		$result[] = \ElggMenuItem::factory([
			'name' => 'import',
			'icon' => 'upload',
			'text' => elgg_echo('import'),
			'href' => "ajax/form/feature_tour/import?guid={$entity->guid}",
			'link_class' => [
				'elgg-lightbox',
			],
			'data-colorbox-opts' => json_encode([
				'width' => '800px',
			]),
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
	
	/**
	 * Add menu items to the account menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:topbar'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerAccountMenu(\Elgg\Event $event) {

		if (!elgg_is_admin_logged_in()) {
			return;
		}
		
		$route = _elgg_services()->request->getRoute();
		if (!$route instanceof Route) {
			return;
		}
		
		$result = $event->getValue();
		
		$result[] = \ElggMenuItem::factory([
			'name' => 'feature_tour',
			'icon' => 'plus',
			'text' => elgg_echo('add:object:feature_tour'),
			'href' => 'admin/administer_utilities/feature_tour/save?route_name=' . $route->getName(),
			'target' => '_blank',
			'parent_name' => 'account',
			'section' => 'alt',
		]);

		return $result;
	}
}
