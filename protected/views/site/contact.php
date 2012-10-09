<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Contact',
);
?>

<h2>Contact Us</h2>

<p>
If you have inquiries or other questions, please use one of the following contacts, or fill out the following form below. Thank you.
</p>
<hr />

<p>
Facebook: <a href="http://www.facebook.com/groups/169714974189/">http://www.facebook.com/groups/169714974189/</a> <br>
	<br>
	Membership questions: <a href="mailto:treasurer@svenskaklubben.org.au">treasurer@svenskaklubben.org.au</a> <br>
	<br>
	Questions about the club: <a href="mailto:info@svenskaklubben.org.au">info@svenskaklubben.org.au</a> <br>
	<br>
	Web site administrator: <a href="mailto:web@svenskaklubben.org.au">web@svenskaklubben.org.au</a> <br>
	<br>
	Svenska Posten (mailout): <a href="mailto:redaktor@svenskaklubben.org.au">redaktor@svenskaklubben.org.au</a> <br>
	<br>
	Mobile phone (Peter Thönell): 0405 658 750  <br>
</p>
<hr />

<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'body'); ?>
	</div>

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

	<div class="row buttons">
		<?php echo CHtml::submitButton('Send'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<div class="half float_r">
	<h4>Contact Information</h4>
	<h5>Peter Thönell</h5>						
	Phone: 0405 658 750<br />
	<div class="cleaner h40"></div>
	<h5>Website Administrator</h5>
	Email: <a href="mailto:web@svenskaklubben.org.au">web@svenskaklubben.org.au</a><br/>
	<div class="cleaner h40"></div>
	<h5>Svenska Posten</h5>
	Email: <a href="mailto:redaktor@svenskaklubben.org.au"> redaktor@svenskaklubben.org.au</a><br/>
</div>

<?php endif; ?>
