<?php

elgg_register_menu_item('title', [
	'name' => 'add',
	'icon' => 'plus',
	'text' => elgg_echo('add'),
	'href' => 'ajax/form/feature_tour/save',
	'link_class' => [
		'elgg-button',
		'elgg-button-action',
		'elgg-lightbox',
	],
	'data-colorbox-opts' => json_encode([
		'width' => '800px',
	]),
]);

echo elgg_view('output/longtext', [
	'value' => elgg_echo('tour_guide:feature_tours:intro'),
]);

echo elgg_list_entities([
	'type' => 'object',
	'subtype' => \FeatureTour::SUBTYPE,
]);
