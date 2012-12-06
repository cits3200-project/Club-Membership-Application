$(document).ready(function() {
	var core = SwedishCore || {};
	// set default selection if there isn't already one
	if ($("input[type=radio][name*=\\[type\\]]:checked").size() == 0)
		$("input[name=MailoutForm\\[type\\]]").trigger('click');
		
	core.depends($("#csvOption"), 'input[name=MailoutForm\\[type\\]]', "csv", "slow");
	core.depends($("#emailOption"), 'input[name=MailoutForm\\[type\\]]',  "email", "slow");
	core.depends($('#addAttachments'), '#attachmentsField input[type=file]:last', '', 0, true);
});
