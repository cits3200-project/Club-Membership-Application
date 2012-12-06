<?php
/* @var $this MembershipController */
/* @var $model MailoutForm
/* @var $form ExtendedForm */

$baseUrl = Yii::app()->baseUrl; 
Yii::app()->clientScript->registerScriptFile($baseUrl.'/ckeditor/ckeditor.js');
Yii::app()->clientScript->registerCssFile($baseUrl.'/css/mailout.css');
Yii::app()->clientScript->registerScriptFile($baseUrl.'/scripts/mailout.js');

?>

<div class="form" id="properties">

<?php $form = $this->beginWidget('ExtendedForm', array(
	'id'=>'mailout-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php $this->renderPartial('_searchform', array('model'=>$model,'form'=>$form)); /*echo $form->errorSummary($model); ?>
	<table class="mailout-filters">
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
		foreach($model->getFilters() as $code)
		{?>
			<tr>
				<td class="smallproperty"><?php echo $form->explicitRadioButton($model,$code,'Y'); ?></td>
				<td class="smallproperty"><?php echo $form->explicitRadioButton($model,$code,'N'); ?></td>
				<td class="smallproperty"><?php echo $form->explicitRadioButton($model,$code,'I'); ?></td>
				<td><span class="mailout-filter"><?php echo $model->getAttributeLabel($code); ?></span></td>
			</tr>
		<?php
		}
	?>
		</tbody>
	</table>
	*/ ?>
	<div class="toggle-options">
		<?php echo $form->radioButtonList($model, 'type', array(
							'csv' => 'Generate CSV of the emails',
							'email' => 'Compose and send batch email'
						),
						array ('uncheckValue' => NULL)
					); 
		?>
	</div>
	<div id="csvOption">
		<div class="row buttons"><?php echo CHtml::submitButton("Generate CSV"); ?></div>
	</div>
	<div id="emailOption">
		<?php echo $form->labelEx($model, "emailSubject"); ?>
		<?php echo $form->textField($model, "emailSubject", array("size" => 60)); ?>
		<?php echo $form->textArea($model, 'emailContent', array("class" => "ckeditor")); ?>
		<div class="row buttons"><?php echo CHtml::submitButton("Send emails"); ?></div>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->