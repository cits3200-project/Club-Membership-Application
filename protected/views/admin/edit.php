<?php
/** available variables
 *@var $this AdminController
 *@var $model AdminEditForm 
 *@var $membershipId a valid membershipId string or NULL if the provided id was invalid
 *@var $result array containing result info
**/
$this->breadcrumbs=array(
	'Admin'=>array('.'),
	'Search'=>array('search'),
	'Edit Membership',
);?>
<div id="templatemo_main"><?php
if ($membershipId !== NULL)
{
	if (!$result['complete'])
		echo $this->renderPartial('/shared/_membershipform',
			array(
				'model'=>$model,
				'heading'=>"Editing membership $membershipId",
				'id'=>'admin-edit-form',
				'submit_label'=>'Update',
			)
		);
	else
		echo $this->renderPartial('/shared/_completedmessage',array(
			'result'=>$result
		));
}
else
{?>
	<h3>Error</h3>
	<p>No membership was found with that ID</p><?php
}?>
</div>
