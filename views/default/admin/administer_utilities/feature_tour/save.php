<?php

elgg_push_breadcrumb(elgg_echo('admin:administer_utilities:feature_tours'), 'admin/administer_utilities/feature_tours');

$vars['entity'] = get_entity((int) get_input('guid'));

echo elgg_view_form('feature_tour/save', [], $vars);
