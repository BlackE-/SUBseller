	let id_product_2_filter = [];
	const options = {valueNames: [ 'id_product', 'name', 'price','id_brand','category','id_type' ],page: 9,pagination:{outerWindow :1}};
    const userList = new List('products', options);
    const maxPrice = parseInt(document.getElementById('maxPriceValue').value,10);
	let min_price = 0;
    let max_price = maxPrice; 
	const slider = document.getElementById('slider-range');
	const categoryInputs = document.querySelectorAll('input[name="category"]');
	for (const categoryInput of categoryInputs) {
	  	categoryInput.addEventListener('click', function(event) {
			updateList();
		});
	}

	const typeInputs = document.querySelectorAll('input[name="type"]');
	for (const typeInput of typeInputs) {
	  	typeInput.addEventListener('click', function(event) {
			updateList();
		});
	}

	const brandInputs = document.querySelectorAll('input[name="brand"]');
	for (const brandInput of brandInputs) {
	  	brandInput.addEventListener('click', function(event) {
			updateList();
		});
	}

	document.getElementById('clearCategories').addEventListener('click',()=>{
		for (const categoryInput of categoryInputs) {
			categoryInput.checked = false;
		}
		updateList();
	});
	document.getElementById('clearBrands').addEventListener('click',()=>{
		for (const brandInput of brandInputs) {
			brandInput.checked = false;
		}
		updateList();
	});
	document.getElementById('clearTypes').addEventListener('click',()=>{
		for (const typeInput of typeInputs) {
			typeInput.checked = false;
		}
		updateList();
	});
	
	window.onload = function() {
  		const page = document.getElementById('page').value;
  		const id = document.getElementById('id').value;
  		switch(page){
  			case 'category':
  				let id_category = 'c-option-'+id;
  				document.getElementById(id_category).checked = true;
  				updateList();
  			break;
  			case 'tag':
  				// let id_category = 'c-option-'+id;
  				// document.getElementById(id_category).checked = true;
  				updateListByTag(id);
  			break;
  		}
  	};

	setClear = () =>{
		let category = document.querySelector('input[name="category"]:checked');
        (category) ?  document.getElementById('clearCategories').classList.add('show') : document.getElementById('clearCategories').classList.remove('show');
        let brand = document.querySelector('input[name="brand"]:checked');
        (brand) ? document.getElementById('clearBrands').classList.add('show') : document.getElementById('clearBrands').classList.remove('show');
        let type = document.querySelector('input[name="type"]:checked');
        (type) ? document.getElementById('clearTypes').classList.add('show') : document.getElementById('clearTypes').classList.remove('show');
	}

	addAnimation = () =>{
		for(let x of userList.matchingItems){
        	x.elm.classList.remove('zoomOut');
        	x.elm.classList.add('animated');
        	x.elm.classList.add('zoomIn');
        }
	}

	removeAnimation = () =>{
		for(let x of userList.matchingItems){
        	x.elm.classList.remove('zoomIn');
        	x.elm.classList.remove('animated');
        }
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
				// console.log(this.response);
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
	                addAnimation();
	                console.log(userList.matchingItems);
	                document.getElementById('totalProductosInput').value = userList.matchingItems.length
				}
			}
		}
		xhr.open('POST', './include/STORE-filterProducts.php', true);
		xhr.send(formData);      
    }
    updateListByTag = (id) =>{
    	openModal();
    	document.getElementById('filtersContainer').style.display = 'none';
    	document.getElementById('storeContainer').classList.add('tagFilter');
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
		xhr.open('POST', './include/STORE-filterProductsByTag.php', true);
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
	slider.noUiSlider.on('change', function (values, handle, unencoded, isTap, positions) {
    	// console.log(values[handle]);
    	min_price = values[0];
    	max_price = values[1];
    	console.log('updateSlider');
    	updateList();
	});


	