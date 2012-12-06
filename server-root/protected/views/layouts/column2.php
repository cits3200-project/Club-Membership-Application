<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/swedish'); ?>
<div id="sidebar">
<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>'Operations',
	));
	$this->widget('zii.widgets.CMenu', array(
		'items'=>$this->menu,
		'htmlOptions'=>array('class'=>'operations'),
	));
	$this->endWidget();
?>
</div><!-- sidebar -->
<div id="content">
	<?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>