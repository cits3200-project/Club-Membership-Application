<?php
/* @var $this MembershipController */
/* @var $model Membership */
?>

<div class="view">
	<b><?php echo CHtml::encode($data->getAttributeLabel('membershipId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->membershipId), array('edit', 'id'=>$data->membershipId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phoneNumber')); ?>:</b>
	<?php echo CHtml::encode($data->phoneNumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('emailAddress')); ?>:</b>
	<?php echo CHtml::encode($data->emailAddress); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expiryDate')); ?>:</b>
	<?php echo CHtml::encode($data->expiryDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

</div>