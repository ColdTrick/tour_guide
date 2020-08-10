<?php

namespace ColdTrick\TourGuide;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::init()
	 */
	public function init() {
		elgg_register_ajax_view('forms/feature_tour/import');
		elgg_register_ajax_view('forms/feature_tour/step');
	}
}
