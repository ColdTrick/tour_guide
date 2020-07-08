<?php

namespace ColdTrick\TourGuide;

$composer_path = '';
if (is_dir(__DIR__ . '/vendor')) {
	$composer_path = __DIR__ . '/';
}

return [
	'bootstrap' => Bootstrap::class,
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'feature_tour',
			'class' => \FeatureTour::class,
		],
	],
	'actions' => [
		'feature_tour/complete' => [],
		'feature_tour/reset' => ['access' => 'admin'],
		'feature_tour/save' => ['access' => 'admin'],
	],
	'views' => [
		'default' => [
			'tour_guide/driver/' => $composer_path . 'vendor/npm-asset/driver.js/dist/',
		],
	],
	'view_extensions' => [
		'elgg.css' => [
			'tour_guide/driver/driver.min.css' => [],
		],
		'page/elements/header' => [
			'tour_guide/check_tours' => [],
		],
	],
	'hooks' => [
		'register' => [
			'menu:page' => [
				__NAMESPACE__ . '\Menus::registerAdminPageMenu' => [],
			],
			'menu:entity' => [
				__NAMESPACE__ . '\Menus::registerEntityMenu' => [],
			],
		],
		'view_vars' => [
			'forms/feature_tour/save' => [
				__NAMESPACE__ . '\Forms::prepareFeatureTourForm' => [],
			],
		],
	],
];
