<?php
	// Password for optional pw_protect in vorlage.json
	$password = '';

	if (isset($_POST['verifypw'])) {
		echo ($_POST['verifypw'] === $password) ? 'true' : 'false';
	}
?>
