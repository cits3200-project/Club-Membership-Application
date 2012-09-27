<?php
/* @var $this AdminController */
/* @var $model SearchForm */

$baseUrl = Yii::app()->baseUrl; 
Yii::app()->clientScript->registerCssFile($baseUrl.'/css/search.css');

$this->breadcrumbs=array(
	'Mailout',
);
?>

<?php $this->renderPartial('_searchform', array('model' => $model)); ?>