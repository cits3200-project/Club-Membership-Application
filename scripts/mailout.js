$(document).ready(function() {
	// set default selection if there isn't already one
	if ($("input[type=radio][name*=\\[type\\]]:checked").size() == 0)
		$("input[name=MailoutForm\\[type\\]]").trigger('click');
		
	depends("csvOption", 'MailoutForm\\[type\\]', false, "csv", "slow");
	depends("emailOption", 'MailoutForm\\[type\\]', false, "email", "slow");
});
