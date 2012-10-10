<div id="templatemo_main">
	
   <h2>Contact Information</h2>
		<p>This is from the original website:</p>
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
			Mobile phone (Peter ThÃ¶nell): 0405 658 750  <br>
		</p>
		<hr />
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
		<h5>Peter Thönell</h5>						
		Phone: 0405 658 750<br />
					
		<div class="cleaner h40"></div>
		
		<h5>Website Administrator</h5>
					
		Email: <a href="mailto:web@svenskaklubben.org.au">web@svenskaklubben.org.au</a><br/>
	
		<div class="cleaner h40"></div>
		
		<h5>Svenska Posten</h5>
					
		Email: <a href="mailto:redaktor@svenskaklubben.org.au"> redaktor@svenskaklubben.org.au</a><br/>

	</div>
	
	<div class="cleaner h40"></div>
	
	<iframe width="940" height="320" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Central+Park,+New+York,+NY,+USA&amp;aq=0&amp;sll=14.093957,1.318359&amp;sspn=69.699334,135.263672&amp;vpsrc=6&amp;ie=UTF8&amp;hq=Central+Park,+New+York,+NY,+USA&amp;ll=40.778265,-73.96988&amp;spn=0.033797,0.06403&amp;t=m&amp;output=embed"></iframe>

	<div class="cleaner"></div>

</div>

<?php endif; ?>
