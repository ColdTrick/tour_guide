<?php

namespace ColdTrick\TourGuide\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the entity menu
 */
class Entity {
	
	/**
	 * Add menu items to the entity menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:entity'
	 *
	 * @return null|MenuItems
	 */
	public static function register(\Elgg\Event $event): ?MenuItems {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \FeatureTour || !$entity->canEdit()) {
			return null;
		}
		
		/* @var $result MenuItems */
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
			'href' => elgg_generate_action_url('feature_tour/reset', ['guid' => $entity->guid]),
			'confirm' => true,
		]);
		
		return $result;
	}
}
