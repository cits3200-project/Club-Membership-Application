<?php
 /** variables
  * @var result Form result structure.
  */
  
if ($result['complete'])
{
	$this->renderPartial('//shared/_completedmessage', array(
		'result' => $result
	));
}

?>
<div class="form">
	<?php echo CHtml::beginForm('', 'get'); ?>
	<div class="row">
		<?php echo CHtml::label('Enter either your unique Membership ID, or the email address you used when creating your account', 'q'); ?>
		<?php echo CHtml::textField('q'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Reset Password'); ?>
	</div>
	<?php echo CHtml::endForm(); ?>
</div>
