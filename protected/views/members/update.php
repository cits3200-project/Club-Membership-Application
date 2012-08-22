<?php
/* @var $this MembershipController */
/* @var $model Membership */

$this->breadcrumbs=array(
	'Memberships'=>array('index'),
	$model->name=>array('view','id'=>$model->membershipId),
	'Update',
);
/*
$this->menu=array(
	array('label'=>'List Membership', 'url'=>array('index')),
	array('label'=>'Create Membership', 'url'=>array('create')),
	array('label'=>'View Membership', 'url'=>array('view', 'id'=>$model->membershipId)),
	array('label'=>'Manage Membership', 'url'=>array('admin')),
);*/
?>

<h1>Edit your details</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'action'=>'update')); ?>