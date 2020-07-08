<?php

$title = get_input('title');
$route_name = get_input('route_name');

if (empty($route_name)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$guid = get_input('guid');
if (!empty($guid)) {
	$tour = get_entity($guid);
	if (!$tour instanceof \FeatureTour || !$tour->canEdit()) {
		return elgg_error_response(elgg_echo('actionunauthorized'));
	}
} else {
	$tour = new FeatureTour();
	$tour->save();
}

$tour->title = $title;
$tour->route_name = $route_name;

return elgg_ok_response('', elgg_echo('save:success'));
