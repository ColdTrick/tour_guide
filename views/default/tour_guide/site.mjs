import 'elgg';
import i18n from 'elgg/i18n';
import Ajax from 'elgg/Ajax';
import { driver } from 'tour_guide/driver/driver.js';

// create new driver
var driver_options = {
	doneBtnText: i18n.echo('complete'),
	nextBtnText: i18n.echo('next'),
	prevBtnText: i18n.echo('previous'),
	
	allowClose: false,
	onNextClick: function (element, step) {
		if (step.guid) {
			step.mark_completed_on_reset = false; // mark as false to prevent double submission
			
			report_completed_feature_tour(step.guid);
		}
		
		myDriver.moveNext()
	},
	onCloseClick: function (element, step) {
		if (step.mark_completed_on_reset && step.guid) {
			report_completed_feature_tour(step.guid);
		}
	}
}

if (elgg.data.tour_guide.steps[0].required) {
	if (elgg.data.tour_guide.steps.length > 1) {
		driver_options.popoverClass = 'feature-tour-required';
	}
}

var steps = elgg.data.tour_guide.steps;
var myDriver = driver({
	...driver_options,
	steps
});

// Start the introduction
myDriver.drive();

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
