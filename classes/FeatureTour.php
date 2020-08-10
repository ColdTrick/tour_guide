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
	 * {@inheritDoc}
	 * @see ElggEntity::initializeAttributes()
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
	 * {@inheritDoc}
	 */
	public function getDisplayName() {
		if (!empty($this->title)) {
			return $this->title;
		}
		
		return elgg_echo('object:feature_tour:title', [$this->route_name]);
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getURL() {
		if (elgg_is_admin_logged_in()) {
			return elgg_normalize_url("admin/administer_utilities/feature_tour/save?guid={$this->guid}");
		}
		
		return false;
	}
	
	/**
	 * {@inheritDoc}
	 * @see ElggObject::canComment()
	 */
	public function canComment($user_guid = 0, $default = null) {
		return false;
	}
	
	/**
	 * Return the number of users who have completed this tour
	 *
	 * @return int
	 */
	public function getCompleteCount() {
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
	public function getStepConfiguration(bool $json_decoded = true) {
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
