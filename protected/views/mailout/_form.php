<?php
/* @var $this MembershipController */
/* @var $form CActiveForm */
$model = MembershipProperties::model();

$baseUrl = Yii::app()->baseUrl; 
Yii::app()->clientScript->registerScriptFile($baseUrl.'/ckeditor/ckeditor.js');
Yii::app()->clientScript->registerCssFile($baseUrl.'/css/mailout.css');
Yii::app()->clientScript->registerScriptFile($baseUrl.'/scripts/mailout.js');
?>

<div class="form" id="properties">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mailout-form',
	'enableAjaxValidation'=>false,
)); ?>
	<?php echo $form->errorSummary($model); ?>
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
		foreach($model->attributeNames() as $attr) 
		{
			if ($attr !== $model->tableSchema->primaryKey)
			{?>
			<tr>
				<td class="smallproperty"><input type="checkbox" name="mailout[<?php echo $attr; ?>]" value="Y" /></td>
				<td class="smallproperty"><input type="checkbox" name="mailout[<?php echo $attr; ?>]" value="N" /></td>
				<td class="smallproperty"><input type="checkbox" name="mailout[<?php echo $attr; ?>]" value="" /></td>
				<td><span class="mailout-filter"><?php echo $model->getAttributeLabel($attr); ?></span></td>
			</tr>
		<?php
			}
		}
	?>
		</tbody>
	</table>
	<div class="toggle-options">
		<label for="mailout[type]">
			<input type="radio" name="mailout[type]" value="csv" id="mailouttype" />Generate CSV of the emails
		</label>
		<label for="mailout[type]">
			<input type="radio" name="mailout[type]" value="email" id="mailouttype" />Compose and send batch email
		</label>
	</div>
	<div id="csvOption">
		<div class="row buttons"><?php echo CHtml::submitButton("Generate CSV"); ?></div>
	</div>
	<div id="emailOption">
		<textarea name="mailout[email]" class="ckeditor"></textarea>
		<div class="row buttons"><?php echo CHtml::submitButton("Send emails"); ?></div>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->