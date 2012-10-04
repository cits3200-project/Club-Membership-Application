<?php
/* @var $this MembershipController */
/* @var $model RegistrationForm */
/* @var $form CActiveForm */

$baseUrl = Yii::app()->baseUrl; 
Yii::app()->clientScript->registerCssFile($baseUrl.'/css/registration.css');
?>

<div id="templatemo_main">
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'registration-form',
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
		<?php echo $form->labelEx($model, 'password'); ?>
		<?php echo $form->passwordField($model, 'password', array('size'=>30,'maxlength'=>40)); ?>
		<?php echo $form->error($model, 'password'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'repeatPassword'); ?>
		<?php echo $form->passwordField($model, 'repeatPassword', array('size'=>30,'maxlength'=>40)); ?>
		<?php echo $form->error($model, 'repeatPassword'); ?>		
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>30,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alternatePhone'); ?>
		<?php echo $form->textField($model,'alternatePhone',array('size'=>30,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'alternatePhone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->emailField($model,'email',array('size'=>30,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alternateEmail'); ?>
		<?php echo $form->emailField($model,'alternateEmail',array('size'=>30,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'alternateEmail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type', Membership::getMembershipTypes()); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>
	
	<div class="row properties">
		<?php echo $form->checkBoxList($model, 'properties', $model->getPropertyList(), array('uncheckValue' => NULL)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Register'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>