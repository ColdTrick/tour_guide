define(function(require) {
	
	var Driver = require('tour_guide/driver/driver.min'); 
	var driver = new Driver();
	
	// Define the steps for introduction
	driver.defineSteps([
	  {
	    element: '.elgg-form-search',
	    popover: {
	      title: 'Search',
	      description: 'You can search here',
	      position: 'bottom'
	    }
	  },
	  {
	    element: '.elgg-page-topbar',
	    popover: {
	      title: 'Topbar',
	      description: 'Ohh nice menu mister',
	      position: 'bottom'
	    }
	  },
	  {
	    element: '#elgg-widget-content-9456',
	    popover: {
	      title: 'Important person',
	      description: 'Rate my boobies',
	      position: 'right'
	    }
	  }
	]);

	// Start the introduction
	driver.start();
	
});
