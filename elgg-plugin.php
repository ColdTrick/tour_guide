<?php

namespace ColdTrick\TourGuide;

$composer_path = '';
if (is_dir(__DIR__ . '/vendor')) {
	$composer_path = __DIR__ . '/';
}

return [
	'plugin' => [
		'version' => '4.1',
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
	'events' => [
		'register' => [
			'menu:entity' => [
				__NAMESPACE__ . '\Menus::registerEntityMenu' => [],
			],
			'menu:admin_header' => [
				__NAMESPACE__ . '\Menus::registerAdminPageMenu' => [],
			],
			'menu:topbar' => [
				__NAMESPACE__ . '\Menus::registerAccountMenu' => [],
			],
		],
		'view_vars' => [
			'forms/feature_tour/save' => [
				__NAMESPACE__ . '\Forms::prepareFeatureTourForm' => [],
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
	'views' => [
		'default' => [
			'tour_guide/driver/' => $composer_path . 'vendor/npm-asset/driver.js/dist/',
		],
	],
	'view_extensions' => [
		'admin.css' => [
			'tour_guide/site.css' => [],
			'tour_guide/driver.css' => [],
		],
		'elgg.css' => [
			'tour_guide/driver.css' => [],
			'tour_guide/site.css' => [],
		],
		'page/elements/header' => [
			'tour_guide/check_tours' => [],
		],
	],
	'view_options' => [
		'forms/feature_tour/import' => ['ajax' => true],
		'forms/feature_tour/step' => ['ajax' => true],
	],
];
