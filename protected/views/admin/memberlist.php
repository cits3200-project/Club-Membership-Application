<?php
/* @var $this AdminController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Member List',
);
?>

<h3>Search results</h3>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_membertile',
)); ?>