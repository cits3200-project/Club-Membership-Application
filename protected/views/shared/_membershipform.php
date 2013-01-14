<?php
/* @var $this CController */
/* @var $model MemberForm */
/* @var $form CActiveForm */
/* @var $heading */
/* @var $id */
/* @var $submit_label */

$baseUrl = Yii::app()->baseUrl;
Yii::app()->clientScript->registerCssFile($baseUrl.'/css/registration.css');
?>


	<h2><?php echo $heading ?></h2>
	<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>$id,
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<?php if (array_key_exists('name', $model)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
<?php } ?>

<?php if (array_key_exists('familyName', $model)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'familyName'); ?>
		<?php echo $form->textField($model,'familyName',array('size'=>30,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'familyName'); ?>
	</div>
<?php } ?>

<?php if (array_key_exists('password', $model)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model, 'password'); ?>
		<?php echo $form->passwordField($model, 'password', array('size'=>30,'maxlength'=>40)); ?>
		<?php echo $form->error($model, 'password'); ?>
	</div>
<?php } ?>

<?php if (array_key_exists('repeatPassword', $model)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model, 'repeatPassword'); ?>
		<?php echo $form->passwordField($model, 'repeatPassword', array('size'=>30,'maxlength'=>40)); ?>
		<?php echo $form->error($model, 'repeatPassword'); ?>
	</div>
<?php } ?>

<?php if (array_key_exists('phoneNumber', $model)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'phoneNumber'); ?>
		<?php echo $form->textField($model,'phoneNumber',array('size'=>30,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'phoneNumber'); ?>
	</div>
<?php } ?>

<?php if (array_key_exists('alternatePhone', $model)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'alternatePhone'); ?>
		<?php echo $form->textField($model,'alternatePhone',array('size'=>30,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'alternatePhone'); ?>
	</div>
<?php } ?>

<?php if (array_key_exists('emailAddress', $model)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'emailAddress'); ?>
		<?php echo $form->emailField($model,'emailAddress',array('size'=>30,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'emailAddress'); ?>
	</div>
<?php } ?>

<?php if (array_key_exists('alternateEmail', $model)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'alternateEmail'); ?>
		<?php echo $form->textField($model,'alternateEmail',array('size'=>30,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'alternateEmail'); ?>
	</div>
<?php } ?>

<?php if (array_key_exists('postName', $model)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'postName'); ?>
		<?php echo $form->textField($model,'postName',array('size'=>30,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'postName'); ?>
	</div>
<?php } ?>

<?php if (array_key_exists('postalAddress', $model)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'postalAddress'); ?>
		<?php echo $form->textField($model,'postalAddress',array('size'=>30,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'postalAddress'); ?>
	</div>
<?php } ?>

<?php if (array_key_exists('postalSuburb', $model)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'postalSuburb'); ?>
		<?php echo $form->textField($model,'postalSuburb',array('size'=>30,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'postalSuburb'); ?>
	</div>
<?php } ?>

<?php if (array_key_exists('postalState', $model)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'postalState'); ?>
		<?php echo $form->dropDownList($model,'postalState', Membership::getPostalStates()); ?>
		<?php echo $form->error($model,'postalState'); ?>
	</div>
<?php } ?>

<?php if (array_key_exists('postcode', $model)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'postcode'); ?>
		<?php echo $form->textField($model,'postcode',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'postcode'); ?>
	</div>
<?php } ?>

<?php if (array_key_exists('expiryDate', $model)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'expiryDate'); ?>
		<?php echo $form->dateField($model,'expiryDate'); ?>
		<?php echo $form->error($model,'expiryDate'); ?>
	</div>	
<?php } ?>

<?php if (array_key_exists('payMethod', $model)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'payMethod'); ?>
		<?php echo $form->dropDownList($model,'payMethod', PaymentMethod::getPaymentMethods()); ?>
		<?php echo $form->error($model,'payMethod'); ?>
	</div>
<?php } ?>

<?php if (array_key_exists('payMethod', $model)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type', Membership::getMembershipTypes()); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>
<?php } ?>

<?php if (array_key_exists('status', $model)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', MembershipStatus::getMembershipStatuses()); ?>
		<?php echo $form->error($model,'status'); ?>		
	</div>
<?php } ?>

<?php if (method_exists($model, 'getToggleProperties')) {
	foreach($model->getToggleProperties() as $property)
	{ ?>
	<div class="row properties"><?php
		echo $form->checkbox($model,$property,array(
			'value' => 'Y', 'uncheckValue' => 'N'
		));
		echo $form->label($model,$property);
		echo $form->error($model,$property);?>
		</div>
<?php } ?>

<?php if (method_exists($model, 'getDisplayOnlyKeys')) { ?>
	<?php foreach($model->getDisplayOnlyKeys() as $key) {?>
	<?php $property = $model->displayOnlyProperties[$key]; ?>
	<div class="row">
	<?php echo $form->labelEx($model,"$key"); ?>
		<div>
			<?php if ($key == 'type')
				echo Membership::getMembershipTypes()[$property];
			else echo $property; ?>
		</div>
	</div>
	<?php } ?>
<?php } ?>

<?php if (array_key_exists('verifyCode', $model)) { ?>
	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		</div>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
		<?php echo $form->error($model,'verifyCode'); ?>
	</div>
	<?php endif; ?>
<?php } ?>

<?php
}
?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($submit_label); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
