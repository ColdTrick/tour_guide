<?php
/**
 * Object view for a feature tour
 *
 * @uses $vars['entity'] the feature tour
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof FeatureTour) {
	return;
}

$imprint = (array) elgg_extract('imprint', $vars, []);

$imprint[] = [
	'icon' => 'users',
	'content' => elgg_echo('object:feature_tour:complete_count', [$entity->getCompleteCount()]),
];

if (!$entity->published) {
	$imprint[] = [
		'content' => elgg_echo('status:unpublished'),
	];
}

$params = [
	'byline' => false,
	'icon' => false,
	'imprint' => $imprint,
];
$params = $params + $vars;

echo elgg_view('object/default', $params);
