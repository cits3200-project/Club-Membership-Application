<?php
/** variables
 *@var result array structure containing relevant information to build the HTML
 */
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/form.css');
?>
<div class="<?php echo $result['success'] ? 'success' : 'failure'; ?>_message">
	<h3><?php echo $result['heading']; ?></h3>
	<p><?php echo $result['message']; ?></p>
</div>