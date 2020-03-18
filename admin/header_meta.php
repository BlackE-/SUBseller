	<?php
		$configData = $set->getMetaTags();

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