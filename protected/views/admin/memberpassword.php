<?php
/* @var $this MembershipController */
/* @var $model Membership */

$this->breadcrumbs=array(
	'Members'=>array('index'),
	'Register',
);
?>

<h1>Change a member's password</h1>

<?php echo $this->renderPartial('_memberpassword', array('model'=>$model)); ?>
