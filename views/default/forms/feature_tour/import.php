<?php
/**
 * Import a tour export file for reuse
 */

$guid = (int) elgg_extract('guid', $vars);
if (!empty($guid)) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'guid',
		'value' => $guid,
	]);
	
	echo elgg_view_message('warning', elgg_echo('all steps will be overridden'));
}

echo elgg_view_field([
	'#type' => 'file',
	'#label' => elgg_echo('export file to import'),
	'name' => 'import',
	'required' => true,
]);

$footer = '';
$footer .= elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('import'),
]);

elgg_set_form_footer($footer);
