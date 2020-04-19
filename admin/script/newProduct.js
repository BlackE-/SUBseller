	const addTemporaryClass = (element, className,duration) =>{
        setTimeout(()=>{
            element.classList.remove(className);
        },duration);
        element.classList.add(className);
    }
	let tagsSelect = [];
	let tagsSelectMap = new Map();
	const xhttp = new XMLHttpRequest();
	const brand = new Selectr('#brandSelect');
	const category = new Selectr('#categorySelect');
	const type = new Selectr('#typeSelect');
	const productsSelect = document.querySelector('.productsSelect');
	if(productsSelect !== null){const products = new Selectr('#productsSelect');}
	const tags = new Selectr('#taggable',{taggable: true,tagSeperators: [",", "|"]});
	tags.on('selectr.select', function(option) {
		const id = option.value;
		const name = option.innerHTML;
		if(Number.isInteger(parseInt(id))){
			tagsSelectMap.set(id,id);
		}else{
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					myObj = JSON.parse(this.response);
					if(!myObj.return){
						console.log(myObj.message);
					}else{
						tagsSelectMap.set(id,myObj.return);
					}
				}
			}
			xhttp.open("POST", "./include/TAG-insertTag.php", true);
        	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        	xhttp.send(`name=${name}`);
		}
	});
	tags.on('selectr.deselect', function(option) {
		const id = option.value;
		tagsSelectMap.delete(id);
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

	const list = document.querySelector(".modal-body p"); 
	const loading = document.querySelector(".lds-dual-ring"); 
	const formData = new FormData();
	checkData = () =>{
		const name = document.querySelector('#name');
		if(name.value.length === 0){
			addTemporaryClass(name ,'animated', 1000);
            addTemporaryClass(name ,'swing', 1000);
			return false;
		}
		const description = document.querySelector('#description');
		if(description.value.length === 0){
			addTemporaryClass(description ,'animated', 1000);
            addTemporaryClass(description ,'swing', 1000);
			return false;
		}
		const description_short = document.querySelector('#description_short');
		if(description_short.value.length === 0){
			addTemporaryClass(description_short ,'animated', 1000);
            addTemporaryClass(description_short ,'swing', 1000);
			return false;
		}
		const tiempo_de_uso = document.querySelector('#tiempo_de_uso');
		if(tiempo_de_uso.value.length === 0){
			addTemporaryClass(tiempo_de_uso ,'animated', 1000);
            addTemporaryClass(tiempo_de_uso ,'swing', 1000);
			return false;
		}

		const price_sale = document.querySelector('#price_sale');
		if(price_sale.value.length === 0){
			addTemporaryClass(price_sale ,'animated', 1000);
            addTemporaryClass(price_sale ,'swing', 1000);
			return false;
		}
		const price_base = document.querySelector('#price_base');
		if(price_base.value.length === 0){
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
			addTemporaryClass(sku ,'animated', 1000);
            addTemporaryClass(sku ,'swing', 1000);
			return false;
		}

		const stock = document.querySelector('#stock');
		if(stock.value.length === 0){
			addTemporaryClass(stock ,'animated', 1000);
            addTemporaryClass(stock ,'swing', 1000);
			return false;
		}

		const brandSelect = document.querySelector('#brandSelect').value;
		const categorySelect = document.querySelector('#categorySelect').value;
		const typeSelect = document.querySelector('#typeSelect').value;
		for (let value of tagsSelectMap.values()) {
		  tagsSelect.push(value);
		}
        const status = document.querySelector("#status").checked; 
        const fav = document.querySelector("#favorite").checked; 
		
		let productsRelated = 0; 
		if(productsSelect !== null){
			productsRelated = document.querySelector('#productsSelect').value;
		}
		
		
		const file = fileInput.files[0];
		if(!file){return false;}
		const file2 = fileInput2.files[0];
		if(!file2){return false;}


		formData.append('file', name.value);
		formData.append('description', description.value);
		formData.append('description_short', description_short.value);
		formData.append('tiempo_de_uso', tiempo_de_uso.value);
		formData.append('file', file);
		formData.append('file_secondary', file2);
		formData.append('price_sale', price_sale.value);
		formData.append('price_base', price_base.value);
		formData.append('discount', discount);
		formData.append('sku', sku);
		formData.append('stock', stock);
		formData.append('brand', brandSelect);
		formData.append('category', categorySelect);
		formData.append('type', typeSelect);
		formData.append('unit', unitSelect);
		formData.append('status', status);
		formData.append('fav', fav);
		formData.append('productsRelated', productsRelated);
		formData.append('tags', tagsSelect);

		return formData;
	}
	const saveNewProduct = document.querySelector('#saveNewProduct').addEventListener('click',function(){
		openModalFunction();
		formProduct = checkData();


		if(!formProduct){
			list.style.opacity = '1';
			loading.style.opacity = '0';
			setTimeout(function(){
				list.style.opacity = '0';
				loading.style.opacity = '1';
				closeModalFunction();
			},500);
		}
	});
	