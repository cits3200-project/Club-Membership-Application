<?php 
/* @var $this Controller */ 
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/scripts/ddsmoothmenu.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/scripts/lofslidernews.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/scripts/core.js');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />

		<!-- blueprint CSS framework -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/screen.css" media="screen, projection" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/print.css" media="print" />
		<!--[if lt IE 8]>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/ie.css" media="screen, projection" />
		<![endif]-->

		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/form.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/templatemo_style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/ddsmoothmenu.css" />
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	</head>

	<body>
	
		<div id="templatemo_wrapper">
			<div id="templatmeo_header">
				<div id="site_title"><h1>The Swedish Club of WA</h1></div>
				<div class="cleaner"></div>
			</div> <!-- END of header -->
			
			<div id="templatemo_menu" class="ddsmoothmenu">
				<?php $this->widget('zii.widgets.CMenu',array(
					'items'=>array(
						array('label'=>'Home', 				'url'=>array('/site/')),
						array('label'=>'About Us',			'url'=>array('/site/?view=aboutus'), 
							'items' => array(
								array('label'=>'History', 	'url'=>array('/site/?view=aboutus')),
								array('label'=>'Contact Us','url'=>array('/site/?view=contact'))
							)
						),
						array('label'=>'Swedish Classes',	'url'=>array('/site/?view=adultclasses'),
							'items' => array(
								array('label'=>'Adult Classes','url'=>array('/site/?view=adultclasses')),
								array('label'=>'Kids Classes','url'=>array('/site/?view=kidsclasses'))
							)
						),
						array('label'=>'Emigration',		'url'=>array('/site/?view=emigration'),
							'items' => array(
								array('label'=>'Visas', 	'url'=>array('/site/?view=emigration#Visas')),
								array('label'=>'Jobs',		'url'=>array('/site/?view=emigration#Jobs')),
								array('label'=>'Additional Help','url'=>array('/site/?view=emigration#Help'))
							)
						),
						array('label'=>'Coming Events',		'url'=>array('/site/?view=comingevents')),
						array('label'=>'Members', 			'url'=>array('/members/'), 	'visible'=>Yii::app()->user->isGuest || Yii::app()->user->hasRoles('members'), 
							'items' => array(
								array('label'=>'Login', 'url'=>array('/members/login'), 'visible'=>Yii::app()->user->isGuest),
								array('label'=>'Register', 'url'=>array('/members/register'), 'visible'=>Yii::app()->user->isGuest)
							)
						),
						array('label'=>'Administrator',		'url'=>array('/admin/'),	'visible'=>Yii::app()->user->hasRoles('admin'),
							'items' => array(
								array('label'=>'Search Members', 'url'=>array('/admin/search')),
								array('label'=>'Email Members', 'url'=>array('/admin/mailout'))
							)
						)
					),
				)); ?>
				<br style="clear: left" />
			</div> <!-- END of menu -->
			
			<div id="templatemo_main">
				<?php echo $content; ?>
			</div>
		</div>
		<div id="templatemo_footer_wrapper">
			<div id="templatemo_footer">
				<div class="col one_third" style="height: 56px">
					<h4>Website Translation</h4>
					<div id="MicrosoftTranslatorWidget" style="width: 200px; min-height: 83px; border-color: #3A5770; background-color: #78ADD0;"><noscript><a href="http://www.microsofttranslator.com/bv.aspx?a=http%3a%2f%2fwww.svenskaklubben.org.au%2f">Translate this page</a><br />Powered by <a href="http://www.bing.com/translator">Microsoft® Translator</a></noscript></div> <script type="text/javascript"> /* <![CDATA[ */ setTimeout(function() { var s = document.createElement("script"); s.type = "text/javascript"; s.charset = "UTF-8"; s.src = ((location && location.href && location.href.indexOf('https') == 0) ? "https://ssl.microsofttranslator.com" : "http://www.microsofttranslator.com" ) + "/ajax/v2/widget.aspx?mode=manual&from=en&layout=ts"; var p = document.getElementsByTagName('head')[0] || document.documentElement; p.insertBefore(s, p.firstChild); }, 0); /* ]]> */ </script> 
				</div>
				
				<div class="col one_third">
					<p>PUT SOMETHING HERE</p>
				 </div>
				
				<div class="col one_third no_margin_right">
					<h4>Follow Us</h4>
					<p>Follow The Swedish Club of WA on Klotterplank and Facebook by clicking on the icons below.</p>
					
					<div class="cleaner h20"></div>
					<div class="footer_social_button">
						<a href="http://www.facebook.com/groups/169714974189/" title="Swedish Club of WA on Facebook" target="_blank"><img src="<?php echo Yii::app()->baseUrl; ?>/images/facebook.png" title="Facebook" alt="Facebook" /></a>
						<a href="http://users3.smartgb.com/g/g.php?a=s&i=g34-04058-76" title="Swedish Club of WA on Klotterplank" target="_blank"><img src="<?php echo Yii::app()->baseUrl; ?>/images/klotterplank.jpg" title="Klotterplank" alt="Klotterplank" /></a>
					</div>
					
				</div>
					<div class="cleaner"></div>
				
				<div class="copyright" align="center">
				Copyright © 2012 <a href="#">The Swedish Club of WA</a> Designed by <a href="http://www.templatemo.com" target="_parent">Free CSS Templates</a>
				</div>
				
				<div class="cleaner"></div>
			</div>
		</div> <!-- END of footer -->
	<?php /*
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
						array('label'=>'Change Password',	'url'=>array('/members/changepassword/'), 'visible'=>Yii::app()->user->hasRoles(array("member"))),
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
	*/ ?>
	</body>
</html>
