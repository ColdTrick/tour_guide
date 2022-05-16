define(['tour_guide/driver/driver.min', 'elgg', 'elgg/i18n', 'elgg/Ajax'], function(Driver, elgg, i18n, Ajax) {
	
	// create new driver
	var driver_options = {
		doneBtnText: i18n.echo('complete'),
		closeBtnText: '<span onclick="$(this).parent().click()" title="' + i18n.echo('tour_guide:feature_tours:close:help') + '">' + i18n.echo('close') + '</span>',
		nextBtnText: i18n.echo('next'),
		prevBtnText: i18n.echo('previous'),
		
		padding: 0,
		opacity: .5,
		allowClose: false,
		keyboardControl: false,
		onNext: function (step) {
			if (step.options.guid) {
				step.options.mark_completed_on_reset = false; // mark as false to prevent double submission
				
				report_completed_feature_tour(step.options.guid);
			}
		},
		onReset: function (step) {
			if (step.options.mark_completed_on_reset && step.options.guid) {
				report_completed_feature_tour(step.options.guid);
			}
		}
	}

	if (elgg.data.tour_guide.steps[0].required) {
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
