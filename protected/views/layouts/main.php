<?php 
/* @var $this Controller */ 
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/scripts/core.js');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />

		<!-- blueprint CSS framework -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
		<!--[if lt IE 8]>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
		<![endif]-->

		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
		
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	</head>

	<body>
		<div class="container" id="page">
			<div id="header">
				<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
			</div><!-- header -->

			<div id="mainmenu">
				<?php $this->widget('zii.widgets.CMenu',array(
					'items'=>array(
						array('label'=>'Home', 			'url'=>array('/site/index')),
						array('label'=>'Login', 		'url'=>array('/members/login'), 	'visible'=>Yii::app()->user->isGuest),
						array('label'=>'Register',		'url'=>array('/members/register/'),	'visible'=>Yii::app()->user->isGuest),
						array('label'=>'View Members',	'url'=>array('/admin/search'),		'visible'=>Yii::app()->user->hasRoles(array("admin"))),
						array('label'=>'Edit Details', 	'url'=>array('/members/edit/'), 	'visible'=>Yii::app()->user->hasRoles(array("member"))),
						array('label'=>'Mail Members',	'url'=>array('/admin/mailout/'),	'visible'=>Yii::app()->user->hasAnyRoles(array("admin", "mailout"))),
						array('label'=>'Search Members','url'=>array('/admin/memberlist'),	'visible'=>Yii::app()->user->hasRoles(array("admin"))),
						array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
					),
				)); ?>
			</div><!-- mainmenu -->
			<?php if(isset($this->breadcrumbs)):?>
				<?php $this->widget('zii.widgets.CBreadcrumbs', array(
					'links'=>$this->breadcrumbs,
				)); ?><!-- breadcrumbs -->
			<?php endif?>

			<?php echo $content; ?>

			<div class="clear"></div>

			<div id="footer">
				Copyright &copy; <?php echo date('Y'); ?> Swedish Club of WA.<br/>
				All Rights Reserved.<br/>
			</div><!-- footer -->

		</div><!-- page -->

	</body>
</html>
