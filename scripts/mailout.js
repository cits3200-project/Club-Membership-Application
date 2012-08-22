$(document).ready(function() {
	depends("csvOption", 'mailout\\[type\\]', false, "csv", "fast");
	depends("emailOption", 'mailout\\[type\\]', false, "email", "fast");
});