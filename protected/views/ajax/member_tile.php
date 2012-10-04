<?php 
	// configure the ajax variable.
	$i = (!empty($_GET['id']) && is_numeric($_GET['id']))
			? $_GET['id']
			: 0;
// html format ?>

<div class="membertile" id="members_<?php echo $i; ?>">
	<?php echo CHtml::label('Member name', "members[].memberName"); ?>
	<?php echo CHtml::textField("members[].memberName"); ?>
</div>