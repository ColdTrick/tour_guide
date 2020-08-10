define(function(require) {
	var $ = require('jquery');
	var Ajax = require('elgg/Ajax');
	
	$(document).on('click', '.tour-guide-feature-tour-step-remove', function() {
		$(this).parents('.elgg-module').remove();
	});
	
	$(document).on('click', '#tour-guide-feature-tour-add-step', function() {
		var ajax = new Ajax();
		ajax.view('forms/feature_tour/step?template=1', {
			success: function(html) {
				$(html).appendTo($('.tour-guide-feature-tour-steps'));
			}
		});
	});
	
	$(document).on('click', '.elgg-menu-steps-edit > .elgg-menu-item-toggle', function() {
		$(this).parents('.elgg-module').find(' > .elgg-body').toggle();
	});
	
	function FeatureTour() {};
	
	FeatureTour.prototype = {};
	
	FeatureTour.initSteps = function(selector) {
		
		$(selector).sortable({
			items: '>div',
			start: function (event, ui) {
				if (typeof CKEDITOR !== 'undefined') {
					require(['elgg-ckeditor'], function(ckeditor) {
						ckeditor.toggle(ui.item.find('textarea'));
					});
				}
			},
			stop: function (event, ui) {
				if (typeof CKEDITOR !== 'undefined') {
					require(['elgg-ckeditor'], function(ckeditor) {
						ckeditor.toggle(ui.item.find('textarea'));
					});
				}
	        },
		});
	};
	
	return FeatureTour;
});