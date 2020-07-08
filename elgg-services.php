<?php

use ColdTrick\TourGuide\Di\TourGuideService;

return [
	TourGuideService::name() => Di\object(TourGuideService::class)
		->constructor(Di\get('session')),
];