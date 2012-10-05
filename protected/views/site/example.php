<?php
	
?>
<script type="text/javascript">
$(document).ready(function() {
	$("#exButton").click(function() {
		SwedishCore.addMoreFields('<?php echo Yii::app()->baseUrl; ?>/ajax/html?f=member_tile', $(this), 0);
	});
});
</script>

<div id="templatemo_main">
	<form name="example" action="" method="post">
		<input id="exButton" type="button" value="add" />
		<input type="submit" value="TEST ME" />
	</form>
</div>
