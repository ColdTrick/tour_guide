<?php
/**
 * Reset the completed state of a tour for all users
 */

$guid = get_input('guid');

if (empty($guid)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$entity = get_entity($guid);
if (!$entity instanceof FeatureTour || !$entity->canEdit()) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

remove_entity_relationships($entity->guid, 'done');

return elgg_ok_response('', elgg_echo('tour_guide:action:reset:success'));
