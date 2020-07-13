<?php
/**
 * Import a tour (or only the steps configuration)
 */

use Symfony\Component\HttpFoundation\File\UploadedFile;

$guid = (int) get_input('guid');
$file = elgg_get_uploaded_file('import');
if (!$file instanceof UploadedFile) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$file_contents = file_get_contents($file->getPathname());
if (empty($file_contents)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$configuration = json_decode($file_contents, true);
if (empty($configuration) || !isset($configuration['route_name'])) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

if (empty($configuration['steps_config'])) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

if (!empty($guid)) {
	$entity = get_entity($guid);
	if (!$entity instanceof FeatureTour || !$entity->canEdit()) {
		return elgg_error_response(elgg_echo('actionunauthorized'));
	}
} else {
	 $entity = new FeatureTour();
	 
	 $entity->title = elgg_extract('title', $configuration);
	 $entity->route_name = elgg_extract('route_name', $configuration);
	 $entity->published = (bool) elgg_extract('published', $configuration, false);
}

$steps = elgg_extract('steps_config', $configuration);
$steps_config = [];
foreach ($steps as $step) {
	$steps_config[] = json_encode($step);
}

$entity->steps_config = $steps_config;

if (!$entity->save()) {
	return elgg_error_response(elgg_echo('tour_guide:action:import:failed'));
}

return elgg_ok_response('', elgg_echo('tour_guide:action:import:success'));
