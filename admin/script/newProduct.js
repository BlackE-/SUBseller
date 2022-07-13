	const addTemporaryClass = (element, className,duration) =>{
        setTimeout(()=>{
            element.classList.remove(className);
        },duration);
        element.classList.add(className);
    }
$(document).ready(function(){
	$("#categorySelect").chosen({no_results_text: "Oops, nothing found!"}); 
		if(productsSelect != 'null'){
			$("#productsSelect").chosen({no_results_text: "Oops, nothing found!"}); 
		}
	
    $("#taggable").chosen({no_results_text: "Oops, nothing found!"}); 

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
                    // console.log(valoresTags);

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
		let input_ = this;
		let label_ = input_.nextElementSibling;
		let labelVal = label_.innerHTML;

		let fileName;
		if(this.files && this.files.length > 1){
			fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}',this.files.length);
		}else if(e.target.value)
			fileName = e.target.value.split( '\\').pop();

		if(fileName)
			label_.innerHTML = fileName;
		else
			label_.innerHTML = labelVal;
	});

	fileInput2.addEventListener('change',function(e){
		let input_ = this;
		let label_ = input_.nextElementSibling;
		let labelVal = label_.innerHTML;

		let fileName;
		if(this.files && this.files.length > 1){
			fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}',this.files.length);
		}else if(e.target.value)
			fileName = e.target.value.split( '\\').pop();

		if(fileName)
			label_.innerHTML = fileName;
		else
			label_.innerHTML = labelVal;
	});

	const modalBody = document.querySelector('.modal-body');
	const para = document.createElement("P");
	para.setAttribute("id", "modalNote");
	para.innerText = "Faltan datos"; 
	modalBody.appendChild(para);

	const a = document.createElement('a');
 	a.href = "products";
 	a.appendChild(document.createTextNode('Productos'));
 	a.style.display = 'none'; 
	modalBody.appendChild(a); 

	const list = document.querySelector(".modal-body p"); 
	const loading = document.querySelector(".lds-dual-ring"); 
	errorMessage = (message) =>{
		para.innerText = message;
		list.style.opacity = '1';
		// loading.style.opacity = '0';
		setTimeout(function(){
			list.style.opacity = '0';
			// loading.style.opacity = '1';
			closeModalFunction();
		},2000);
	}

	document.querySelector('#newProductForm').addEventListener('submit',function(e){
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

		const sku = document.querySelector('#sku');
		if(sku.value.length === 0){
			errorMessage("Falta SKU");
			addTemporaryClass(sku ,'animated', 1000);
            addTemporaryClass(sku ,'swing', 1000);
			return false;
		}

		const stock = document.querySelector('#stock');
		if(stock.value.length === 0){
			errorMessage("Falta inventario (stock)");
			addTemporaryClass(stock ,'animated', 1000);
            addTemporaryClass(stock ,'swing', 1000);
			return false;
		}

		const brandSelect = document.querySelector('#brandSelect').value;
		const categorySelect = document.querySelector('#categorySelect').value;
		const typeSelect = document.querySelector('#typeSelect').value;
		const unitSelect = document.querySelector('#unit').value;
		const tagsSelect = document.querySelector('#taggable').value;

        const status = (document.querySelector("#status").checked) ? 1 : 0; 
        const fav = (document.querySelector("#favorite").checked) ? 1 : 0; 
        
		let productsRelated = document.querySelector('#productsSelect').value;
		
		const file = fileInput.files[0];
		if(!file){errorMessage("Falta imagen");return false;}
		const file2 = fileInput2.files[0];

		let formData = new FormData();
		formData.append('name', name.value);
		formData.append('description', description.value);
		formData.append('description_short', description_short.value);
		formData.append('tiempo_de_uso', tiempo_de_uso.value);
		formData.append('file', file);
		formData.append('file_secondary', file2);
		formData.append('price_sale', price_sale.value);
		formData.append('price_base', price_base.value);
		formData.append('discount', discount);
		formData.append('sku', sku.value);
		formData.append('stock', stock.value);
		formData.append('brand', brandSelect);
		formData.append('category', categorySelect);
		formData.append('type', typeSelect);
		formData.append('unit', unitSelect);
		formData.append('status', status);
		formData.append('fav', fav);
		formData.append('productsRelated', productsRelated);
		formData.append('tags', tagsSelect);

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
					console.log('producto Guardado');
					list.style.opacity = '1';
					para.innerText = 'Producto Guardado';
					a.style.display = 'block';
				}
			}
		}
		xhttp.open("POST", "./include/PRODUCT_NEW-insertProduct.php", true);
    	// xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    	xhttp.send(formData);
	});
	