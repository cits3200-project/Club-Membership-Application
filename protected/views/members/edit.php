<?php
/* @var $this MembershipController */
/* @var $model Membership */
/* @var $result array containing information about the form result */
$this->breadcrumbs=array(
	'Members'=>array('.'),
	'Edit Details',
);

$this->layout = '//layouts/column2';
$this->menu = array(
	array(
		'label' => 'Edit details',
		'url' => array('members/edit')
	),
	array(
		'label' => 'Change password',
		'url' => array('members/changepassword')
	),
	array(
		'label' => 'Edit members',
		'url' => array('members/editmembers')
	)
);

?>
<?php
if (!$result['complete'])
	echo $this->renderPartial('_editform',array('model'=>$model));
else
	echo $this->renderPartial('/shared/_completedmessage',array('result'=>$result));
?>
