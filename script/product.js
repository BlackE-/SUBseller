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
	setModal =() =>{
		const p = document.createElement('p');
		p.innerText = '¡PRODUCTO AÑADIDO A TU CARRITO!';
		modalBody.appendChild(p);

		const a = document.createElement('a');  
	    const link = document.createTextNode("Ir a carrito"); 
	    a.appendChild(link);  
	    a.title = "cart";  
	    a.href = "cart";  
	    modalBody.appendChild(a);

	    const a2 = document.createElement('a');  
	    const linkeep = document.createTextNode("Seguir comprando"); 
	    a2.appendChild(linkeep);  
	    a2.title = "seguir comprando";  
	    a2.href = "store";  
	    modalBody.appendChild(a2);
	}

	setModalError = (msg) =>{
		const p = document.createElement('p');
		p.innerText = msg;
		modalBody.appendChild(p);
	}

	let qty = 1;
	const inputQty = document.getElementById('qty');
	setQty = () =>{
		inputQty.value = qty;
	}

	document.getElementById('more').addEventListener('click',()=>{qty++;setQty();});
	document.getElementById('minus').addEventListener('click',()=>{qty--; if(qty<1) {qty = 1;}setQty();});

	const thumbSelected= document.getElementById('thumbSelected');
	const thumbs = document.querySelectorAll('.thumb');
	removeSelected = () =>{
		for(let thumb of thumbs){
			thumb.classList.remove('selected');
		}
	}
	for(let thumb of thumbs){
		thumb.addEventListener('click',()=>{
			removeSelected();
			let newSrc = thumb.getAttribute('src');
			thumbSelected.setAttribute('src',newSrc);
			thumb.classList.add('selected');
		});
	}

	  



	document.getElementById('addToCart').addEventListener('click',()=>{
		showLoading();
		openModal();
		//add product to cart
		const formData = new FormData();
        let id_product = document.getElementById('id_product').value;
        let quantity = document.getElementById('qty').value;
        let price = document.getElementById('price').value;
        let receta = `<table><tr><th></th><th>Esfera</th><th>Cilindro</th><th>Eje</th><th>Add</th></tr>
    					<tr><th class="od"><p>OD</p></th>
	            		<td><p>${document.getElementById('od_esfera').value}</p></td>
	            		<td><p>${document.getElementById('od_cilindro').value}</p></td>
	            		<td><p>${document.getElementById('od_eje').value}</p></td>
	            		<td><p>${document.getElementById('od_add').value}</p></td>
	            		</tr>
	            		<tr><th class="id"><p>OI</p></th>
	            		<td><p>${document.getElementById('oi_esfera').value}</p></td>
	            		<td><p>${document.getElementById('oi_cilindro').value}</p></td>
	            		<td><p>${document.getElementById('oi_eje').value}</p></td>
	            		<td><p>${document.getElementById('oi_add').value}</p></td>
	            		</tr>
	            		<tr>
	            		<td colspan="5"><p>Observaciones: ${document.getElementById('notes').value}</p></td>
	            		</tr>
	            		</table>`;



        formData.append('id_product', id_product);
		formData.append('quantity', quantity);
		formData.append('price', price);
		formData.append('receta', receta);

		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.response);
				myObj = JSON.parse(this.response);
				hideLoading();
				if(myObj.return){
					//true
					setModal();
				}else{
					setModalError(myObj.message);
					//after return
					setTimeout(()=>{
						closeModal()
						resetModal();
					},2000);
				}
			}
		}
		xhr.open('POST', './include/PRODUCT-addProductToCart.php', true);
		xhr.send(formData);  



	});