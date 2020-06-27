	const addressline1 = document.getElementById('address1');
	const addressline2 = document.getElementById('address2');
	const cp = document.getElementById('cp');
	const city = document.getElementById('city');
	const country = document.getElementById('country');
	const state = document.getElementById('state');
	const notes = document.getElementById('notes');
	const addressName = document.getElementById('name');
	let id_shipping = document.getElementById('id_shipping').value;

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
	checkDeliveryForm = () =>{
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

			const xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {
					console.log(this.response);
					myObj = JSON.parse(this.response);
					// if(!myObj.return){
						hideLoading();
						setModalError(myObj.message);
						setTimeout(function(){closeModal();}, 5000);
					// }else{
						// location.reload();
		            // }
				}
			}
			xhr.open('POST','../include/CLIENT-updateShipping.php', true);
			xhr.send(formData);  
		}
		else{
    		setTimeout(()=>{
    			clearDeliveryForm();
    		},5000);
    	}
	}

	const submitShipping = document.getElementById('submitShipping');
	submitShipping.addEventListener('click',function(event){
		event.preventDefault();
		deliveryFormSubmit();
	});