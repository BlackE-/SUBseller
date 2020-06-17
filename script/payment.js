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

	//type payment
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
		coupon.classList.remove('animated');
		coupon.classList.remove('swing');
	}
	setUpProducts = (products_list) =>{
		console.log(products_list);
		console.log(typeof products_list);
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
						setTimeout(function(){closeModal();}, 5000);
					}else{
						console.log(myObj);
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
			xhr.open('POST','./include/PAYMENT-checkCoupon.php', true);
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
		xhr.open('POST','./include/PAYMENT-getConektaKey.php', '');
		xhr.send();
		return key;
	}

	//conekta
	conektaSuccessResponseHandler = (token)=> {
		let fd = new FormData();
		fd.append('type','card');
		fd.append('coupon',coupon.value);
		fd.append('newCard',1);
		fd.append('token',token.id);
		

		//ajax



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
	const next = document.getElementById('next');
	next.addEventListener('click',function(){
		if(checkTerminos.checked){
			let type = document.querySelector('input[name="typePayment"]:checked').getAttribute('id');
			switch(type){
				case 'card':
					let id_card = document.querySelector("input[name='card']:checked").value;
					const formCard = document.getElementById('cardForm');
					if(typeof id_card === 'undefined'){
						resetModal();
						openModal();
						hideLoading();
						setModalError('Elegir una tarjeta');
						setTimeout(()=>{closeModal();},2000);
					}
					//get public key conekta
					let public_key_conekta = getKey();
					if(id_card === '0'){
						console.log("PAGAR CON TARJETA NUEVA");	
						Conekta.setPublicKey(public_key_conekta);
						Conekta.setLanguage("es");
						Conekta.token.create(formCard, conektaSuccessResponseHandler, conektaErrorResponseHandler);
					}else{
						console.log("PAGAR TARJETA: "+id_card);
						let fd = new FormData();
						fd.append('type',type);
						fd.append('coupon',coupon.value);
						//no necesita token por que la tarjeta ya fue guardada en CONKETA
    					fd.append("id_card",id_card);
    					fd.append("newCard",0);
					}
				break;
				default:
					let fd = new FormData();
					fd.append('type',type);
					fd.append('coupon',coupon.value);
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