$(document).ready(function() {
	SwedishCore.init();
	
	ddsmoothmenu.init({
		mainmenuid: "page_nav", //menu DIV id
		orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
		classname: 'ddsmoothmenu', //class added to menu's outer DIV
		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
	});
	
	var buttons = { previous:$('#lofslidecontent45 .lof-next') ,
					next:$('#lofslidecontent45 .lof-previous') };
					
	$obj = $('#lofslidecontent45').lofJSidernews( { 
		interval 		: 4000,
		direction		: 'opacitys',	
		easing			: 'easeInOutExpo',
		duration		: 1200,
		auto		 	: false,
		maxItemDisplay  : 4,
		navPosition     : 'horizontal', // horizontal
		navigatorHeight : 32,
		navigatorWidth  : 80,
		mainWidth		: 940,
		buttons			: buttons
	});
});

var SwedishCore = {
	// any singleton initialization that needs to be done.
    init : function() {
	
    },

	/**
	 * depends(jQuery,string,string,any)
	 *
	 * Simple dependecy function to show/hide HTML sections depending
	 * on the current value of a particular object. Most useful for
	 * branching forms where varying radio/checkbox selections determine
	 * the path a user will take through the form.
	 *
	 * @param targets a jQuery object containing the HTML nodes to hide/show depending on the value
	 * @dependsOnSelector a valid jQuery selector that is used to obtain the independent object
	 * @dependsValue the value of the object upon which the 'targets' will be shown. 
	 * @speed speed at which to show/hide the targets. This parameter can be any value valid within the jQuery $.show/hide functions (defaults to 0)
	 */
    depends : function(targets, dependsOnSelector, dependsValue, speed, negate) {
		if (typeof(speed) === "undefined")
			speed = 0;
		if (typeof(negate) === "undefined")
			negate = false;
			
        var dependent = $(dependsOnSelector);
		
		if (dependent.length > 0 && targets.length > 0) {
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
				SwedishCore.toggleDependency(targets, $(eventSelector), dependsValue, speed, negate);
			});
			
			SwedishCore.toggleDependency(targets, $(eventSelector), dependsValue, speed, negate);
		}
    },
	
	/**
	 * Toggle a dependency based on the current value of the dependent object
	 */
    toggleDependency : function(targets, dependent, value, speed, negate) {
		if (dependent.length > 0) {
			dependent.each(function(i,e) {
				if ((((value instanceof Array) && $.inArray(e.value, value) > -1) || (e.value == value)) != negate) {
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
    },
	
	defaultText : function(field) {
		if (field.defaultValue == field.value) 
			field.value = '';
		else if (field.value == '') 
			field.value = field.defaultValue;
	},
	
	/** 
	 * Adds a new field to the HTML document by performing an ajax call to a 
	 * specific page and then inserting the obtained HTML into the document
	 * before a particular HTML element. An 'id' GET parameter will be supplied
	 * to the page to describe the current index of the field.
	 *
	 * @param ajaxPath the URI to the remote document which returns valid HTML for the field.
	 * @param beforeElement jQuery object. The html received from ajaxPath will be inserted directly BEFORE this element
	 * @param index the index of the current field (usually an appropriate array index). This will be passed as a GET parameter to the ajax page
	 */
	addMoreFields : function(ajaxPath, beforeElement, index)  {
		if (beforeElement.length > 0 && ajaxPath !== null) {
			$.get(ajaxPath, { id : index }, function(data, textStatus, xhr) {
				beforeElement.before(data);
			});		
		}			
	},
};