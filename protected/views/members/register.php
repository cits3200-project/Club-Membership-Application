<?php
/* @var $this MembershipController */
/* @var $model Membership */

$this->breadcrumbs=array(
	'Members'=>array('index'),
	'Register',
);
?>

<h1>Register for the Swedish Club of WA</h1>

<?php echo $this->renderPartial('_registrationform', array('model'=>$model)); ?>