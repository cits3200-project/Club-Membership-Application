<?php
/* @var $this MembershipController */
/* @var $model Membership */
/* @var $result array containing information about the form result */
$this->breadcrumbs=array(
	'Members'=>array('index'),
	'Register',
);?>
<div id="templatemo_main"><?php
if (!$result['complete'])
	echo $this->renderPartial('_registrationform',array('model'=>$model));
else
	echo $this->renderPartial('_completedmessage',array('result'=>$result));
?>
</div>