<?php

$step = elgg_extract('step', $vars, []);
$is_template = elgg_extract('template', $vars);

$result = elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('tour_guide:forms:save:step:element'),
	'#help' => parse_urls(elgg_echo('tour_guide:forms:save:step:element:help')),
	'name' => 'steps[element][]',
	'value' => elgg_extract('element', $step),
]);

$result .= elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('title'),
	'name' => 'steps[title][]',
	'value' => elgg_extract('title', $step),
]);

$result .= elgg_view_field([
	'#type' => 'longtext',
	'#label' => elgg_echo('description'),
	'name' => 'steps[description][]',
	'value' => elgg_extract('description', $step),
]);

$result .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('tour_guide:forms:save:step:position'),
	'options_values' => [
		'bottom' => elgg_echo('bottom'),
		'left' => elgg_echo('left'),
		'right' => elgg_echo('right'),
		'top' => elgg_echo('top'),
	],
	'name' => 'steps[position][]',
	'value' => elgg_extract('position', $step),
]);

$menu = elgg_view_menu('steps_edit', [
	'class' => 'elgg-menu-hz',
	'items' => [
		[
			'name' => 'toggle',
			'text' => elgg_echo('tour_guide:forms:save:step:toggle'),
			'icon' => 'hand-point-down-regular',
			'href' => false,
		],
		[
			'name' => 'delete',
			'text' => elgg_echo('tour_guide:forms:save:step:remove'),
			'icon' => 'delete',
			'href' => false,
			'class' => ['tour-guide-feature-tour-step-remove', 'mlm'],
		],
	],
]);

$module_title = elgg_extract('title', $step) ?: elgg_echo('tour_guide:forms:save:step');

$classes = ['tour-guide-feature-tour-step'];
if ($is_template) {
	$classes[] = 'tour-guide-feature-tour-step-template';
} elseif ($step) {
	$classes[] = 'tour-guide-feature-tour-step-existing';
}

echo elgg_view_module('info', $module_title, $result, [
	'menu' => $menu,
	'class' => $classes,
]);
