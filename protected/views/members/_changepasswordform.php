<?php
/* @var $this MembershipController */
/* @var $model MemberChangePasswordForm */
/* @var $form CActiveForm */

$baseUrl = Yii::app()->baseUrl; 
//same css?
Yii::app()->clientScript->registerCssFile($baseUrl.'/css/registration.css');
?>


	<h3>Change your password</h3>
	<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'changePassword-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'password'); ?>
		<?php echo $form->passwordField($model, 'password', array('size'=>30,'maxlength'=>40)); ?>
		<?php echo $form->error($model, 'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'newPassword'); ?>
		<?php echo $form->passwordField($model, 'newPassword', array('size'=>30,'maxlength'=>40)); ?>
		<?php echo $form->error($model, 'newPassword'); ?>		
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'repeatNewPassword'); ?>
		<?php echo $form->passwordField($model, 'repeatNewPassword', array('size'=>30,'maxlength'=>40)); ?>
		<?php echo $form->error($model, 'repeatNewPassword'); ?>		
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Update'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
