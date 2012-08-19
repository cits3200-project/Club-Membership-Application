<?php
/* @var $this MembershipController */
/* @var $model Membership */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('membershipId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->membershipId), 'view?id='.$data->membershipId, array('id'=>$data->membershipId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('emailAddress')); ?>:</b>
	<?php echo CHtml::encode($data->emailAddress); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alternateEmail')); ?>:</b>
	<?php echo CHtml::encode($data->alternateEmail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('familyName')); ?>:</b>
	<?php echo CHtml::encode($data->familyName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('membershipName')); ?>:</b>
	<?php echo CHtml::encode($data->membershipName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('suburb')); ?>:</b>
	<?php echo CHtml::encode($data->suburb); ?>
	<br />
	<?php
	/*
	<b><?php echo CHtml::encode($data->getAttributeLabel('postcode')); ?>:</b>
	<?php echo CHtml::encode($data->postcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('state')); ?>:</b>
	<?php echo CHtml::encode($data->state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phoneNumber')); ?>:</b>
	<?php echo CHtml::encode($data->phoneNumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('membershipStatus')); ?>:</b>
	<?php echo CHtml::encode($data->membershipStatus); ?>
	<br />

	*/ ?>

</div>