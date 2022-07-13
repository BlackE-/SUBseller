	const modalBody = document.querySelector('.modal-body');
	showLoading = () =>{document.querySelector('.lds-spinner').style.display = 'inline-block';}
	hideLoading = () =>{document.querySelector('.lds-spinner').style.display = 'none';}
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



	let id_billing = 0;
	const id_order = document.getElementById('id_order');
	const billing = document.getElementById('billings');
	const rfc = document.getElementById('rfc');
	const email = document.getElementById('email');
	const razon_social = document.getElementById('razon_social');
	const cfdi = document.getElementById('cfdi');
	const address1 = document.getElementById('address1');
	const address2 = document.getElementById('address2');
	const cp = document.getElementById('cp');
	const city = document.getElementById('city');
	const country = document.getElementById('country');
	const state = document.getElementById('state');
	
	clearForm = () =>{
		id_order.classList.remove('animated');
		id_order.classList.remove('swing');
		billing.classList.remove('animated');
		billing.classList.remove('swing');
		email.classList.remove('animated'); 
		email.classList.remove('swing'); 
		cfdi.classList.remove('animated');
		cfdi.classList.remove('swing');
		razon_social.classList.remove('animated');
		razon_social.classList.remove('swing');
	}

	validateEmail = (email) => {
    	const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    	return re.test(String(email).toLowerCase());
	}

	checkFacturaForm = () =>{
	  	if(id_order.value === "0"){
			id_order.classList.add('animated');
			id_order.classList.add('swing');
			return false;
		}
		if(rfc.value === ""){
			rfc.classList.add('animated');
			rfc.classList.add('swing');
			return false;
		}
		if(razon_social.value === ""){
		    razon_social.classList.add('animated');
		    razon_social.classList.add('swing');
		    return false;
		}
		if(email.value === ""){
			email.classList.add('animated');
		    email.classList.add('swing');
		    return false;	
		}
		if(!validateEmail(email.value)){
			email.classList.add('animated');
		    email.classList.add('swing');
		    return false;
		}
		if(cfdi.value === '0'){
			cfdi.classList.add('animated');
		    cfdi.classList.add('swing');
		    return false;
		}
		return true;
	}

	const request = document.getElementById('request');
	request.addEventListener('click',function(){
		if(checkFacturaForm()){
			resetModal();
			showLoading();
			openModal();

			let fd = new FormData();
			fd.append('id_order',id_order.value);
			fd.append('id_billing',id_billing);
			fd.append('rfc',rfc.value);
			fd.append('cfdi',cfdi.value);
			fd.append('razon_social',razon_social.value);
			fd.append('email',email.value);
			fd.append('address1',address1.value);
			fd.append('address2',address2.value);
			fd.append('city',city.value);
			fd.append('cp',cp.value);
			fd.append('state',state.value);
			fd.append('country',country.value);

			const xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {
					console.log(this.response);
					myObj = JSON.parse(this.response);
					console.log(myObj);
					hideLoading();
					setModalError(myObj.message);
					setTimeout(()=>{closeModal();},5000);
					if(!myObj.return){
						//no se pudo guardar
					}else{
						//todo bien
						//disable button
						request.setAttribute('disable','');
					}
				}
			}
			xhr.open('POST','./include/CONFIRM-insertBilling.php', true);
			xhr.send(fd);

		}
		else{
			resetModal();
			openModal();
			hideLoading();
			setModalError('Por favor, llena los campos necesarios');
			setTimeout(()=>{
				clearForm();
    			closeModal();
    		},2000);
			return false;
		}
	});

	setBillingForm = (data) =>{
		rfc.value = data.rfc;
		razon_social.value = data.razon_social;
		cfdi.value = data.cfdi;
		address1.value = data.address_line_1;
		address2.value = data.address_line_2;
		email.value = data.email;
		cp.value = data.cp;
		city.value = data.city;
		country.value = data.country;
		state.value = data.state;

		rfc.setAttribute('disabled','');
		razon_social.setAttribute('disabled','');
		cfdi.setAttribute('disabled','');
		email.setAttribute('disabled','');
		address1.setAttribute('disabled','');
		address2.setAttribute('disabled','');
		city.setAttribute('disabled','');
		cp.setAttribute('disabled','');
		country.setAttribute('disabled','');
		state.setAttribute('disabled','');
	}

	unsetBillingForm = () =>{
		rfc.value = '';
		razon_social.value = '';
		email.value = '';
		cfdi.value = '0';
		address1.value = '';
		address2.value = '';
		cp.value = '';
		city.value = '';
		country.value = 'MEX';
		state.value = 'Aguascalientes';

		rfc.removeAttribute('disabled','');
		razon_social.removeAttribute('disabled','');
		cfdi.removeAttribute('disabled','');
		email.removeAttribute('disabled','');
		address1.removeAttribute('disabled','');
		address2.removeAttribute('disabled','');
		city.removeAttribute('disabled','');
		cp.removeAttribute('disabled','');
		state.removeAttribute('disabled','');
	}

	if (typeof(billing) != 'undefined' && billing != null){
		billing.addEventListener('change',function(){
			id_billing = this.value;
			if(id_billing == 0){
				unsetBillingForm();
			}else{
				showLoading();
				openModal();
				let formBilling = new FormData();
				formBilling.append('id_billing',id_billing);

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
							setBillingForm(myObj.return);
			            }
					}
				}
				xhr.open('POST','./include/CONFIRM-getBilling.php', true);
				xhr.send(formBilling); 
			}
		});
	}
	
