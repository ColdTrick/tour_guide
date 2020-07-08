define(function(require) {
	var $ = require('jquery');
	
	$(document).on('click', '.tour-guide-feature-tour-step-remove', function() {
		$(this).parents('.elgg-module').remove();
		$.colorbox.resize();
	});
	
	$(document).on('click', '#tour-guide-feature-tour-add-step', function() {
		$('.tour-guide-feature-tour-step-template').clone().appendTo($('.tour-guide-feature-tour-steps')).removeClass('tour-guide-feature-tour-step-template hidden');
		$.colorbox.resize();
	});
	
	$(document).on('click', '.elgg-menu-steps-edit > .elgg-menu-item-toggle', function() {
		$(this).parents('.elgg-module').find(' > .elgg-body').toggle();
		$.colorbox.resize();
	});
	
	function FeatureTour() {};
	
	FeatureTour.prototype = {};
	
	FeatureTour.initSteps = function(selector) {
		
		$(selector).sortable({
			items: '>div'
		});
	};
	
	return FeatureTour;
});