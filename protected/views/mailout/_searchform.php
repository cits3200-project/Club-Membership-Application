<?php
/* @var $model SearchFormBase model */
/* @var $form ExtendedForm */
$baseUrl = Yii::app()->baseUrl; 
Yii::app()->clientScript->registerCssFile($baseUrl.'/css/adminsearch.css');
?>
<fieldset id="searchCriteria">
	<legend>Search Criteria</legend>
<?php
$fields = $model->getSearchFields();
// smash out the toggle options
foreach($fields as $field)
{
	if (strtolower($model->getSearchFieldType($field)) === 'toggle')
	{ ?>
	<div class="row toggle">
		<?php echo $form->labelEx($model,$field); ?>
		<br />
		<?php echo $form->radioButtonList(
							$model,
							$field,
							array(
								'Y' => 'Yes',
								'N' => 'No',
								'I' => 'Ignore'
							)
					); ?>
		<?php echo $form->error($model,$field); ?>
	</div>
	<?php
	}
}
?>
	<div class="row">
		<?php echo $form->labelEx($model,'membershipId'); ?>
		<?php echo $form->textField($model,'membershipId', array('size'=>30,'maxlength'=>200)); ?>
		<?php echo $form->error($model, 'membershipId'); ?>
	</div>
</fieldset>