<?php
/* @var $this MembershipController */
/* @var $model Membership */

$this->breadcrumbs=array(
	'Members'=>array('index'),
	'Register',
);
?>

<h1>Edit your details</h1>

<?php echo $this->renderPartial('_editform', array('model'=>$model)); ?>
