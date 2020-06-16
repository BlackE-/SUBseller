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


	//COUPON
	const coupon = document.getElementById('coupon');
	const totalContainer = document.getElementById('totalContainer');
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

	setupProducts = (products_list) =>{
		console.log(products_list);
		console.log(typeof products_list);
		for(let product of products_list){
			console.log(product);
			let div_p = document.getElementById(`id_row_${product.id_product}`);
			div_p.getElementsByClassName('totalRow')[0].style.textDecoration = 'line-through';
			let newPrice = document.createElement('p');
			let newPriceText = document.createTextNode(product.newPrice);      // Create a text node
			newPrice.appendChild(newPriceText);                                          // Append the text to <p>
			div_p.appendChild(newPrice); 
		}
	}
	setUpSubtotal = (subtotal) =>{
		document.getElementById('subtotal').innerText = subtotal;
	}

	setUpShipping = (shipping) =>{
		console.log(shipping);
	}

	setUpTotal = (total) =>{
		console.log(total);
		document.getElementById('totalContainer');
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
					console.log(this.response);
					myObj = JSON.parse(this.response);
					if(!myObj.return){
						hideLoading();
						setModalError(myObj.message);
						setTimeout(function(){closeModal();}, 5000);
					}else{
						console.log(myObj);
						switch(myObj.return.type){
							case 'free_shipping':
								setUpFreeDelivery(myObj.return.shipping);
								setUpTotal(myObj.return.total);
								closeModal();
							break;
							case 'fixed_products':case 'percentage_products':
								setupProducts(myObj.return.products);
								setUpShipping(myObj.return.shipping);
								setUpTotal(myObj.return.total);
								closeModal();
							break;
							case 'fixed':case 'percentage':
								setUpTotal(myObj.return.total);
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