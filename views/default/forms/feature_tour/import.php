<?php
/**
 * Import a tour export file for reuse
 */

echo elgg_format_element('h3', ['class' => ['elgg-divide-bottom', 'mbm']], elgg_echo('tour_guide:forms:import:title'));

$guid = (int) elgg_extract('guid', $vars);
if (!empty($guid)) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'guid',
		'value' => $guid,
	]);
	
	echo elgg_view_message('warning', elgg_echo('tour_guide:forms:import:warning'));
}

echo elgg_view_field([
	'#type' => 'file',
	'#label' => elgg_echo('tour_guide:forms:import:file'),
	'name' => 'import',
	'required' => true,
]);

$footer = '';
$footer .= elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('import'),
]);

elgg_set_form_footer($footer);
