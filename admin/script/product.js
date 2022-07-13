		const addTemporaryClass = (element, className,duration) =>{
        setTimeout(()=>{
            element.classList.remove(className);
        },duration);
        element.classList.add(className);
    }

    function updateTag(id_tag,type){
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.response);
				myObj = JSON.parse(this.response);
				if(!myObj.return){
					console.log(myObj.message);
				}else{
					console.log(myObj.message);
				}
			}
		}
		xhttp.open("POST", "./include/PRODUCT-updateTag.php", true);
    	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    	xhttp.send(`id_product=${document.querySelector('#id_product').value}&id_tag=${id_tag}&type=${type}`);
	}
	function updateCategory(id_category,type){
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.response);
				myObj = JSON.parse(this.response);
				if(!myObj.return){
					console.log(myObj.message);
				}else{
					console.log(myObj.message);
				}
			}
		}
		xhttp.open("POST", "./include/PRODUCT-updateCategory.php", true);
    	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    	xhttp.send(`id_product=${document.querySelector('#id_product').value}&id_category=${id_category}&type=${type}`);
	}
	function updateProductRelated(products){
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.response);
				myObj = JSON.parse(this.response);
				if(!myObj.return){
					console.log(myObj.message);
				}else{
					console.log(myObj.message);
				}
			}
		}
		xhttp.open("POST", "./include/PRODUCT-updateProductRelated.php", true);
    	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    	xhttp.send(`id_product=${document.querySelector('#id_product').value}&product_related=${products}`);
	}
$(document).ready(function(){

    $("#productsSelect").chosen({no_results_text: "Oops, nothing found!"}); 
    $("#categorySelect").chosen({no_results_text: "Oops, nothing found!"}); let product_category = $("#categorySelect").val();
    $("#taggable").chosen({no_results_text: "Oops, nothing found!"}); let product_tags = $("#taggable").val();

    $("#categorySelect").chosen().change(function(e){
        var nuevo = $(this).val();
        let id_category,type = 'add';
        
        if(nuevo.length > product_category.length){
            //insertar nuevo PRODUCTO
            for(var i=0;i<nuevo.length;i++){
                if(product_category.indexOf(nuevo[i]) == -1){
                    id_category = nuevo[i];
                    break;
                }
            }
        }
        else{
            //borrar un PRODUCTO
            type = 'delete';
            for(var i=0;i<product_category.length;i++){
                if(nuevo.indexOf(product_category[i]) == -1){
                    id_category = product_category[i];
                    break;
                }
            }
        }
        updateCategory(id_category,type);
    });

    $("#taggable").chosen().change(function(e){
        var nuevo = $(this).val();
        let id_tag,type = 'add';
        
        if(nuevo.length > product_tags.length){
            //insertar nuevo PRODUCTO
            for(var i=0;i<nuevo.length;i++){
                if(product_tags.indexOf(nuevo[i]) == -1){
                    id_category = nuevo[i];
                    break;
                }
            }
        }
        else{
            //borrar un PRODUCTO
            type = 'delete';
            for(var i=0;i<product_tags.length;i++){
                if(nuevo.indexOf(product_tags[i]) == -1){
                    id_category = product_tags[i];
                    break;
                }
            }
        }
        updateTag(id_category,type);
    });

    $("#productsSelect").chosen().change(function(e){
        var nuevo = $(this).val();
        console.log(nuevo);
        updateProductRelated(nuevo);
    });

    document.querySelector(".saveTag").addEventListener('click',function(){
    	let tagInput = document.querySelector("#addTag");
    	if(tagInput.value.length === 0){
    		addTemporaryClass(tagInput ,'animated', 1000);
            addTemporaryClass(tagInput ,'swing', 1000);
			return false;
    	}

    	let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.response);
				myObj = JSON.parse(this.response);
				if(!myObj.return){
					console.log(myObj.message);
					para.innerText = myObj.message;
				}else{
					$("#taggable").append("<option value='"+myObj.return+"'>"+tagInput.value+"</option>");
                    var valoresTags = $("#taggable").val();
                    valoresTags.push(myObj.return);
                    $("#taggable").val(valoresTags); // if you want it to be automatically selected
                    $("#taggable").trigger("chosen:updated");
                    tagInput.value = '';
                    updateTag(myObj.return,'add');

				}
			}
		}
		xhttp.open("POST", "./include/TAG-insertTag.php", true);
    	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    	xhttp.send(`name=${tagInput.value}`);
    });

});

	
	

	const fileInput = document.getElementById('product_primary');
	const fileInput2 = document.getElementById('product_secondary');
	fileInput.addEventListener('change',function(e){
		const file = fileInput.files[0];
		let id_product = this.getAttribute('title');
		let id_media = this.getAttribute('name');
		let sku = document.querySelector('#sku').value;
		if(id_media === null){
			id_media = 0;
		}
		let formData = new FormData();
		formData.append('file', file);
		formData.append('id_media', id_media);
		formData.append('sku', sku);
		formData.append('id_product', id_product);
		formData.append('type', 'product');

		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.response);
				myObj = JSON.parse(this.response);
				if(!myObj.return){
					console.log(myObj.message);
				}else{
					location.reload();
				}
			}
		}
		xhttp.open("POST", "./include/PRODUCT-setImage.php", true);
    	xhttp.send(formData);
	});

	fileInput2.addEventListener('change',function(e){
		const file2 = fileInput2.files[0];
		let id_product = this.getAttribute('title');
		let sku = document.querySelector('#sku').value;
		let formData = new FormData();
		formData.append('file', file2);
		formData.append('id_media', 0);
		formData.append('sku', sku);
		formData.append('id_product', id_product);
		formData.append('type', 'product_secondary');

		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.response);
				myObj = JSON.parse(this.response);
				if(!myObj.return){
					console.log(myObj.message);
				}else{
					location.reload();
				}
			}
		}
		xhttp.open("POST", "./include/PRODUCT-setImage.php", true);
    	xhttp.send(formData);
	});

	const removeImages = document.querySelectorAll('.removeImage');
	for (const removeImage of removeImages) {
	  	removeImage.addEventListener('click', function(event) {
			let id_media = this.getAttribute("id");
			let id_product = this.getAttribute("name");

			let xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					console.log(this.response);
					myObj = JSON.parse(this.response);
					if(!myObj.return){
						console.log(myObj.message);
					}else{
						location.reload();
					}
				}
			}
			xhttp.open("POST", "./include/PRODUCT-removeImage.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    	xhttp.send(`id_media=${id_media}&id_product=${id_product}`);
		});
	}

	const modalBody = document.querySelector('.modal-body');
	const para = document.createElement("P");
	para.setAttribute("id", "modalNote");
	para.innerText = "Faltan datos"; 
	modalBody.appendChild(para); 

	const list = document.querySelector(".modal-body p"); 
	errorMessage = (message) =>{
		para.innerText = message;
		list.style.opacity = '1';
		setTimeout(function(){
			list.style.opacity = '0';
			closeModalFunction();
		},2000);
	}

	document.querySelector('#productForm').addEventListener('submit',function(e){
		e.preventDefault();
		openModalFunction();
		const name = document.querySelector('#name');
		if(name.value.length === 0){
			errorMessage("Falta titulo");
			addTemporaryClass(name ,'animated', 1000);
            addTemporaryClass(name ,'swing', 1000);
			return false;
		}
		const description = document.querySelector('#description');
		if(description.value.length === 0){
			errorMessage("Falta descripcion");
			addTemporaryClass(description ,'animated', 1000);
            addTemporaryClass(description ,'swing', 1000);
			return false;
		}
		const description_short = document.querySelector('#description_short');
		if(description_short.value.length === 0){
			errorMessage("Falta Descripcion Corta");
			addTemporaryClass(description_short ,'animated', 1000);
            addTemporaryClass(description_short ,'swing', 1000);
			return false;
		}
		const tiempo_de_uso = document.querySelector('#tiempo_de_uso');
		if(tiempo_de_uso.value.length === 0){
			errorMessage("Falta tiempo de uso");
			addTemporaryClass(tiempo_de_uso ,'animated', 1000);
            addTemporaryClass(tiempo_de_uso ,'swing', 1000);
			return false;
		}

		const price_sale = document.querySelector('#price_sale');
		if(price_sale.value.length === 0){
			errorMessage("Falta precio venta");
			addTemporaryClass(price_sale ,'animated', 1000);
            addTemporaryClass(price_sale ,'swing', 1000);
			return false;
		}
		const price_base = document.querySelector('#price_base');
		if(price_base.value.length === 0){
			errorMessage("Falta precio base");
			addTemporaryClass(price_base ,'animated', 1000);
            addTemporaryClass(price_base ,'swing', 1000);
			return false;
		}
		const discountStatus = document.querySelector("#discountStatus");
		const discountInput = document.querySelector("#discount"); 
		let discount;
		if(discountStatus.checked){
			discount = 100 - parseFloat(discountInput);
            discount = discount / 100;
        }
        else{
            discount = 0.0;
        }
		const brandSelect = document.querySelector('#brandSelect').value;
		const categorySelect = document.querySelector('#categorySelect').value;
		const typeSelect = document.querySelector('#typeSelect').value;
		console.log(typeSelect);
		const unitSelect = document.querySelector('#unit').value;
        const status = (document.querySelector("#status").checked) ? 1 : 0; 
        const fav = (document.querySelector("#favorite").checked) ? 1 : 0; 
		

		let formData = new FormData();
		formData.append('id_product', document.querySelector('#id_product').value);
		formData.append('name', name.value);
		formData.append('description', description.value);
		formData.append('description_short', description_short.value);
		formData.append('tiempo_de_uso', tiempo_de_uso.value);
		formData.append('price_sale', price_sale.value);
		formData.append('price_base', price_base.value);
		formData.append('discount', discount);
		formData.append('brand', brandSelect);
		formData.append('category', categorySelect);
		formData.append('type', typeSelect);
		formData.append('unit', unitSelect);
		formData.append('status', status);
		formData.append('fav', fav);

		list.style.opacity = '0';
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.response);
				myObj = JSON.parse(this.response);
				if(!myObj.return){
					console.log(myObj.message);
					para.innerText = myObj.message;
				}else{
					location.reload();
				}
			}
		}
		xhttp.open("POST", "./include/PRODUCT-updateProduct.php", true);
    	// xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    	xhttp.send(formData);
	});
	