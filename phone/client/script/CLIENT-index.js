	let nameUser = document.getElementById("nameRegister"); 
    let emailUser  = document.getElementById('emailRegister');
    let phoneUser = document.getElementById('phoneRegister'); 
    let genero = document.getElementById('sexRegister'); 
    let newsletter = document.getElementById('checkNewsletter');

    let emailLogin = document.getElementById('emailLogin');
    let passwordLogin = document.getElementById('passwordLogin');


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

	validateEmail = (email) => {
    	const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    	return re.test(String(email).toLowerCase());
	}


	clearRegisterForm = () =>{
		nameUser.classList.remove('animated');
		nameUser.classList.remove('swing');
		apellidoRegister.classList.remove('animated');
		apellidoRegister.classList.remove('swing');
		phoneUser.classList.remove('animated'); 
		phoneUser.classList.remove('swing'); 
		emailUser.classList.remove('animated');
		emailUser.classList.remove('swing');
		genero.classList.remove('error');
	}

	checkRegisterForm = () =>{  
		if(nameUser.value === ""){
			nameUser.classList.add('animated');
			nameUser.classList.add('swing');
			return false;
		}
		if( phoneUser.value === ""){
		    phoneUser.classList.add('animated');
		    phoneUser.classList.add('swing');
		    return false;
		}
		if(emailUser.value === ""){
			emailUser.classList.add('animated');
		    emailUser.classList.add('swing');
		    return false;	
		}
		if(!validateEmail(emailUser.value)){
			emailUser.classList.add('animated');
		    emailUser.classList.add('swing');
		    return false;
		}
		if(genero.value === '0'){
			genero.classList.add('error');
		    return false;
		}
		return true;
	}

	registerClient = () =>{
    	if(checkRegisterForm()){
    		resetModal();
			showLoading();
    		openModal();
    		
    		const formData = new FormData();
	        formData.append('name',nameUser.value);
	        formData.append('phone', phoneUser.value);
	        formData.append('email', emailUser.value);
	        formData.append('day', document.getElementById('day').value);
			formData.append('month', document.getElementById('month').value);
			formData.append('year', document.getElementById('year').value);
			formData.append('sex', genero.value);
	        if(newsletter.checked){formData.append('newsletter', 1);}
	        else{formData.append('newsletter', 0);}

	        const xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {
					console.log(this.response);
					myObj = JSON.parse(this.response);
					hideLoading();
					setModalError(myObj.message);
					setTimeout(function(){closeModal();}, 5000);
				}
			}
			xhr.open('POST','../../include/CLIENT-updateClient.php', true);
			xhr.send(formData);    
    	}else{
    		setTimeout(()=>{
    			clearRegisterForm();
    		},5000);
    	}
    }

    const submitRegister = document.getElementById('submitRegister');
    submitRegister.addEventListener('click',(event)=>{ 
    	event.preventDefault();
    	console.log('submitRegister');
    	registerClient();
    });