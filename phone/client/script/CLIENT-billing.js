	console.log('BILLING');
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

	const id_billing = document.getElementById('id_billing').value;
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
	
	validateEmail = (email) => {
    	const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    	return re.test(String(email).toLowerCase());
	}

	checkFacturaForm = () =>{  
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

	const submitBilling = document.getElementById('submitBilling');
	submitBilling.addEventListener('click',function(event){
		event.preventDefault();
		if(checkFacturaForm()){
			resetModal();
			showLoading();
			openModal();

			let fd = new FormData();
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

			console.log('FormData');

			const xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {
					myObj = JSON.parse(this.response);
					console.log(myObj);
					hideLoading();
					setModalError(myObj.message);
					setTimeout(()=>{closeModal();},5000);
				}
			}
			xhr.open('POST','../../include/CLIENT-updateBilling.php', true);
			xhr.send(fd);
		}
	});
	