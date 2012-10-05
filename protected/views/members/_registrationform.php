<?php
/* @var $this MembershipController */
/* @var $model RegistrationForm */
/* @var $form CActiveForm */

$baseUrl = Yii::app()->baseUrl; 
Yii::app()->clientScript->registerCssFile($baseUrl.'/css/registration.css');
?>


	<h3>Register for the Swedish Club of WA</h3>
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
		<?php echo $form->dropDownList($model,'type', Membership::getMembershipTypes()); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>
	
<?php
	foreach($model->getToggleProperties() as $property) 
	{ ?>
	<div class="row properties"><?php
		echo $form->checkbox($model,$property,array(
			'value' => 'Y', 'uncheckValue' => 'N'
		));
		echo $form->label($model,$property);
		echo $form->error($model,$property);?>
	</div><?php
	} 
?>	
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Register'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->