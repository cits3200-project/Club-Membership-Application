<?php
/* @var $this MembershipController */
/* @var $model Membership */
/* @var $result array containing information about the form result */
$this->breadcrumbs=array(
	'Members'=>array('index'),
	'Register',
);?>
<?php
if (!$result['complete'])
	echo $this->renderPartial('_registrationform',array(
		'model'=>$model
	));
else
	echo $this->renderPartial('/shared/_completedmessage',array(
		'result'=>$result
	));
?>
