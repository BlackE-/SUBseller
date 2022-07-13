		document.querySelector("#setup_form").addEventListener("submit", function(e){
			e.preventDefault();
			openModalFunction();
			const inputs = document.querySelectorAll('input[type="text"]');
			let sendString = '';
			for (const prop in inputs) {
			  	if(!Object.is(inputs[prop].value,undefined)){
			  		let index = inputs[prop].name;
			  		let value = inputs[prop].value;
					sendString += index +  '=' + value + '&';
				}
			}

			const inputs_password = document.querySelectorAll('input[type="password"]');
			for (const prop in inputs_password) {
			  	if(!Object.is(inputs_password[prop].value,undefined)){
			  		let index = inputs_password[prop].name;
			  		let value = inputs_password[prop].value;
					sendString += index +  '=' + value + '&';
				}
			}

			const inputs_radio = document.querySelectorAll('input[type="radio"]:checked');
			for (const prop in inputs_radio) {
			  	if(!Object.is(inputs_radio[prop].value,undefined)){
			  		let index = inputs_radio[prop].name;
			  		let value = inputs_radio[prop].value;
					sendString += index +  '=' + value + '&';
				}
			}

			const textarea = document.querySelectorAll('textarea');
			for (const prop in textarea) {
			  	if(!Object.is(textarea[prop].value,undefined)){
			  		let index = textarea[prop].name;
			  		let value = textarea[prop].value;
					sendString += index +  '=' + value + '&';
				}
			}
			// console.log(sendString);

			let xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					// console.log(this.response);
					myObj = JSON.parse(this.response);
					closeModalFunction();
					// console.log(myObj);
				}
			}
			xmlhttp.open("POST", "./include/SETUP-setData.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send(sendString);

		});