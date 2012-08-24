<?php
/**
 * ExtendedForm
 * Extends some of the functionality of Yii's native CActiveForm class
 * this allows for some more unique controls to be made that better
 * fit the page design which still maintaining the more rigid MVC pattern
 *
 * @author Jason Larke
 * @date 23/08/2012
 */
class ExtendedForm extends CActiveForm
{
	/**
	 * string staticField(...)
	 * provides a static, non-modifiable tag to display read-only 
	 * form data that you do not wish the user to be able to modify
	 * @param $model Model which contains the attribute
	 * @param $attribute string name of the model attribute that corresponds to this field
	 * @param $htmlOptions various HTML options. See any of Yii's CHtml::activeXXXX(..) methods for more information
	 * @return appropriately formatted HTML for a static field
	 */
	 public function staticField($model,$attribute,$htmlOptions=array())
	{
		CHtml::resolveNameID($model,$attribute,$htmlOptions);
		$style = "display: block; padding: 3px;";
		if (!empty($htmlOptions['style']))
			$htmlOptions['style'] .= " $style";
		else
			$htmlOptions['style'] = $style;
			
		$value = $model->getAttributeLabel($attribute);	
		return CHtml::tag("span", $htmlOptions, $value);
	}
	
	public function explicitCheckbox($model,$attribute,$value,$htmlOptions=array())
	{
		$htmlOptions['value'] = $value;
		$htmlOptions['type'] = "checkbox";
		$htmlOptions['uncheckValue'] = null;
			
		return parent::checkBox($model,$attribute,$htmlOptions);
	}
	
	public function explicitRadioButton($model,$attribute,$value,$htmlOptions=array())
	{
		$htmlOptions['value'] = $value;
		$htmlOptions['type'] = "radio";
		$htmlOptions['uncheckValue'] = null;
			
		return parent::radioButton($model,$attribute,$htmlOptions);	 
	}
}
?>