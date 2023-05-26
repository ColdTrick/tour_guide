<?php

namespace ColdTrick\TourGuide\Menus;

use Elgg\Menu\MenuItems;
use Elgg\Router\Route;

/**
 * Add menu items to the topbar menu
 */
class Topbar {
	
	/**
	 * Add menu items to the account menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:topbar'
	 *
	 * @return null|MenuItems
	 */
	public static function register(\Elgg\Event $event): ?MenuItems {
		if (!elgg_is_admin_logged_in()) {
			return null;
		}
		
		$route = _elgg_services()->request->getRoute();
		if (!$route instanceof Route) {
			return null;
		}
		
		/* @var $result MenuItems */
		$result = $event->getValue();
		
		$result[] = \ElggMenuItem::factory([
			'name' => 'feature_tour',
			'icon' => 'plus',
			'text' => elgg_echo('add:object:feature_tour'),
			'href' => elgg_http_add_url_query_elements('admin/administer_utilities/feature_tour/save', [
				'route_name' => $route->getName(),
			]),
			'target' => '_blank',
			'parent_name' => 'account',
			'section' => 'alt',
		]);

		return $result;
	}
}
