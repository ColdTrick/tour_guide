<?php

use ColdTrick\TourGuide\Di\TourGuideService;

return [
	TourGuideService::name() => Di\create(TourGuideService::class)
		->constructor(Di\get('session')),
];
