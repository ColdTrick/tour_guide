<?php

$plugin = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'switch',
	'#label' => elgg_echo('tour_guide:settings:finish_early'),
	'#help' => elgg_echo('tour_guide:settings:finish_early:help'),
	'name' => 'params[finish_early]',
	'value' => $plugin->finish_early,
]);
