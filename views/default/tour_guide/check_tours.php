<?php
/**
 * Check if there are tours for the current page that the user hasn't seen yet
 * If so, start that tour
 */

use ColdTrick\TourGuide\Di\TourGuideService;

if (!elgg_is_logged_in()) {
	// @todo support logged out users
	return;
}

$service = TourGuideService::instance();

$show_completed_tours = (bool) get_input('show_completed_tours', false);
$show_unpublished_tours = false;
if ((bool) get_input('show_unpublished_tours', false) && elgg_is_admin_logged_in()) {
	$show_unpublished_tours = true;
	$show_completed_tours = true;
}

$steps = $service->getPendingFeatureTours($show_completed_tours, $show_unpublished_tours);
if (empty($steps)) {
	return;
}

elgg_require_js('tour_guide/site');

elgg_register_plugin_hook_handler('elgg.data', 'page', function(\Elgg\Hook $hook) use ($steps) {
	/* @var $data array */
	$data = $hook->getValue();
	
	$data['tour_guide']['steps'] = $steps;
	
	return $data;
});
