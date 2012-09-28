<?php
/**
 * AdminController
 * This controller governs all of the explicit admin functionality.
 * 
 *
 * @author Jason Larke
 * @date 23/08/2012
 */
class AdminController extends Controller
{

	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'accessControl'
		);
	}
	
	public function accessRules()
	{
		// deny access to every action if the user is not an admin
		return array(
			array(
				'deny',
				'expression' => '!$user->hasRoles(array("admin"))'
			),
		);
	}
	
	public function actionIndex()
	{
		$this->render('index', array(
			//'model' => $model
		));
	}
	
	public function actionSearch()
	{
		$dataProvider=new CActiveDataProvider('Membership');
		$this->render('search', array(
			'dataProvider' => $dataProvider
		));
	}
	
	public function actionMailout()
	{
		$mailout = new MailoutForm();
		$search = new SearchForm();
		
		if(!empty($_POST['MailoutForm']))
		{
			$mailout->attributes=$_POST['MailoutForm'];
			$mailout->emailList = $search->runSearch();
			// validate user input and redirect to the previous page if valid
			if($mailout->validate())
				$mailout->process();
			
			$this->render('mailout', array(
				'mailout' => $mailout,
				'search' => $search
			));	
			return;
		}
		elseif (!empty($_POST['SearchForm']))
		{
			$search->attributes = $_POST['SearchForm'];
			if ($search->validate())
			{
				$this->render('mailout', array(
					'mailout' => $mailout,
					'search' => $search
				));	
				return;
			}
		}

		$this->render('search', array(
			'model' => $search
		));
	}
	
	public function actionMemberlist()
	{
		$search = new SearchForm();
		
		if (!empty($_GET['SearchForm']))
		{
			$search->attributes = $_GET['SearchForm'];
			if ($search->validate())
			{
				$currentPage = (isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1);
				$pagination = new CPagination();
				$pagination->setPageSize(10);
				$pagination->setCurrentPage($currentPage - 1);
				
				$dataProvider=new CActiveDataProvider('Membership', array(
					'criteria'=>$search->getSearchCriteria(),
					'pagination'=>$pagination
				));

				$this->render('memberlist', array(
					'dataProvider' => $dataProvider
				));				
				return;
			}
		}
		$this->render('search', array(
			'model' => $search
		));
	}
	

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'accessControl'
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