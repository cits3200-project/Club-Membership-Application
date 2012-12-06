<?php
/* @var $this MembershipController */
/* @var $model Membership */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('membershipId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->membershipId), array('view', 'id'=>$data->membershipId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('familyName')); ?>:</b>
	<?php echo CHtml::encode($data->familyName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phoneNumber')); ?>:</b>
	<?php echo CHtml::encode($data->phoneNumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alternatePhone')); ?>:</b>
	<?php echo CHtml::encode($data->alternatePhone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('emailAddress')); ?>:</b>
	<?php echo CHtml::encode($data->emailAddress); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alternateEmail')); ?>:</b>
	<?php echo CHtml::encode($data->alternateEmail); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expiryDate')); ?>:</b>
	<?php echo CHtml::encode($data->expiryDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payMethod')); ?>:</b>
	<?php echo CHtml::encode($data->payMethod); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>