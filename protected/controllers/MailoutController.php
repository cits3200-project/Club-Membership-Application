<?php
/**
 * MailoutController
 * This controller covers all of the mailout section. At this point in
 * time this entails form validation and directing the request on to 
 * different functions (sending a batch email, or generating a CSV)
 *
 * @author Jason Larke
 * @date 23/08/2012
 */
class MailoutController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl' // perform access control for CRUD operations
		);
	}
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array(
				'allow', 
				'actions'=>array('mailout', 'index'),
				'expression'=>'$user->hasAnyRoles(array("admin", "mailout"))'
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$model = new MailoutForm();
		
		if(!empty($_POST['ajax']) && $_POST['ajax']==='mailout-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		
			// collect user input data
		if(!empty($_POST['MailoutForm']))
		{
			$model->attributes=$_POST['MailoutForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate())
			{
				$model->process();
			}
			//var_dump($model);
		}
	
		$this->render('index', array(
			'model' => $model
		));
	}
	
	public function actionMailout()
	{
		actionIndex();
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}