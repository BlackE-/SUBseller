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

	const typePaymentBoxs = document.querySelectorAll('.typePaymentBox');
	const typePayments = document.querySelectorAll('input[name="typePayment"]');
	for(let typePayment of typePayments){
		typePayment.addEventListener('change',function(){
			for(let typePaymentBox of typePaymentBoxs){
				typePaymentBox.classList.remove('active');
			}
			let id_active = `box-${this.getAttribute('id')}`;
			document.getElementById(id_active).classList.add('active');
		});
	}

	const question = document.getElementById('question');
	question.addEventListener('click',()=>{
		question.classList.add('show');
		setTimeout(()=>{
			question.classList.remove('show');
		},3000);
	});

	//paypal
	paypalComplete = (id_paypal) =>{
			//ajax to all that PAYPAL already aproved
			console.log(id_paypal);
			let fd = new FormData();
			fd.append('id_paypal',id_paypal);
			
			//ajax
			const xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {
					myObj = JSON.parse(this.response);
					console.log(myObj);
					if(!myObj.return){
						//return false is error
						hideLoading();
						setModalError(myObj.message);
						setTimeout(()=>{closeModal();},5000);
					}else{
						//windows relocation
						let url = `confirm?id_order=${myObj.return}`;
						window.location.href = url
					}	
				}
			}
			xhr.open('POST','./include/PAYPAL-completeOrder.php', true);
			xhr.send(fd);
	}

	loadPaypalScript = (url, callback) => {
		// adding the script tag to the head as suggested before
		let head = document.getElementsByTagName('head')[0];
		let script = document.createElement('script');
		script.type = 'text/javascript';
		script.src = url;
		head.appendChild(script);

		   //PAYPAL
		setTimeout(function(){
			paypal.Buttons({
						createOrder: function (data, actions) {
						  return fetch('../include/PAYPAL-createOrder.php', {
						    method: 'POST'
						  }).then(function(res) {
						    return res.json();
						  }).then(function(data) {
						  		console.log(data);
						  		return data.id;
						  });
						},
						onApprove: function (data, actions) {
							console.log(data);
							console.log(actions);
							resetModal();
							openModal();
							showLoading();

						  	return fetch('../include/PAYPAL-captureOrder.php?id_order=' + data.orderID, {
						    	method: 'POST'
							}).then(function(res) {
							    console.log(res);
							    if (!res.ok) {
							    	hideLoading();
							    	setModalError('Ocurrio un error, si el error persiste elegir otro método de pago');
							    	setTimeout(()=>{closeModal();},2000);
							    }
							  	else{
							  		paypalComplete(data.orderID);
							  	}
						  	});
						  
						},
						onCancel: function (data) {
				  			resetModal();
							openModal();
							hideLoading();
							setModalError('Cancelado pago con PAYPAL');
							setTimeout(()=>{closeModal();},2000);
				  		},
				  		onError: function (err) {
							// console.log(err);
							resetModal();
							openModal();
							hideLoading();
							setModalError('Ocurrío un error con Paypal, si el problema persiste, elegir otro método de pago');
							setTimeout(()=>{closeModal();},5000);
						}
					}).render('#paypal-button-container');
		},2000);
		
	}

	getClientIdPaypal = () =>{
		//getKey
		let key = '';
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				myObj = JSON.parse(this.response);
				key = myObj.return;
			}
		}
		xhr.open('POST','../include/PAYMENT-getPaypalKey.php', '');
		xhr.send();
		return key;
	}
	let clientId = getClientIdPaypal();
	const urlPaypal = `https://www.paypal.com/sdk/js?client-id=${clientId}&disable-funding=credit,card&currency=MXN`;
	loadPaypalScript(urlPaypal,'');	

	const paypalButton = document.getElementById('paypal-button-container');
	paypalButton.style.display = 'none';

	//COUPON
	const coupon = document.getElementById('coupon');
	const subtotalContainer = document.getElementById('subtotalContainer');
	const subtotalText = document.getElementById('subtotal');
	const totalContainer = document.getElementById('totalContainer');
	const totalText = document.getElementById('total');
	const deliveryCostContainer = document.getElementById('deliveryCostContainer');
	const deliveryCost = document.getElementById('deliveryCost');

	checkCouponInput = () =>{
		if(coupon.value == ''){
			coupon.classList.add('animated');
			coupon.classList.add('swing');
			return false;
		}
		return true;
	}
	clearCoupunInput = () =>{
		coupon.value = '';
		coupon.classList.remove('animated');
		coupon.classList.remove('swing');
	}
	setUpProducts = (products_list) =>{
		// console.log(products_list);
		// console.log(typeof products_list);
		for(let product of products_list){
			let newPPrice = `$${product.newPrice.toFixed(2)}`;
			let div_p = document.getElementById(`id_row_${product.id_product}`);
			div_p.getElementsByClassName('totalRow')[0].style.textDecoration = 'line-through';
			div_p.getElementsByClassName('totalRow')[0].style.opacity = '0.5';
			let strNewPrice = newPPrice.split('.');
			div_p.insertAdjacentHTML('beforeend', `<p>${strNewPrice[0]}.<sup>${strNewPrice[1]}</sup></p>`);
		}
	}
	setUpShipping = (shipping) =>{
		let newShipping = `$${shipping.toFixed(2)}`;
		if(newShipping === deliveryCost.innerText){
			return false;
		}
		deliveryCost.style.textDecoration = 'line-through';
		deliveryCost.style.opacity = '0.5';
		let strNewShip = newShipping.split('.');
		deliveryCostContainer.insertAdjacentHTML('beforeend', `<p>${strNewShip[0]}.<sup>${strNewShip[1]}</sup></p>`);
	}
	setUpSubtotal = (subtotal) =>{
		let newSubtotal = `$${subtotal.toFixed(2)}`;
		if(newSubtotal === subtotalText.innerText){
			return false;
		}
		subtotalText.style.textDecoration = 'line-through';
		subtotalText.style.opacity = '0.5';
		let strNewSubTotal = newSubtotal.split('.');
		subtotalContainer.insertAdjacentHTML('beforeend', `<p>${strNewSubTotal[0]}.<sup>${strNewSubTotal[1]}</sup></p>`);
	}
	setUpTotal = (total) =>{
		let newTotal = `$${total.toFixed(2)}`;
		if(newTotal === totalText.innerText){
			return false;
		}
		totalText.style.textDecoration = 'line-through';
		totalText.style.opacity = '0.5';
		let strNewTotal = newTotal.split('.');
		totalContainer.insertAdjacentHTML('beforeend', `<p>${strNewTotal[0]}.<sup>${strNewTotal[1]}</sup></p>`);
	}
	setupProducts = (products_list) =>{
		// console.log(products_list);
		// console.log(typeof products_list);
		for(let product of products_list){
			// console.log(product);
			let div_p = document.getElementById(`id_row_${product.id_product}`);
			div_p.getElementsByClassName('totalRow')[0].style.textDecoration = 'line-through';
			let newPrice = document.createElement('p');
			let newPriceText = document.createTextNode(product.newPrice);      // Create a text node
			newPrice.appendChild(newPriceText);                                          // Append the text to <p>
			div_p.appendChild(newPrice); 
		}
	}

	const checkCoupon = document.getElementById('checkCoupon');
	checkCoupon.addEventListener('click',function(){
		if(checkCouponInput()){
			resetModal();
			openModal();
			showLoading();
			const formCoupon = new FormData();
	        formCoupon.append('coupon',coupon.value);
			const xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {
					// console.log(this.response);
					myObj = JSON.parse(this.response);
					if(!myObj.return){
						hideLoading();
						setModalError(myObj.message);
						clearCoupunInput();
						setTimeout(function(){closeModal();}, 5000);
					}else{
						// console.log(myObj);
						switch(myObj.return.type){
							case 'free_shipping':
								setUpShipping(myObj.return.shipping);
								setUpTotal(myObj.return.total);
								closeModal();
							break;
							case 'fixed_products':case 'percetage_products':
								setUpProducts(myObj.return.products);
								setUpSubtotal(myObj.return.subtotal);
								setUpShipping(myObj.return.shipping);
								setUpTotal(myObj.return.total);
								closeModal();
							break;
							case 'fixed':case 'percetage':
								setUpTotal(myObj.return.total);
								setUpShipping(myObj.return.shipping);
								closeModal();
							break; 
						}
						checkCoupon.setAttribute('disabled','');
						coupon.setAttribute('disabled','');
		            }
				}
			}
			xhr.open('POST','../include/PAYMENT-checkCoupon.php', true);
			xhr.send(formCoupon); 
		}else{
			setTimeout(()=>{
    			clearCoupunInput();
    		},5000);
		}
	});

	//getKey
	getKey = () =>{
		let key = '';
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				myObj = JSON.parse(this.response);
				key = myObj.return;
			}
		}
		xhr.open('POST','../include/PAYMENT-getConektaKey.php', '');
		xhr.send();
		return key;
	}

	//conekta
	const saveCard = document.getElementById('saveCard');
	conektaSuccessResponseHandler = (token)=> {
		let fd = new FormData();
		fd.append('type','card');
		fd.append('coupon',coupon.value);
		fd.append('newCard',1);
		fd.append('token',token.id);
		fd.append('saveCard',saveCard.checked);
		
		//ajax
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				myObj = JSON.parse(this.response);
				// console.log(myObj);
				if(!myObj.return){
					//return false is error
					hideLoading();
					setModalError(myObj.message);
					setTimeout(()=>{closeModal();},5000);
				}else{
					//windows relocation
					let url = `confirm?id_order=${myObj.return}`;
					window.location.href = url
				}	
			}
		}
		xhr.open('POST','../include/PAYMENT-pay.php', true);
		xhr.send(fd);
	}
	conektaErrorResponseHandler = (response) =>{ 
		resetModal();
		openModal();
		hideLoading();
		setModalError(response.message_to_purchaser);
		setTimeout(()=>{closeModal();},2000);
		return false;
	};

	//pay
	const checkTerminos = document.getElementById('checkTerminos');
	checkTerminos.addEventListener('change',function(){
		(checkTerminos.checked) ? paypalButton.style.display = 'block' : paypalButton.style.display = 'none'; 
	});
	const next = document.getElementById('next');
	next.addEventListener('click',function(){
		if(checkTerminos.checked){
			resetModal();
			showLoading();
			openModal();
			let type = document.querySelector('input[name="typePayment"]:checked').getAttribute('id');
			switch(type){
				case 'card':
					let id_card = document.querySelector("input[name='card']:checked").value;
					const formCard = document.getElementById('cardForm');
					if(typeof id_card === 'undefined'){
						hideLoading();
						setModalError('Elegir una tarjeta');
						setTimeout(()=>{closeModal();},2000);
						return false;
					}

					//get public key conekta
					let public_key_conekta = getKey();
					if(id_card === '0'){
						console.log("PAGAR CON TARJETA NUEVA");	
						Conekta.setPublicKey(public_key_conekta);
						Conekta.setLanguage("es");
						Conekta.token.create(formCard, conektaSuccessResponseHandler, conektaErrorResponseHandler);
					}else{
						// console.log("PAGAR TARJETA: "+id_card);
						let fd = new FormData();
						fd.append('type',type);
						fd.append('coupon',coupon.value);
						fd.append('saveCard',false);
    					fd.append("id_card",id_card);//no necesita token por que la tarjeta ya fue guardada en CONKETA
    					fd.append("newCard",0);
    					const xhr = new XMLHttpRequest();
						xhr.onreadystatechange = function(){
							if (this.readyState == 4 && this.status == 200) {
								myObj = JSON.parse(this.response);
								// console.log(myObj);
								if(!myObj.return){
									//return false is error
									hideLoading();
									setModalError(myObj.message);
									setTimeout(()=>{closeModal();},5000);
								}else{
									//windows relocation
									let url = `confirm?id_order=${myObj.return}`;
									window.location.href = url
								}	
							}
						}
						xhr.open('POST','../include/PAYMENT-pay.php', true);
						xhr.send(fd);
    					
					}
				break;
				default:
					let fd = new FormData();
					fd.append('type',type);
					fd.append('coupon',coupon.value);
					const xhr = new XMLHttpRequest();
					xhr.onreadystatechange = function(){
						if (this.readyState == 4 && this.status == 200) {
							myObj = JSON.parse(this.response);
							// console.log(myObj);
							if(!myObj.return){
								//return false is error
								hideLoading();
								setModalError(myObj.message);
								setTimeout(()=>{closeModal();},5000);
							}else{
								closeModal();
								//windows relocation
								let url = `confirm?id_order=${myObj.return}`;
								Window.location.href = url
							}
						}
					}
					xhr.open('POST','../include/PAYMENT-pay.php', true);
					xhr.send(fd);

				break;
			}
			return false;

		}else{
			resetModal();
			openModal();
			hideLoading();
			setModalError('Debe de aceptar Términos y Condiciones');
			setTimeout(()=>{
    			closeModal();
    		},2000);
			return false;
		}
	});