define(function(require) {
	
	var Driver = require('tour_guide/driver/driver.min'); 
	var elgg = require('elgg');
	var Ajax = require('elgg/Ajax');
	
	// create new driver
	var driver_options = {
		doneBtnText: elgg.echo('complete'),
		closeBtnText: '<span title="' + elgg.echo('tour_guide:feature_tours:close:help') + '" style="pointer-events: none">' + elgg.echo('close') + '</span>',
		nextBtnText: elgg.echo('next'),
		prevBtnText: elgg.echo('previous'),
		
		padding: 0,
		opacity: .5,
		onNext: function (step) {
			if (step.options.guid) {
				report_completed_feature_tour(step.options.guid);
			}
		},
		onReset: function (step, event) {
			if (step.options.mark_completed_on_reset && step.options.guid) {
				report_completed_feature_tour(step.options.guid);
			}
		}
	}
	
	if (elgg.data.tour_guide.steps[0].required) {
		driver_options.allowClose = false;
		driver_options.keyboardControl = false;
		if (elgg.data.tour_guide.steps.length > 1) {
			driver_options.className = 'feature-tour-required';
		}
	}
	
	var driver = new Driver(driver_options);
	
	// Define the steps for introduction
	driver.defineSteps(elgg.data.tour_guide.steps);

	// Start the introduction
	driver.start();
	
	var report_completed_feature_tour = function (guid) {
		var ajax = new Ajax(false);
		
		ajax.action('feature_tour/complete', {
			data: {
				guid: guid
			},
			showErrorMessages: false,
			showSuccessMessages: false,
		});
	};
});
