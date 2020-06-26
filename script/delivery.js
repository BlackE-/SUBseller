	const shippings = document.getElementById('shippings');
	//check phone
	const phone = document.getElementById('phone');
	let phoneSave = false;
	if (typeof(phone) != 'undefined' && phone != null){
	  phoneSave = true;
	}
	const addressline1 = document.getElementById('address1');
	const addressline2 = document.getElementById('address2');
	const cp = document.getElementById('cp');
	const city = document.getElementById('city');
	const country = document.getElementById('country');
	const state = document.getElementById('state');
	const notes = document.getElementById('notes');
	const checkName = document.getElementById('checkName');
	const addressName = document.getElementById('name');

	let id_shipping = 0;

	const modalBody = document.querySelector('.modal-body');
	showLoading = () =>{document.querySelector('.lds-dual-ring').style.display = 'inline-block';}
	hideLoading = () =>{document.querySelector('.lds-dual-ring').style.display = 'none';}
	resetModal = () =>{
		let c = modalBody.children;
		for (i = 0; i < c.length; i++) {
			if(c[i].tagName == 'P'){c[i].remove();}
  		}
	}
	setModalError = (msg) =>{
		const p = document.createElement('p');
		p.innerText = msg;
		modalBody.appendChild(p);
	}

	clearDeliveryForm = () =>{
		addressline1.classList.remove('animated');
		addressline1.classList.remove('swing');
		cp.classList.remove('animated');
		cp.classList.remove('swing');
		city.classList.remove('animated');
		city.classList.remove('swing');
		state.classList.remove('animated');
		state.classList.remove('swing');
		addressName.classList.remove('animated');
		addressName.classList.remove('swing');
	}

	savePhone = () =>{
		//save it in DB and CONEKTA
		let returnValue;
		openModal();
		showLoading();
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				// console.log(this.response);
				myObj = JSON.parse(this.response);
				if(!myObj.return){
					hideLoading();
					setModalError(myObj.message);
					setTimeout(function(){closeModal();}, 5000);
				}
	            returnValue = myObj.return; 
			}
		}
		xhr.open('POST','./include/DELIVERY-insertPhone.php'); //i dont want it async
		let formPhone = new FormData();
		let _phone = '';
		switch(country.value){
			case 'MEX':_phone = `+52 1 ${phone.value}`; break;
		}
		formPhone.append('phone',_phone);
		xhr.send(formPhone); 
		return returnValue;
	}
	
	checkDeliveryForm = () =>{
		//check form shipping
		if(phoneSave){
			if(phone.value == '' || phone.value.length < 10){
				phone.classList.add('animated');
				phone.classList.add('swing');
				return false;
			}
			if(!savePhone()){return false;}else{phoneSave = !phoneSave;return false;}
		}

		if(addressline1.value == ''){
			addressline1.classList.add('animated');
			addressline1.classList.add('swing');
			return false;
		}
		if(cp.value == ''){
			cp.classList.add('animated');
			cp.classList.add('swing');
			return false;
		}
		if(city.value==''){
			city.classList.add('animated');
			city.classList.add('swing');
			return false;
		}
		if(checkName.checked){
			if(addressName.value==''){
				addressName.classList.add('animated');
				addressName.classList.add('swing');
				return false;
			}
		}
		return true;
	}

	//save shipping in DB
	deliveryFormSubmit = () =>{
		if(checkDeliveryForm()){
    		resetModal();
    		openModal();
			showLoading();
    		const formData = new FormData();
	        formData.append('address1',addressline1.value);
	        formData.append('address2',addressline2.value);
	        formData.append('cp', cp.value);
	        formData.append('country', country.value);
	        formData.append('city', city.value);
			formData.append('state', state.value);
			formData.append('notes', notes.value);
			formData.append('name', addressName.value);
			formData.append('id_shipping', id_shipping);

			if(checkName.checked){formData.append('save', 1);}
			else{formData.append('save', 0);}

			const xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {
					// console.log(this.response);
					myObj = JSON.parse(this.response);
					if(!myObj.return){
						hideLoading();
						setModalError(myObj.message);
						setTimeout(function(){closeModal();}, 5000);
					}else{
						closeModal();
						window.location.href = "payment";
		            }
				}
			}
			xhr.open('POST','./include/DELIVERY-insertShipping.php', true);
			xhr.send(formData);  
		}
		else{
    		setTimeout(()=>{
    			clearDeliveryForm();
    		},5000);
    	}
	}

	const next = document.getElementById('next');
	next.addEventListener('click',function(event){
		event.preventDefault();
		deliveryFormSubmit();
	});

	setDeliveryForm = (data) =>{
		addressline1.value = data.address_line_1;
		addressline2.value = data.address_line_2;
		cp.value = data.cp;
		city.value = data.city;
		country.value = data.country;
		state.value = data.state;
		notes.value = data.notes;
		addressline1.setAttribute('disabled','');
		addressline2.setAttribute('disabled','');
		city.setAttribute('disabled','');
		cp.setAttribute('disabled','');
		country.setAttribute('disabled','');
		state.setAttribute('disabled','');
		notes.setAttribute('disabled','');
	}

	unsetDeliveryForm = () =>{
		addressline1.value = '';
		addressline2.value = '';
		cp.value = '';
		city.value = '';
		country.value = 'MEX';
		state.value = 'Aguascalientes';
		notes.value = '';
		addressline1.removeAttribute('disabled','');
		addressline2.removeAttribute('disabled','');
		city.removeAttribute('disabled','');
		cp.removeAttribute('disabled','');
		country.removeAttribute('disabled','');
		state.removeAttribute('disabled','');
		notes.removeAttribute('disabled','');
	}	

	if (typeof(shippings) != 'undefined' && shippings != null){
		shippings.addEventListener('change',function(){
			id_shipping = this.value;
			if(id_shipping == 0){
				unsetDeliveryForm();
			}else{
				showLoading();
				openModal();
				let formShipping = new FormData();
				formShipping.append('id_shipping',id_shipping);

				const xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function(){
					if (this.readyState == 4 && this.status == 200) {
						console.log(this.response);
						myObj = JSON.parse(this.response);
						if(!myObj.return){
							hideLoading();
							setModalError(myObj.message);
							setTimeout(function(){closeModal();}, 5000);
						}else{
							closeModal();
							setDeliveryForm(myObj.return);
			            }
					}
				}
				xhr.open('POST','./include/DELIVERY-getShipping.php', true);
				xhr.send(formShipping); 
			}
		});
	}

	
