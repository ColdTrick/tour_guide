<?php

/**
 * Custom class for Feature Tour
 *
 * @property int    $published    is the tour published to all users (1: yes, 0: no)
 * @property string $route_name   name of the route for this tour
 * @property array  $steps_config tour steps configuration (used for driver.js)
 */
class FeatureTour extends ElggObject {
	
	const SUBTYPE = 'feature_tour';
	
	/**
	 * {@inheritdoc}
	 */
	public function initializeAttributes() {
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
