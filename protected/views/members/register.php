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
	echo $this->renderPartial('/shared/_membershipform',
		array(
			'model'=>$model,
			'heading' => 'Register',
			'id' => 'registration-form',
			'submit_label' => 'Register',
		)
	);
else
	echo $this->renderPartial('/shared/_completedmessage',array(
		'result'=>$result
	));
?>
</div>
