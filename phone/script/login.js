	let nameUser = document.getElementById("nameRegister"); 
    let apellidoRegister = document.getElementById('apellidoRegister');
    let emailUser  = document.getElementById('emailRegister');
    let phoneUser = document.getElementById('phoneRegister'); 
    let pass1 = document.getElementById('password1'); 
    let pass2 = document.getElementById('password2'); 
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

	validatePassword = (value) =>{
		const pa = /^[a-zA-Z0-9[a-zA-Z0-9@#$%^&+!=]]{8,}$/;	//Minimum 8 Character Password with lowercase, uppercase letters and numbers 
		//https://www.regextester.com/110035
		return pa.test(value);
	}
	let password = document.getElementById('password1');
	password.addEventListener('keyup',(event)=>{
		event.preventDefault();
		if(!validatePassword(password.value)){
			password.classList.add('error');
		}else{
			password.classList.remove('error');
			password.classList.add('success');
		}
	});

	clearRegisterForm = () =>{
		nameUser.classList.remove('animated');
		nameUser.classList.remove('swing');
		apellidoRegister.classList.remove('animated');
		apellidoRegister.classList.remove('swing');
		phoneUser.classList.remove('animated'); 
		phoneUser.classList.remove('swing'); 
		emailUser.classList.remove('animated');
		emailUser.classList.remove('swing');
		pass1.classList.remove('animated');
		pass1.classList.remove('swing');
		pass2.classList.remove('animated');
		pass2.classList.remove('swing');
		genero.classList.remove('error');
	}

	checkRegisterForm = () =>{  
		if(nameUser.value === ""){
			nameUser.classList.add('animated');
			nameUser.classList.add('swing');
			return false;
		}
		if(apellidoRegister.value === ''){
			apellidoRegister.classList.add('animated');
			apellidoRegister.classList.add('swing');
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
		if(pass1.value === ''){
			pass1.classList.add('animated');
		    pass1.classList.add('swing');
		    return false;
		}
		if(!validatePassword(pass1.value)){
			pass1.classList.add('animated');
		    pass1.classList.add('swing');
		    return false;
		}
		if(pass1.value !== pass2.value){
			pass2.classList.add('animated');
		    pass2.classList.add('swing');
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
	        formData.append('name',`${nameUser.value} ${apellidoRegister.value}`);
	        formData.append('phone', phoneUser.value);
	        formData.append('email', emailUser.value);
	        formData.append('password', pass1.value);
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
					if(!myObj.return){
						hideLoading();
						setModalError(myObj.message);
						setTimeout(function(){closeModal();}, 5000);
					}else{
						closeModal();
						window.location.href = "cart";
		            }
				}
			}
			xhr.open('POST','../include/LOGIN-registerClient.php', true);
			xhr.send(formData);    
    	}else{
    		setTimeout(()=>{
    			clearRegisterForm();
    		},5000);
    	}
    }

    const registerForm = document.getElementById('registerForm');
    registerForm.addEventListener('submit',(event)=>{
    	event.preventDefault();
    	registerClient();
    });

    clearLoginForm = () =>{
    	emailLogin.classList.remove('animated');
    	emailLogin.classList.remove('swing');
    	passwordLogin.classList.remove('animated');
    	passwordLogin.classList.remove('swing');
    }
    checkLoginForm = () =>{
    	if(emailLogin.value === ""){
			emailLogin.classList.add('animated');
		    emailLogin.classList.add('swing');
		    return false;	
		}
		if(!validateEmail(emailLogin.value)){
			emailLogin.classList.add('animated');
		    emailLogin.classList.add('swing');
		    return false;
		}
		if(passwordLogin.value === ''){
			passwordLogin.classList.add('animated');
		    passwordLogin.classList.add('swing');
		    return false;
		}
		return true;
    }

    loginClient = () =>{
    	if(checkLoginForm()){
    		resetModal();
			showLoading();
    		openModal();

    		const formData2 = new FormData();
	        formData2.append('email', emailLogin.value);
	        formData2.append('password', passwordLogin.value);

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
						window.location.href = "cart";
		            }
				}
			}
			xhr.open('POST','../include/LOGIN-loginClient.php', true);
			xhr.send(formData2); 

    	}
    	else{
    		setTimeout(()=>{
    			clearLoginForm();
    		},5000);
    	}
    }

    const loginForm = document.getElementById('loginForm');
    loginForm.addEventListener('submit',(event)=>{
    	event.preventDefault();
    	loginClient();
    });


