<?php
	
/**
 * MembershipForm
 * Base class for forms that update the Membership model,
 * with field editable ("chosen") by the owner of the membership.
 */
class MembershipChosenForm extends MembershipForm
{

	// user properties.
	public $receiveGeneralNews;
	public $receiveAdminEmail;
	public $receiveExpiryNotice;
	public $receiveEventInvites;

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
