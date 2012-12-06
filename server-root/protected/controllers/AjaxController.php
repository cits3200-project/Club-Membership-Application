<?php
/** 
 * Controller to easily and succinctly handle
 * all AJAX view requests
 * @author Jason Larke
 * @date 03/09/2012
 */
class AjaxController extends Controller
{
	/**
	 * Central point of contact for ajax requests for HTML data,
	 * this may include partial form data for dynamic content
	 * view file is specified by the 'f' GET parameter
	 */
	public function actionHtml()
	{
		if (!empty($_GET['f']) && $this->getViewFile($_GET['f']) !== false)
		{
			$file = $_GET['f'];
			unset($_GET['f']);
			$this->renderPartial($file, $_GET);
		}
		Yii::app()->end();
	}
}
?>