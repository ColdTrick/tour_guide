define(function(require) {
	
	var Driver = require('tour_guide/driver/driver.min'); 
	var elgg = require('elgg');
	var Ajax = require('elgg/Ajax');
	
	// create new driver
	var driver = new Driver({
		doneBtnText: elgg.echo('complete'),
		closeBtnText: elgg.echo('close'),
		nextBtnText: elgg.echo('next'),
		prevBtnText: elgg.echo('previous'),
		padding: 0,
		opacity: .5,
		onNext: function (step) {
			if (step.options.guid) {
				report_completed_feature_tour(step.options.guid);
			}
		},
		onReset: function (step) {
			if (step.options.mark_completed_on_reset && step.options.guid) {
				report_completed_feature_tour(step.options.guid);
			}
		}
	});
	
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
