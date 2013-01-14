<?php

/**
 * MembershipEditForm
 */
class MembershipEditForm extends MembershipChosenForm
{
	// this method is detected in the membershipform view and will cause these
	// properties to be displayed
	public function getDisplayOnlyKeys() {
		return array(
			'expiryDate',
			'type',
			'status',
		);
	}
}
?>
