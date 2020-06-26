	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<?php
		$title = $set->getWebsiteSetting('website_title');
		echo '<title>'.$title.'</title>';

		$description = $set->getWebsiteSetting('description');
		echo '<meta name="description" content="'.$description.'"/>';

		$keywords = $set->getWebsiteSetting('keywords');
		echo '<meta name="keywords" content="'.$keywords.'"/>';
		
		$favicon = $set->getWebsiteSetting('favicon_url');
		echo '<link rel="icon" href="../'.$favicon.'" type="image/png">';
	?>
	<meta name="author" content="SUB" />
	<link rel="stylesheet" type="text/css" href="../css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="../css/animate.css" />
	<link rel="stylesheet" type="text/css" href="../css/header.css" />
	<link rel="stylesheet" type="text/css" href="css/sidebar.css" />
	<link rel="stylesheet" type="text/css" href="../script/selectr/selectr.css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">