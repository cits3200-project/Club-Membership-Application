<?php
	
/**
 * MembershipForm
 * Base class for forms that update the Membership model,
 * All fields in this class are editable ("chosen") by the owner of the
 * membership, but not neccessarily the admin.
 */
class MembershipChosenForm extends MembershipForm
{

	// user properties.
	public $receiveGeneralNews;
	public $receiveAdminEmail;
	public $receiveExpiryNotice;
	public $receiveEventInvites;

	/**
	 * Declares the validation rules.
	 * Any rules from the parent form class are inherited.
	 * The rules state that any "Toggle properites" (yes/no) must be a 'Y' or
	 * an 'N'.
	 */
	public function rules()
	{
		return array_merge(
			//inherit parent's rules
			parent::rules(),
			array (
				array (implode(', ', $this->getToggleProperties()), 'in', 'range' => array('Y','N')),
			)
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array_merge(
			//inherit parent's rules
			parent::attributeLabels(),
			array (
				'receiveGeneralNews' => 'Receive General News',
				'receiveAdminEmail' => 'Receive Email from Administrators',
				'receiveExpiryNotice' => 'Receive Expiry Notices',
				'receiveEventInvites' => 'Receive Event Invites'
			)
		);
	}

	/**
	 * Defines which properties are "toggle properties".
	 * Toggle properites must be 'Y' (yes) or 'N' (no).
	 */
	public function getToggleProperties()
	{
		return array(
			'receiveGeneralNews',
			'receiveAdminEmail',
			'receiveExpiryNotice',
			'receiveEventInvites',			
		);
	}
}
?>
