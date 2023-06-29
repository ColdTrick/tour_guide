<?php

/**
 * Custom class for Feature Tour
 *
 * @property bool     $published    is the tour published to all users
 * @property bool     $required     are users required to finish this tour
 * @property string   $route_name   name of the route for this tour
 * @property string[] $steps_config tour steps configuration (used for driver.js, in JSON format)
 */
class FeatureTour extends \ElggObject {
	
	const SUBTYPE = 'feature_tour';
	
	/**
	 * {@inheritdoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$site = elgg_get_site_entity();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['owner_guid'] = $site->guid;
		$this->attributes['container_guid'] = $site->guid;
		$this->attributes['access_id'] = ACCESS_PUBLIC;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDisplayName(): string {
		$title = parent::getDisplayName();
		if (!empty($title)) {
			return $title;
		}
		
		return elgg_echo('object:feature_tour:title', [$this->route_name]);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getURL(): string {
		if (elgg_is_admin_logged_in()) {
			return elgg_normalize_url("admin/administer_utilities/feature_tour/save?guid={$this->guid}");
		}
		
		return '';
	}
	
	/**
	 * Return the number of users who have completed this tour
	 *
	 * @return int
	 */
	public function getCompleteCount(): int {
		return elgg_get_relationships([
			'count' => true,
			'relationship_guid' => $this->guid,
			'relationship' => 'done',
		]);
	}
	
	/**
	 * Return the step configuration
	 *
	 * @param bool $json_decoded should the result be json decode (default: true)
	 *
	 * @return array
	 */
	public function getStepConfiguration(bool $json_decoded = true): array {
		$config = (array) $this->steps_config;
		if (!$json_decoded) {
			return $config;
		}
		
		$result = [];
		foreach ($config as $step) {
			$result[] = json_decode($step, true);
		}
		
		return $result;
	}
}
