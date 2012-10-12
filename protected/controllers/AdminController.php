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

	public function actionMailout()
	{
		$mailout = new MailoutForm();
		$search = new SearchForm();
		
		$result = array(
			'complete' => false,
			'success' => false,
			'message' => '',
			'heading' => ''
		);
		
		if(!empty($_POST['MailoutForm']))
		{
			$search = Yii::app()->session['mailout-search'];
			$result['complete'] = true;
			$mailout->attributes=$_POST['MailoutForm'];
			$mailout->emailList = $search->runSearch();
			// validate user input and redirect to the previous page if valid
			if($mailout->validate())
			{
				$mailout->process();
				$result['success'] = true;
				if ($mailout->type === 'email')
				{
					$result['heading'] = 'Success!';
					$result['message'] = 'Your email was successfully sent to the chosen recipients!';
				}
			}
			
			$this->render('mailout', array(
				'mailout' => $mailout,
				'search' => $search,
				'result' => $result
			));	
			return;
		}
		elseif (!empty($_POST['SearchForm']))
		{
			$search->attributes = $_POST['SearchForm'];
			if ($search->validate())
			{
				Yii::app()->session['mailout-search'] = $search;
				$this->render('mailout', array(
					'mailout' => $mailout,
					'search' => $search,
					'result' => $result
				));	
				return;
			}
		}

		$this->render('search', array(
			'model' => $search,
			'method' => 'POST'
		));
	}
	
	public function actionSearch()
	{
		$this->actionMemberlist();
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
			'model' => $search,
			'method' => 'GET'
		));
	}

	public function actionEdit()
	{
		if (!isset($_GET['id']))
			$this->redirect('memberlist');

		$membership = Membership::model()->find("LOWER(membershipId)=LOWER(?)", array($_GET['id']));
		$edit = new AdminEditForm();
		
		if ($membership !== NULL)
			$edit->attributes = $membership->attributes;
		
		$result = array(
			'complete' => false,
			'success' => false,
			'message' => '',
			'heading' => ''
		);
		
		if (isset($_POST['AdminEditForm']))
		{
			$edit->attributes = $_POST['AdminEditForm'];
			if ($edit->validate())
			{
				$result['complete'] = true;
				
				$membership->attributes = $edit->attributes;
				if ($membership->save())
				{
					$result['success'] = true;
					$result['heading'] = 'Success!';
					$result['message'] = "Membership '<strong>{$membership->membershipId}</strong>' has successfully had its details updated.";
				}
				else
				{
					$msg = print_r($membership->errors, true);
					Yii::app()->error->report($msg, __FILE__);
					
					$result['message'] = 'An unforseen error occurred with the application. Please try again. If the problem persists, please contact support at <a href="mailto:support@svenskaklubben.org.au">support@svenskaklubben.org.au</a>';
					$result['heading'] = "Unsuccessful!";
				}
			}
		}
		
		$this->render('edit', array(
			'model' => $edit,
			'membershipId' => $membership !== NULL ? $membership->membershipId : NULL,
			'result' => $result
		));
		
	}
}
