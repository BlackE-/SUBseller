	let emailReset  = document.getElementById('emailReset');

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

	clearResetForm = () =>{
		emailReset.classList.remove('animated');
		emailReset.classList.remove('swing');
	}

	checkResetFrom = () =>{  
		if(emailReset.value === ""){
			emailReset.classList.add('animated');
		    emailReset.classList.add('swing');
		    return false;	
		}
		if(!validateEmail(emailReset.value)){
			emailReset.classList.add('animated');
		    emailReset.classList.add('swing');
		    return false;
		}
		return true;
	}

	passwordReset = () =>{
    	if(checkResetFrom()){
    		resetModal();
			showLoading();
    		openModal();
    		
    		const formData = new FormData();
	        formData.append('email', emailReset.value);

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
						setModalError(myObj.message);
						setTimeout(function(){closeModal();}, 5000);
		            }
				}
			}
			xhr.open('POST','./include/PSW-passwordReset.php', true);
			xhr.send(formData);    
    	}else{
    		setTimeout(()=>{
    			clearResetForm();
    		},5000);
    	}
    }

    const resetForm = document.getElementById('resetForm');
    resetForm.addEventListener('submit',(event)=>{
    	event.preventDefault();
    	passwordReset();
    });
    