<?php
/* @var $this MembershipController */
/* @var $model Membership */
/* @var $result array containing information about the form result */
$this->breadcrumbs=array(
	'Members'=>array('.'),
	'Edit Details',
);?>
<div id="templatemo_main"><?php
if (!$result['complete'])
	echo $this->renderPartial('_editform',array('model'=>$model));
else
	echo $this->renderPartial('/shared/_completedmessage',array('result'=>$result));
?>
</div>
