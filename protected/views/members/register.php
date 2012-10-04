<?php
/* @var $this MembershipController */
/* @var $model Membership */

$this->breadcrumbs=array(
	'Members'=>array('index'),
	'Register',
);
?>

<h3>Register for the Swedish Club of WA</h3>

<?php echo $this->renderPartial('_registrationform', array('model'=>$model)); ?>