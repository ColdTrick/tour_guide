<?php

$params = [
	'byline' => false,
	'icon' => false,
];
$params = $params + $vars;

echo elgg_view('object/default', $params);
