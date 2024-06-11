<?php

$composer_path = '';
if (is_dir(__DIR__ . '/vendor')) {
	$composer_path = __DIR__ . '/';
}

return [
	'plugin' => [
		'version' => '6.0',
	],
	'settings' => [
		'finish_early' => 0,
	],
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'feature_tour',
			'class' => \FeatureTour::class,
			'capabilities' => [
				'commentable' => false,
			],
		],
	],
	'actions' => [
		'feature_tour/complete' => [],
		'feature_tour/export' => ['access' => 'admin'],
		'feature_tour/import' => ['access' => 'admin'],
		'feature_tour/reset' => ['access' => 'admin'],
		'feature_tour/save' => ['access' => 'admin'],
	],
	'events' => [
		'register' => [
			'menu:entity' => [
				'\ColdTrick\TourGuide\Menus\Entity::register' => [],
			],
			'menu:admin_header' => [
				'\ColdTrick\TourGuide\Menus\AdminHeader::register' => [],
			],
			'menu:topbar' => [
				'\ColdTrick\TourGuide\Menus\Topbar::register' => [],
			],
		],
		'view_vars' => [
			'forms/feature_tour/save' => [
				'\ColdTrick\TourGuide\Forms::prepareFeatureTourForm' => [],
			],
		],
	],
	'views' => [
		'default' => [
			'tour_guide/driver/' => $composer_path . 'vendor/npm-asset/driver.js/dist/',
		],
	],
	'view_extensions' => [
		'page/elements/header' => [
			'tour_guide/check_tours' => [],
		],
	],
	'view_options' => [
		'forms/feature_tour/import' => ['ajax' => true],
		'forms/feature_tour/step' => ['ajax' => true],
	],
];
