<?php

/**
 * Custom class for Feature Tour
 *
 * @property string $route_name name of the route for this tour
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
		return false;
	}
	
	/**
	 * {@inheritDoc}
	 * @see ElggObject::canComment()
	 */
	public function canComment($user_guid = 0, $default = null) {
		return false;
	}
}
