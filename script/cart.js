	const modalBody = document.querySelector('.modal-body');
	showLoading = () =>{
		document.querySelector('.lds-dual-ring').style.display = 'block';
	}
	hideLoading = () =>{
		document.querySelector('.lds-dual-ring').style.display = 'none';
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

	updateCart = (id_product,typeUpdate) =>{
		showLoading();
		openModal();
		//add product to cart
		const formData = new FormData();
        let quantity = document.getElementById(id_product).value;
        if(typeUpdate == 'stepDown'){
			quantity--;
		}else{
			quantity++;
		}
        let price = document.getElementById('price_'+id_product).value;
        
        formData.append('id_product', id_product);
		formData.append('quantity', quantity);
		formData.append('price', price);

		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.response);
				myObj = JSON.parse(this.response);
				hideLoading();
				if(myObj.return){
					//true
					if(typeUpdate == 'stepDown'){
						document.getElementById(id_product).stepDown(1);
					}else{
						document.getElementById(id_product).stepUp(1);
					}
					closeModal();
				}else{
					setModalError(myObj.message);
					setTimeout(()=>{
						closeModal()
						resetModal();
					},2000);
				}
			}
		}
		xhr.open('POST', './include/CART-updateCart.php', true);
		xhr.send(formData); 
	}


	const minusbuttons = document.querySelectorAll('.minus');
	for(let minusbutton of minusbuttons){
		minusbutton.addEventListener('click',()=>{
			let id_product = minusbutton.getAttribute('name');
			let qty = document.getElementById(id_product).value;
			if(qty-1 >= 1){
				updateCart(id_product,'stepDown');
			}
		});
	}

	const moreButtons = document.querySelectorAll('.more');
	for(let moreButton of moreButtons){
		moreButton.addEventListener('click',()=>{
			let id_product = moreButton.getAttribute('name');
			updateCart(id_product,'stepUp');
		});
	}
