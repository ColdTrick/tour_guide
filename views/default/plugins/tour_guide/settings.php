<?php

$plugin = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('tour_guide:settings:finish_early'),
	'#help' => elgg_echo('tour_guide:settings:finish_early:help'),
	'name' => 'params[finish_early]',
	'value' => 1,
	'checked' => (bool) $plugin->finish_early,
	'switch' => true,
]);
