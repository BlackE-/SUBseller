	window.onload = function() {
  		openModalFunction();
  		const page = document.getElementById('page').value;
  		const id = document.getElementById('id').value;
  		switch(page){
  			case 'category':
  				let id_category = 'c-option-'+id;
  				document.getElementById(id_category).checked = true;
  				updateList();
  			break;
  		}
  		closeModalFunction();
  	};

	var id_productos_a_filtrar = [];
	const options = {valueNames: [ 'id_producto', 'name', 'precio','marca','categoria','tipoProducto' ],page: 9,pagination:{outerWindow :1}};
    const userList = new List('productos', options);
    const maxPrice = parseInt(document.getElementById('maxPriceValue').value,10);
	let min_price = 0;
    let max_price = maxPrice; 
	const slider = document.getElementById('slider-range');
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
	slider.noUiSlider.on('update', function (values, handle, unencoded, isTap, positions) {
    	// console.log(values[handle]);
    	min_price = values[0];
    	max_price = values[1];
	});

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


    function updateList(){
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
				myObj = JSON.parse(this.response);
				setTimeout(function(){
		                 closeModalFunction();
		            }, 2000);
				if(!myObj.return){

				}else{
					console.log(myObj.return);
					let data = myObj.result;
	                id_productos_a_filtrar = [];
	                for (var key in data.error) {
	                      console.log(key, data.error[key]);
	                    id_productos_a_filtrar.push(data.error[key]);
	               	}
	   //                  // if(id_productos_a_filtrar.length == 0){
	   //                  //     var apendhtml = "<p>No encontramos resultados con tu busqueda</p>";
	   //                  //     $("#dialog").append(apendhtml);
	   //                  // }


	                userList.filter(function(item) {
	                    algo = id_productos_a_filtrar.indexOf(item.values().id_producto)
	                    return algo>=0 ? true : false;
	                });
	                document.getElementById('totalProductosInput').value = userList.matchingItems.length
				}
			}
		}
		xhr.open('POST', './include/STORE-filterProducts.php', true);
		xhr.send(formData);      
    }	


	