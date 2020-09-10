<?php

$guid = elgg_extract('guid', $vars);

$form_title = $guid ? 'edit:object:feature_tour' : 'add:object:feature_tour';
echo elgg_format_element('h3', ['class' => ['elgg-divide-bottom', 'mbm']], elgg_echo($form_title));

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'guid',
	'value' => $guid,
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('tour_guide:forms:save:route_name'),
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

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('status:published'),
	'name' => 'published',
	'value' => 1,
	'checked' => (bool) elgg_extract('published', $vars),
	'switch' => true,
]);

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('tour_guide:forms:save:required'),
	'name' => 'required',
	'value' => 1,
	'checked' => (bool) elgg_extract('required', $vars),
	'switch' => true,
]);

$steps = (array) elgg_extract('steps', $vars, []);

$steps_list = '';
foreach ($steps as $step) {
	$steps_list .= elgg_view('forms/feature_tour/step', ['step' => $step]);
}

if (empty($steps)) {
	$steps_list .= elgg_view('forms/feature_tour/step', []);
}

$steps_id = uniqid('steps_');
echo elgg_format_element('div', ['id' => $steps_id, 'class' => 'tour-guide-feature-tour-steps'], $steps_list);

echo elgg_view_field([
	'#type' => 'button',
	'icon' => 'plus',
	'value' => elgg_echo('tour_guide:forms:save:steps:add'),
	'id' => 'tour-guide-feature-tour-add-step',
	'class' => 'elgg-button-action',
]);

echo elgg_format_element('script', [], 'require(["forms/feature_tour/save"], function(FeatureTour) { FeatureTour.initSteps("#' . $steps_id . '"); });');

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
]);

elgg_set_form_footer($footer);
