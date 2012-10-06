<?php
/*
 * variables
 * @var $this MembersController
 * @var $members array of MemberEdit models
 */
?>
<script type="text/javascript" language="Javascript">
	$(document).ready(function() {
		var counter = 0;
		$("#addMoreButton").click(function() {
			SwedishCore.addMoreFields('<?php echo Yii::app()->baseUrl; ?>/ajax/html?f=member', $(this).parent(), counter++);
		});
	});
</script>
<h3>Edit members</h3>
<?php 
if ($result['complete'])
	$this->renderPartial('/shared/_completedmessage', array('result' => $result));
?>

<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'members-form',
	'enableAjaxValidation'=>false,
)); 

foreach($members as $i=>$member)
{ ?>
	<div class="membertile view">
		<div class="row">
			
			<?php echo $form->labelEx($member, "[$i]memberName"); ?>
			<?php echo $form->textField($member, "[$i]memberName"); ?>
			<?php echo $form->error($member, "[$i]memberName"); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($member, "[$i]birthDate"); ?>
			<?php echo $form->textField($member, "[$i]birthDate"); ?>
			<?php echo $form->error($member, "[$i]birthDate"); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($member, "[$i]memberType"); ?>
			<?php echo $form->dropDownList($member, "[$i]memberType", Member::getMemberTypes()); ?>
			<?php echo $form->error($member, "[$i]memberType"); ?>
		</div>
	</div>
<?php
} ?>
	<div class="row">
		<?php echo CHtml::button('add member', array( 'id' => 'addMoreButton' )); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('save members'); ?>
	</div>
	<?php $this->endWidget(); ?>
</div>