<?php
/** available variables
 *@var $this AdminController
 *@var $model AdminEditForm 
 *@var $membershipId a valid membershipId string or NULL if the provided id was invalid
 *@var $result array containing result info
**/
$this->breadcrumbs=array(
	'Admin'=>array('/admin/'),
	'Edit Membership',
);?>
<div id="templatemo_main"><?php
if ($membershipId !== NULL)
{
	if (!$result['complete'])
		echo $this->renderPartial('_adminedit',array(
			'model'=>$model,
			'membershipId'=>$membershipId
		));
	else
		echo $this->renderPartial('/shared/_completedmessage',array('result'=>$result));
}
else
{?>
	<h3>Error</h3>
	<p>No membership was found with that ID</p><?php
}?>
</div>
