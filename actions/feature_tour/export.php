<?php
/**
 * Export a feature tour configuration so it can be imported elsewhere
 */

$guid = get_input('guid');

if (empty($guid)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$entity = get_entity($guid);
if (!$entity instanceof FeatureTour || !$entity->canEdit()) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

$result = json_encode([
	'route_name' => $entity->route_name,
	'title' => $entity->title,
	'published' => (bool) $entity->published,
	'steps_config' => $entity->getStepConfiguration(),
], JSON_PRETTY_PRINT);

header('Content-Type: application/json');
header('Content-Length: ' . strlen($result));
header('Content-Disposition: attachment; filename="feature-tour-' . elgg_get_friendly_title(str_replace(':', '-', $entity->route_name)) . '.json"');
header('Pragma: public');

echo $result . PHP_EOL;
exit();
