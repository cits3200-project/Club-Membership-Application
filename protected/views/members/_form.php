<?php
/* @var $this MembershipController */
/* @var $model Membership */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'membership-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'familyName'); ?>
		<?php echo $form->textField($model,'familyName',array('size'=>30,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'familyName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phoneNumber'); ?>
		<?php echo $form->textField($model,'phoneNumber',array('size'=>30,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'phoneNumber'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alternatePhone'); ?>
		<?php echo $form->textField($model,'alternatePhone',array('size'=>30,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'alternatePhone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'emailAddress'); ?>
		<?php echo $form->emailField($model,'emailAddress',array('size'=>30,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'emailAddress'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alternateEmail'); ?>
		<?php echo $form->emailField($model,'alternateEmail',array('size'=>30,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'alternateEmail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $action != "edit"
					? $form->dropDownList($model,'type', Membership::getMembershipTypes())
					: $form->; ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'expiryDate'); ?>
		<?php echo $form->dateField($model,'expiryDate'); ?>
		<?php echo $form->error($model,'expiryDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payMethod'); ?>
		<?php echo $form->dropDownList($model,'payMethod',PaymentMethod::getPaymentMethods()); ?>
		<?php echo $form->error($model,'payMethod'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',MembershipStatus::getMembershipStatuses()); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->