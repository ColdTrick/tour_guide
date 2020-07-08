<?php

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'guid',
	'value' => elgg_extract('guid', $vars),
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('route name'),
	'name' => 'route_name',
	'required' => true,
	'value' => elgg_extract('route_name', $vars),
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('title'),
	'name' => 'title',
	'value' => elgg_extract('title', $vars),
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
]);

elgg_set_form_footer($footer);
