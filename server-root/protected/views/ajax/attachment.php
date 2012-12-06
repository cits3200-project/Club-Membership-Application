<?php 
	// configure the ajax variable.
	$i = (!empty($_GET['id']) && is_numeric($_GET['id']))
			? $_GET['id']
			: 0;
// html format ?>
<div class="row">
	<?php echo CHtml::fileField("attachments[{$i}]"); ?>
</div>
