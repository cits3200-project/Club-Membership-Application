$(document).ready(function() {
	SwedishCore.init();
});

var SwedishCore = {
	// any singleton initialization that needs to be done.
    init : function() {
	
    },

	// simple dependency function
    depends : function(objectSelector, dependsOnSelector, dependsValue, speed) {
        var targets = $(objectSelector);
        var dependent = $(dependsOnSelector);
		
		if (dependent.length > 0) {
			var eventName = 'change';
			var eventSelector = dependsOnSelector;
			
			// special case handling for Radio/Checkbox elements.
			if ( (dependent[0].nodeName || '').toLowerCase() == "input" && (dependent.attr("type") === "radio" || dependent.attr("type") === "checkbox") ) {
				if ($.browser.msie) {
					eventName = 'click';
				}
				eventSelector += ":checked";
			}
			
			dependent.bind(eventName, function(e) {
				SwedishCore.toggleDependency(targets, $(eventSelector), dependsValue, speed);
			});
			
			SwedishCore.toggleDependency(targets, $(eventSelector), dependsValue, speed);
		}
    },
	
    toggleDependency : function(targets, dependent, value, speed) {
		if (dependent.length > 0) {
			dependent.each(function(i,e) {
				if (((value instanceof Array) && $.inArray(e.value, value) > -1) || (e.value == value)) {
					targets.show(speed);
					return false; // break from the 'each' to avoid hiding after a value is already found
				}
				else {
					targets.hide(speed);
				}
			});
		}
		else {
			targets.hide(speed);	
		}	
    }
};