/* function depends
 * a very basic dependency function for items depending on either a radiobutton or a checkbox value.
 *
 * @param oId - The ID of the element that depends on a specific value.
 * @param depends - The id or name of the element of whose value oId's visibility depends on.
 * @param dependsIsId - true if the string given for 'depends' is an element id, false if the string is an element name.
 * @param val - The value that the element represented by oId depends on.
 */
function depends(oId,depends,dependsIsId,val,speed) {
	if (oId != null && depends != null && $("#" + oId).length > 0) {
		var selector = (dependsIsId ? "#" + depends : "input[name=" + depends + "]");
		if ($(selector).length > 0) {
			//configure the depends element's change function to toggle the dependent element's visibility
			$(selector).change(function() {
				if ($(selector + ":checked").length > 0) {
					var found = false;
					$(selector + ":checked").each(function(i,e) {
						if (((val instanceof Array) && $.inArray(e.value, val) > -1) || (e.value == val)) {
							$("#" + oId).show(speed);
							found = true;
						}
						else if (!found) {
							$("#" + oId).hide(speed);
						}
					});
				}
				else { 
					$("#" + oId).hide(speed); 
				}
			});
			$(selector).change(); //initialize.
		}
	}
}