<?php
/* @var $model SearchFormBase model */
/* @var $form ExtendedForm */
/* @var $method string Form post method */
if(empty($method))
	$method = 'POST';
	
$baseUrl = Yii::app()->baseUrl; 
Yii::app()->clientScript->registerCssFile($baseUrl.'/css/search.css');
?>
<div id="templatemo_main">
<fieldset id="searchCriteria">
	<legend>Search Criteria</legend>
	
	<div class="form">
	<?php $form=$this->beginWidget('ExtendedForm', array(
		'id'=>'search-form',
		'enableAjaxValidation'=>false,
		'method'=>$method
	)); ?>
	<?php echo $form->errorSummary($model); ?>
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

		<div class="row">
			<?php echo $form->labelEx($model,'membershipName'); ?>
			<?php echo $form->textField($model,'membershipName'); ?>
			<?php echo $form->error($model,'membershipName'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'familyName'); ?>
			<?php echo $form->textField($model,'familyName'); ?>
			<?php echo $form->error($model,'familyName'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'emailAddress'); ?>
			<?php echo $form->textField($model,'emailAddress'); ?>
			<?php echo $form->error($model,'emailAddress'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'phoneNumber'); ?>
			<?php echo $form->textField($model,'phoneNumber'); ?>
			<?php echo $form->error($model,'phoneNumber'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'membershipType'); ?>
			<?php echo $form->dropDownList($model,'membershipType', $model->getMembershipTypes()); ?>
			<?php echo $form->error($model,'membershipType'); ?>
		</div>		

		<div class="row">
			<?php echo $form->labelEx($model,'paymentMethod'); ?>
			<?php echo $form->dropDownList($model,'paymentMethod',$model->getPaymentTypes()); ?>
			<?php echo $form->error($model,'paymentMethod'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'membershipStatus'); ?>
			<?php echo $form->dropDownList($model,'membershipStatus',$model->getMembershipStatusTypes()); ?>
			<?php echo $form->error($model,'membershipStatus'); ?>
		</div>	
		
		<div class="row buttons">
			<?php echo CHtml::submitButton('Proceed'); ?>
		</div>
	<?php $this->endWidget(); ?>
	</div>
</fieldset>
</div>