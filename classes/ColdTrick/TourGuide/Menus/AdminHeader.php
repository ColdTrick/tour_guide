<?php

namespace ColdTrick\TourGuide\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the admin_header menu
 */
class AdminHeader {
	
	/**
	 * Add menu items to the page menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:admin_header'
	 *
	 * @return null|MenuItems
	 */
	public static function register(\Elgg\Event $event): ?MenuItems {
		if (!elgg_is_admin_logged_in()) {
			return null;
		}
		
		/** @var MenuItems $result */
		$result = $event->getValue();
		
		$result[] = \ElggMenuItem::factory([
			'name' => 'feature_tours',
			'text' => elgg_echo('admin:administer_utilities:feature_tours'),
			'href' => elgg_generate_url('admin', [
				'segments' => 'administer_utilities/feature_tours',
			]),
			'parent_name' => 'utilities',
		]);
		
		return $result;
	}
}
