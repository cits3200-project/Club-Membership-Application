<?php
/* @var $model SearchFormBase model */
/* @var $form ExtendedForm */

$baseUrl = Yii::app()->baseUrl; 
Yii::app()->clientScript->registerCssFile($baseUrl.'/css/search.css');
?>

<div class="form">

<?php $form=$this->beginWidget('ExtendedForm', array(
	'id'=>'search-form',
	'enableAjaxValidation'=>false,
	'method'=>'get'
)); ?>

<fieldset id="searchCriteria">
	<legend>Search Criteria</legend>
<?php
$fields = $model->getSearchFields();
// smash out the toggle options
$toggleCount = 0;
foreach($fields as $field)
	if (strtolower($model->getSearchFieldType($field)) === 'toggle')
		$toggleCount++;
		
if ($toggleCount)
{ ?>
	<table class="search-filters">
		<thead>
			<tr>
				<th class="smallproperty">Yes</th>
				<th class="smallproperty">No</th>
				<th class="smallproperty">Ignore</th>
				<th>Filter</th>
			<tr>
		</thead>
		<tbody>
	<?php
	foreach($fields as $field)
	{
		if (strtolower($model->getSearchFieldType($field)) === 'toggle')
		{?>
			<tr>
				<td class="smallproperty"><?php echo $form->explicitRadioButton($model,$field,'Y'); ?></td>
				<td class="smallproperty"><?php echo $form->explicitRadioButton($model,$field,'N'); ?></td>
				<td class="smallproperty"><?php echo $form->explicitRadioButton($model,$field,'I'); ?></td>
				<td><span class="search-filter"><?php echo $model->getAttributeLabel($field); ?></span></td>
			</tr>
		<?php
		}
	}?>
		</tbody>
	</table>
	<?php
} ?>

	<div class="row">
		<?php echo $form->labelEx($model,'membershipId'); ?>
		<?php echo $form->textField($model,'membershipId'); ?>
		<?php echo $form->error($model,'membershipId'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Proceed'); ?>
	</div>
</fieldset>

<?php $this->endWidget(); ?>