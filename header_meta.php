	<?php
		//$configData = $set->getMetaTags();
		//print_r($configData);
	?>

		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<?php
			foreach($configData as $value){
				switch($value['key']){
					case 'Ecommerce_name':
						echo '<title>'.$value['value'].'</title>';
						$site_name = $value['value'];
					break;
					case 'description':
						echo '<meta name="description" content="'.$value['value'].'"/>';
					break;
					case 'keywords':
						echo '<meta name="keywords" content="'.$value['value'].'"/>';
					break;
					case 'favicon':
						echo '<link rel="icon" type="image/png" href="'.$value['value'].'"/>';
					break;
					case 'logo':
						$logo = $value['value'];
					break;
				}
			}
		?>
		<meta name="author" content="SUB" />
		<link rel="stylesheet" type="text/css" href="../css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="../css/skeleton.css" />
		<link rel="stylesheet" type="text/css" href="../css/animate.css" />
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">