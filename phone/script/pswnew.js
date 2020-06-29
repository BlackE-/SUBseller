	let email = document.getElementById('email');
    let passwordNew = document.getElementById('passwordNew');

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

	validatePassword = (value) =>{
		// const pa = /^[a-zA-Z0-9]{8,}$/;	//Minimum 8 Character Password with lowercase, uppercase letters and numbers 
		const pa = /^[a-zA-Z0-9@#$%^&+!=]{8,}$/;	//Minimum 8 Character Password with lowercase, uppercase letters and numbers 
		// const pa = /(?=[A-Za-z0-9@#$%^&+!=]+$)^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$%^&+!=]){8,}$/;	//At least 8 characters, min 1 Uppercase 1 Lowercase 1 Number 1 special character and only contains symbols from the alphabet, num 
		return pa.test(value);
	}

	clearNewForm = () =>{
		passwordNew.classList.remove('animated');
		passwordNew.classList.remove('swing');
	}

	checkNewFrom = () =>{  
		if(passwordNew.value === ""){
			passwordNew.classList.add('animated');
		    passwordNew.classList.add('swing');
		    return false;	
		}
		if(!validatePassword(passwordNew.value)){
			passwordNew.classList.add('animated');
		    passwordNew.classList.add('swing');
		    return false;
		}
		return true;
	}

	pswNew = () =>{
    	if(checkNewFrom()){
    		resetModal();
			showLoading();
    		openModal();
    		
    		const formData = new FormData();
	        formData.append('email', email.value);
	        formData.append('password', passwordNew.value);
	        console.log(passwordNew.value);

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
						window.location.href = "login";
		            }
				}
			}
			xhr.open('POST','../include/PSW-passwordNew.php', true);
			xhr.send(formData);    
    	}else{
    		setTimeout(()=>{
    			clearNewForm();
    		},5000);
    	}
    }

    const newForm = document.getElementById('newForm');
    if(newForm !== null){
    	newForm.addEventListener('submit',(event)=>{
    		event.preventDefault();
    		pswNew();
    	});
    }
    