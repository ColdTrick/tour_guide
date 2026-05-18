<?php

namespace ColdTrick\TourGuide;

/**
 * Export download
 *
 * @since 7.0
 */
class ExportController extends \Elgg\Controllers\JsonDownloadAction {

	protected \FeatureTour $entity;

	/**
	 * {@inheritdoc}
	 */
	protected function validate(): void {
		$this->entity = elgg_entity_gatekeeper((int) get_input('guid'), 'object', \FeatureTour::SUBTYPE, true);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getFilename(): string {
		return 'feature-tour-' . elgg_get_friendly_title(str_replace(':', '-', $this->entity->route_name)) . '.json';
	}
		
	/**
	 * {@inheritdoc}
	 */
	protected function getContents(): mixed {
		return [
			'route_name' => $this->entity->route_name,
			'title' => $this->entity->title,
			'published' => (bool) $this->entity->published,
			'steps_config' => $this->entity->getStepConfiguration(),
		];
	}
}
