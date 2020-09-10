<?php

$title = get_input('title');
$route_name = get_input('route_name');
$published = (bool) get_input('published');
$required = (bool) get_input('required');

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
$tour->published = $published;
$tour->required = $required;

$steps = get_input('steps', [], false); // do not filter to allow correct selectors

$steps_config = [];
if (isset($steps['element'])) {
	foreach ($steps['element'] as $index => $value) {
		if (empty($value)) {
			continue;
		}
		
		$steps_config[] = json_encode([
			'element' => $value,
			'popover' => [
				'title' => filter_tags(elgg_extract($index, $steps['title'])),
				'description' => filter_tags(elgg_extract($index, $steps['description'])),
				'position' => elgg_extract($index, $steps['position']),
			],
		]);
	}
}

$tour->steps_config = $steps_config;

return elgg_ok_response('', elgg_echo('save:success'));
