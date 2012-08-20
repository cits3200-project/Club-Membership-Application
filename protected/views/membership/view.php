<?php
/* @var $this MembershipController */
/* @var $model Membership */

$this->breadcrumbs=array(
	'Memberships'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Membership', 'url'=>array('index')),
	array('label'=>'Create Membership', 'url'=>array('create')),
	array('label'=>'Update Membership', 'url'=>array('update', 'id'=>$model->membershipId)),
	array('label'=>'Delete Membership', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->membershipId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Membership', 'url'=>array('admin')),
);
?>

<h1>View Membership #<?php echo $model->membershipId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'membershipId',
		'name',
		'familyName',
		'phoneNumber',
		'alternatePhone',
		'emailAddress',
		'alternateEmail',
		'type',
		'expiryDate',
		'payMethod',
		'status',
	),
)); ?>
