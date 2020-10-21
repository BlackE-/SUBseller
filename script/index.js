	const modalBody = document.querySelector('.modal-body');
	showLoading = () =>{
		document.querySelector('.lds-spinner').style.display = 'block';
	}
	hideLoading = () =>{
		document.querySelector('.lds-spinner').style.display = 'none';
	}
	resetModal = () =>{
		let c = modalBody.children;
		for (i = 0; i < c.length; i++) {
			if(c[i].tagName == 'P' || c[i].tagName == 'A'){
				c[i].remove();
			}
  		}
	}
	setModalError = (msg) =>{
		const p = document.createElement('p');
		p.innerText = msg;
		modalBody.appendChild(p);
	}


	if("IntersectionObserver" in window){	
		let observerIMG = new IntersectionObserver((entries, observer) => { 
			entries.forEach(entry => {
				if(entry.isIntersecting){
					let src = entry.target.getAttribute('data-src');
					if (!src) { return; }
  					entry.target.src = src;
					// entry.target.classList.add('animated');
					// entry.target.classList.add('zoomIn');
				}
		  	});
		}, {threshold:1});
		// document.querySelectorAll('.slideImg').forEach( p => { observerIMG.observe(p) });
		// document.querySelectorAll('.slideImgMobile').forEach( p => { observerIMG.observe(p) });
		document.querySelectorAll('.bestSellersImg').forEach( p => { observerIMG.observe(p) });

	}
	else{
		console.log("no intersectionobserver");
	}

	

		new Glide('#glideCarousel',{
			type: 'slide',
			// autoplay: 2000,
  			hoverpause: true,
		}).mount();

		const glideBestSellers = document.getElementById('glideBestSellers');
		if(glideBestSellers !== 'undefined'){
			new Glide('#glideBestSellers',{
				type: 'carousel',
				breakpoints:{
					990: {	perView: 2},
			  		2000: { perView: 3}
				}
			}).mount();
		}

		const glideBrands = document.getElementById('glideBrands');
		if(glideBrands !== 'undefined'){
			new Glide('#glideBrands',{
				type: 'carousel',
				breakpoints:{
					440:{perView: 1},
					640:{perView: 2},
					990: {	perView: 4},
			  		2000: { perView: 6}
				}
			}).mount();
		}

		validateEmail = (email) => {
	    	const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	    	return re.test(String(email).toLowerCase());
		}

		const newsletterForm = document.getElementById('newsletterForm');
		newsletterForm.addEventListener('submit',function(e){
			e.preventDefault();
			resetModal();
			showLoading();
			openModal();
			let email = document.getElementById('emailNewsletter');
			if(email == '' || !validateEmail(email.value)){
				hideLoading();
				setModalError('Insertar un correo valido');
				setTimeout(function(){closeModal();}, 2000);
				return false;
			}else{
				let formData = new formData();
				formData.append('email',email.value);
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
							setModalError('Hemos guardado tu correo, espera noticias');
							setTimeout(function(){closeModal();}, 5000);
			            }
					}
				}
				xhr.open('POST','./include/INDEX-insertNewsletter.php', true);
				xhr.send(formData); 
			}

			
		})
