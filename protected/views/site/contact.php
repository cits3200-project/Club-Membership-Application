<div id="templatemo_main">
	
   <h2>Contact Information</h2>
	<div class="half float_l">
		<h4>Send us a message</h4>
		<!--<div id="contact_form">-->
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
		</div>
	</div>
	<div class="half float_r">
		<h4>Contact Information</h4>
		<h5>Facebook</h5>
		<a href="http://www.facebook.com/groups/169714974189/">http://www.facebook.com/groups/169714974189/</a><br/>
		<div class="cleaner h40"></div>

		<h5>Membership questions</h5>
		Email: <a href="mailto:treasurer@svenskaklubben.org.au">treasurer@svenskaklubben.org.au</a><br/>
		<div class="cleaner h40"></div>

		<h5>Questions about the club</h5>
		Email: <a href="mailto:info@svenskaklubben.org.au">info@svenskaklubben.org.au</a><br/>
		<div class="cleaner h40"></div>

		<h5>Web site administrator</h5>
		Email: <a href="mailto:web@svenskaklubben.org.au">web@svenskaklubben.org.au</a><br/>
		<div class="cleaner h40"></div>

		<h5>Svenska Posten (mailout)</h5>
		Email: <a href="mailto:redaktor@svenskaklubben.org.au">redaktor@svenskaklubben.org.au</a><br/>
		<div class="cleaner h40"></div>

		<h5>Mobile phone (Peter Thönell)</h5>
		Phone: 0405 658 750 <br/>
		<div class="cleaner h40"></div>
	</div>
	
	<div class="cleaner h40"></div>

	<div class="cleaner"></div>

</div>

<?php endif; ?>
