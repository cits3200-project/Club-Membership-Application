<?php
/* @var $this MembershipController */
/* @var $model Membership */

$this->breadcrumbs=array(
	'Members'=>array('index'),
	'Register',
);
?>

<h1>Change your password</h1>

<?php echo $this->renderPartial('_changepasswordform', array('model'=>$model)); ?>
