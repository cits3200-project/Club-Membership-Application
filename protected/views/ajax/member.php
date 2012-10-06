<?php 
	// configure the ajax variable.
	$i = (!empty($_GET['id']) && is_numeric($_GET['id']))
			? $_GET['id']
			: 0;
// html format ?>

<div class="membertile view" id="members_<?php echo $i; ?>">
	<div class="right">
		<?php echo CHtml::button('Remove member', array( 'class' => 'removeButton' )); ?>
	</div>
	<div class="row">
		<?php echo CHtml::label('First name', "members[{$i}][memberName]"); ?>
		<?php echo CHtml::textField("members[{$i}][memberName]"); ?>
	</div>
	<div class="row">
		<?php echo CHtml::label('Date of birth', "members[{$i}][birthDate]"); ?>
		<?php echo CHtml::textField("members[{$i}][birthDate]"); ?>
	</div>
	<div class="row">
		<?php echo CHtml::label('Gender', "members[{$i}][memberType]"); ?>
		<?php echo CHtml::dropDownList("members[{$i}][memberType]", 'AM', Member::getMemberTypes()); ?>
	</div>
</div>