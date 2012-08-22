<?php
/* @var $this MembershipController */
/* @var $model Membership */

$this->breadcrumbs=array(
	'Memberships'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Membership', 'url'=>array('index')),
	array('label'=>'Manage Membership', 'url'=>array('admin')),
);
?>

<h1>Create Membership</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>