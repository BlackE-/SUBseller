<?php
	require_once dirname(__FILE__) . '/include/db.php';
	require_once dirname(__FILE__) . '/include/setup.php';

	$db = new DB();
	$set = new Setup($db);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>SUBSeller</title>
	<style type="text/css">
		body{font-family: sans-serif;}
		#setup_form{margin:0 auto;width:90%;max-width: 640px;}
		#setup_form input{width:100%;}

	</style>
</head>
<body>
	<?php
		include ('header.php');
	?>
	<P>form config</P>
	<form id="setup_form">
		<?php
			$data = $set->getConfigData();
			if(!$data['return']){
				?>
				<p>Mailchimp ID List</p>
				<input type="text" name="mailchimp_id_list">
				<p>Admin Email</p>
				<input type="text" name="admin_email">
				<p>From Email</p>
				<input type="text" name="from_email">
				<p>Contacto Email</p>
				<input type="text" name="contacto_email">
				<p>Limit free delivery</p>
				<input type="text" name="limit_free_delivery">
				<p>Costo envio</p>
				<input type="text" name="delivery_cost">
				<p>Limite Conekta</p>
				<input type="text" name="limit_conekta" value="5000">
				<p>Limite Oxxo Conecta</p>
				<input type="text" name="limit_oxxo_conekta" value="10000">
			<?php
			}
			else{
				foreach($data['data'] as $value){
					echo '<p>'.$value['key'].'</p>';
					echo '<input type="text" name="'.$value['key'].'" value='.$value['value'].'>';
				}
			}
		?>
		<input type="submit" value="guardar">
	</form>
	<script type="text/javascript">
		document.querySelector("#setup_form").addEventListener("submit", function(e){
			e.preventDefault();
			const inputs = document.querySelectorAll('input[type="text"]');
			let sendString = '';
			for (const prop in inputs) {
			  	if(!Object.is(inputs[prop].value,undefined)){
			  		let index = inputs[prop].name;
			  		let value = inputs[prop].value;
					sendString += index +  '=' + value + '&';
				}
			}
			console.log(sendString);
			let xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					console.log(this.response);
					myObj = JSON.parse(this.response);
					console.log(myObj);
				}
			}
			xmlhttp.open("POST", "SETUP-setData.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send(sendString);

		});
	</script>

	<?php
		include('footer.php');
	?>
</body>
</html>