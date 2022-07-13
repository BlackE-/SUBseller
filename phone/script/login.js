	let nameUser = document.getElementById("nameRegister"); 
    let apellidoRegister = document.getElementById('apellidoRegister');
    let emailUser  = document.getElementById('emailRegister');
    let phoneUser = document.getElementById('phoneRegister'); 
    let newsletter = document.getElementById('checkNewsletter');
	let pass1 = document.getElementById('password1');
	let pass2 = document.getElementById('password2');
    
    let emailLogin = document.getElementById('emailLogin');
    let passwordLogin = document.getElementById('passwordLogin');


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


	validateEmail = (email) => {
    	const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    	return re.test(String(email).toLowerCase());
	}
	
	pass1.onkeyup = () =>{
		// Validate lowercase letters
		  const lowerCaseLetters = /[a-z]/g;
		  if(pass1.value.match(lowerCaseLetters)) {  
		    document.getElementById('min').classList.add("valid");
		  } else {
		    document.getElementById('min').classList.remove("valid");
		  }
		  
		  // Validate capital letters
		  const upperCaseLetters = /[A-Z]/g;
		  if(pass1.value.match(upperCaseLetters)) {  
		    document.getElementById('MAY').classList.add("valid");
		  } else {
		    document.getElementById('MAY').classList.remove("valid");
		  }

		  // Validate numbers
		  const numbers = /[0-9]/g;
		  if(pass1.value.match(numbers)) {  
		    document.getElementById('num1').classList.add("valid");
		  } else {
		    document.getElementById('num1').classList.remove("valid");
		  }
		  
		  // Validate length
		  if(pass1.value.length >= 8) {
		    document.getElementById('8char').classList.add("valid");
		  } else {
		    document.getElementById('8char').classList.remove("valid");
		  }
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
		pass1.classList.remove('animated');
		pass1.classList.remove('swing');
		pass2.classList.remove('animated');
		pass2.classList.remove('swing');
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
						hideLoading();
						setModalError('Tu cuenta ha sido creada');
						setTimeout(function(){window.location.href = "cart";}, 2000);
		            }
				}
			}
			xhr.open('POST','../include/LOGIN-registerClient.php', true);
			xhr.send(formData);    
    	}else{
    		resetModal();
			openModal();
			hideLoading();
			setModalError('Por favor, llena todos campos');
    		setTimeout(()=>{
    			clearRegisterForm();
    			closeModal();
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
    		resetModal();
			openModal();
			hideLoading();
			setModalError('Por favor, llena todos campos');
    		setTimeout(()=>{
    			clearLoginForm();
    			closeModal();
    		},5000);
    	}
    }

    const loginForm = document.getElementById('loginForm');
    loginForm.addEventListener('submit',(event)=>{
    	event.preventDefault();
    	loginClient();
    });

    //facebook 
    checkLoginFacebook = (id_facebook) =>{
		let formData = new FormData();
		formData.append('id_facebook',id_facebook);
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
					hideLoading();
					window.location.href = "cart";
	            }
			}
		}
		xhr.open('POST','../include/LOGIN-loginClientFacebook.php', true);
		xhr.send(formData); 
	}


    // Load the SDK asynchronously
	let firstTime = sessionStorage.getItem("first_time");
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	
	window.fbAsyncInit = function() {
		FB.init({
			appId      : '3391808017516190',
			cookie     : true,  // enable cookies to allow the server to access // the session
			xfbml      : true,  // parse social plugins on this page
			version    : 'v3.0' // use graph api version 2.5
		});

		FB.getLoginStatus(function(response) {
			console.log(response);
		    if(typeof(response) != 'undefined'){
		        let status = response.status;
		        if(status === 'connected'){
				    let userid = response.authResponse.userID;
        		    checkLoginFacebook(userid);
		        }
		    }
		});
	};


	
    
    const registerFacebook = document.getElementById('registerFacebook');
    registerFacebook.addEventListener('click',(event)=>{
    	resetModal();
		showLoading();
    	openModal();

    	FB.getLoginStatus(function(response) {
    		let status = response.status;
    		switch(status){
    			case 'connected':
    				//call to loginwithFacebook iD
    				let userid = response.authResponse.userID;
    				checkLoginFacebook(userid);
    			break;
    			default:
    				FB.login(function(response) {
		        		if (response.authResponse) {
				            console.log('Welcome!  Fetching your information.... ');
				            console.log(response); // dump complete info
				            FB.api('/me?fields=id,email,name',function(responseFB){
				            	console.log(responseFB);
				            	console.log(responseFB.email);
				                let user_email = responseFB.email; //get user email
								if(typeof responseFB.email == "undefined"){
									hideLoading();
									setModalError('No pudimos recuperar tu correo');
									setTimeout(function(){closeModal();}, 5000);
									return false;
								}else{
									let user_name = responseFB.name;
					                let user_id = responseFB.id;
					                console.log(responseFB);
					                console.log(user_name);
					          		let formData = new FormData();
					          		formData.append('facebook_name',user_name);
					          		formData.append('id_facebook',user_id);
					          		formData.append('facebook_email',facebook_email);

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
												setModalError('Tu cuenta ha sido creada');
												setTimeout(function(){window.location.href = "cart";}, 2000);
								            }
										}
									}
									xhr.open('POST','../include/LOGIN-registerClientFacebook.php', true);
									xhr.send(formData); 
								}   
				            });
				        } else {
				            //user hit cancel button
				            hideLoading();
							setModalError('Login con Facebook cancelado');
							setTimeout(function(){closeModal();}, 5000);
				        }
				   	},{'scope': 'email',return_scopes: true});//FB.login
    			break;
    		}
		});
    });

    const loginFacebook = document.getElementById('loginFacebook');
    loginFacebook.addEventListener('click',(event)=>{
    	resetModal();
		showLoading();
    	openModal();
    	FB.getLoginStatus(function(response) {
	        let userid = response.authResponse.userID;
    		checkLoginFacebook(userid);
		});
    });


