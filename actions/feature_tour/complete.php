<?php
/**
 * Register a feature tour as complete
 */

use ColdTrick\TourGuide\Di\TourGuideService;

$guid = (int) get_input('guid');

$entity = get_entity($guid);
if (!$entity instanceof FeatureTour) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$user = elgg_get_logged_in_user_entity();

if (check_entity_relationship($entity->guid, 'done', $user->guid)) {
	// already completed
	return elgg_ok_response(elgg_echo('save:success'));
}

if (!$entity->addRelationship($user->guid, 'done')) {
	return elgg_error_response(elgg_echo('save:fail'));
}

// remove from session
TourGuideService::instance()->trackCompletedTour($entity);

return elgg_ok_response(elgg_echo('save:success'));
