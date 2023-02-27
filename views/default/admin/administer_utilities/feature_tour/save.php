<?php
$vars['entity'] = get_entity((int) get_input('guid'));

echo elgg_view_form('feature_tour/save', [], $vars);
