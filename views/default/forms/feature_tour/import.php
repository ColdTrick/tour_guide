<?php
/**
 * Import a tour export file for reuse
 */

$body = '';
$guid = (int) elgg_extract('guid', $vars);
if (!empty($guid)) {
	$body .= elgg_view_field([
		'#type' => 'hidden',
		'name' => 'guid',
		'value' => $guid,
	]);

	$body .= elgg_view_message('warning', elgg_echo('tour_guide:forms:import:warning'));
}

$body .= elgg_view_field([
	'#type' => 'file',
	'#label' => elgg_echo('tour_guide:forms:import:file'),
	'name' => 'import',
	'required' => true,
]);

$body .= elgg_view_field([
	'#type' => 'submit',
	'text' => elgg_echo('import'),
]);

echo elgg_view_module('info', elgg_echo('tour_guide:forms:import:title'), $body);
