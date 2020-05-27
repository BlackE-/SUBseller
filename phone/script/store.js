	let id_product_2_filter = [];
	const options = {valueNames: [ 'id_product', 'name', 'price','id_brand','category','id_type' ],page: 9,pagination:{outerWindow :1}};
    const userList = new List('products', options);
    const maxPrice = parseInt(document.getElementById('maxPriceValue').value,10);
	let min_price = 0;
    let max_price = maxPrice; 
	const slider = document.getElementById('slider-range');
	const typeInputs = document.querySelectorAll('input[name="type"]');
	const brandInputs = document.querySelectorAll('input[name="brand"]');
	const categoryInputs = document.querySelectorAll('input[name="category"]');
	for (const categoryInput of categoryInputs) {
	  	categoryInput.addEventListener('click', function(event) {
			updateList();
			let clear = document.getElementById('clearCategories');
			if(!clear.classList.contains('show')){
				clear.classList.add('show');
			}
		});
	}
	document.getElementById('filterProducts').addEventListener('click',()=>{ 
		setLimpiarFiltros();
		document.getElementById('filterContainer').removeAttribute('open');
		updateList();
 	});
	document.getElementById('clearCategories').addEventListener('click',()=>{
		document.getElementById('filterContainer').removeAttribute('open');
		setClear();
		updateList();
	});

	window.onload = function() {
  		const page = document.getElementById('page').value;
  		const id = document.getElementById('id').value;
  		switch(page){
  			case 'category':
  				let id_category = 'c-option-'+id;
  				document.getElementById(id_category).checked = true;
  				setLimpiarFiltros();
  				updateList();
  			break;
  			case 'tag':
  				updateListByTag(id);
  			break;
  		}
  	};

  	setLimpiarFiltros = () =>{
  		let clear = document.getElementById('clearCategories');
		if(!clear.classList.contains('show')){
			clear.classList.add('show');
		}
  	}

	setClear = () =>{
		for (const categoryInput of categoryInputs) {categoryInput.checked = false;}
		for (const typeInput of typeInputs) {typeInputs.checked = false;}
		for (const brandInput of brandInputs) {brandInput.checked = false;}
		slider.noUiSlider.reset();
		max_price = maxPrice;
		document.getElementById('clearCategories').classList.remove('show');
		return;
    }

    updateList = () =>{
    	openModal();
        const formData = new FormData();
        let category = document.querySelector('input[name="category"]:checked');
        (category) ? formData.append('category',category.value) :  formData.append('category','');
        let brand = document.querySelector('input[name="brand"]:checked');
        (brand) ? formData.append('brand', brand.value) : formData.append('brand', '');
        let type = document.querySelector('input[name="type"]:checked');
        (type) ? formData.append('type', type.value) : formData.append('type', '');
		formData.append('min_price', min_price);
		formData.append('max_price', max_price);

        const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				//console.log(this.response);
				myObj = JSON.parse(this.response);
				setTimeout(function(){closeModal();}, 2000);
				if(!myObj.return){
				}else{
					//setClear();
					let data = myObj.return;
	                id_product_2_filter = [];
	                for (let key in data) {
	                    id_product_2_filter.push(data[key]);
	               	}
                    if(id_product_2_filter.length === 0){
                        var apendhtml = "<p>No encontramos resultados con tu busqueda</p>";
                    }
	                userList.filter(function(item) {
	                    algo = id_product_2_filter.indexOf(item.values().id_product)
	                    return algo>=0 ? true : false;
	                });
	                document.getElementById('totalProductosInput').value = userList.matchingItems.length
				}
			}
		}
		xhr.open('POST', '../include/STORE-filterProducts.php', true);
		xhr.send(formData);      
    }
    updateListByTag = (id) =>{
    	openModal();
    	document.getElementById('topProductsContainer').style.display = 'none';
        const formData = new FormData();
		formData.append('id_tag', id);

        const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.response);
				myObj = JSON.parse(this.response);
				setTimeout(function(){closeModal();}, 2000);
				if(!myObj.return){
				}else{
					setClear();
					let data = myObj.return;
	                id_product_2_filter = [];
	                for (let key in data) {
	                    id_product_2_filter.push(data[key]);
	               	}
                    if(id_product_2_filter.length === 0){
                        var apendhtml = "<p>No encontramos resultados con tu busqueda</p>";
                    }
	                userList.filter(function(item) {
	                    algo = id_product_2_filter.indexOf(item.values().id_product)
	                    return algo>=0 ? true : false;
	                });
	                document.getElementById('totalProductosInput').value = userList.matchingItems.length
				}
			}
		}
		xhr.open('POST', '../include/STORE-filterProductsByTag.php', true);
		xhr.send(formData);      
    }

    sortList = (value) =>{
    	switch(value){
            case '1':userList.sort('id_product', { order: "desc" });break;
            case '2':userList.sort('price', { order: "asc" });break;
            case '3':userList.sort('price', { order: "desc" });break;
        }
    }
    document.getElementById('sortList').addEventListener('change',function(){sortList(this.value);});	


	noUiSlider.create(slider, {
	    start: [0, maxPrice],
	    tooltips: [true, true],
	    connect: true,
	    step: 1,
	    range: {
	        'min': 0,
	        'max': maxPrice
	    }
	});
	slider.noUiSlider.on('change', function (values, handle, unencoded, isTap, positions) {min_price = values[0];max_price = values[1];});