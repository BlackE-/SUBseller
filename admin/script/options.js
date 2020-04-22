	const buttons = document.querySelectorAll('.buttonOption');
	for (const button of buttons) {
	  	button.addEventListener('click', function(event) {
			let attribute = this.getAttribute("name");
    		// console.log(attribute);

    		let x = document.querySelectorAll(".option");
			for (i = 0; i < x.length; i++) {
			    x[i].classList.remove('active');  
			}
			document.querySelector('.'+attribute).classList.add('active');

			let b = document.querySelectorAll(".buttonOption");
			for (i = 0; i < x.length; i++) {
			    b[i].classList.remove('active');  
			}
			this.classList.add('active')
		});
	}




		//marcas
		document.querySelector('#brandForm').addEventListener('submit',function(event){
			event.preventDefault();
			const fileInput = document.getElementById('brandFile');
			const file = fileInput.files[0];

			const formData = new FormData();
			formData.append('file', file);
			formData.append('name', document.querySelector('#brandNewName').value);

	
			const xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					myObj = JSON.parse(this.response);
					console.log(myObj);
					if(myObj.return){
						location.reload();
					}else{
						console.log(myObj.message);
					}
				}
			}
			xhr.open('POST', './include/STORE-insertBrand.php', true);
			xhr.send(formData);
		});

			//updateStatusMarca
			const statusMarcas = document.querySelectorAll('.status');
			for (const statusMarca of statusMarcas) {
			  	statusMarca.addEventListener('change', function(event) {

					let id_ = this.getAttribute("id").split("_");
					let id_brand = id_[2];
					let brand_name = document.querySelector('#brand_'+id_brand).value;

					let brand_status = 1;
       				if (!this.checked){brand_status=0;}


					let xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							// console.log(this.response);
							myObj = JSON.parse(this.response);
							// console.log(myObj);
							if(myObj.return){
								// location.reload();
							}else{
								console.log(myObj.message);
							}
						}
					}
					xmlhttp.open("POST", "./include/STORE-updateBrand.php", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send(`id_brand=${id_brand}&brand_name=${brand_name}&brand_status=${brand_status}`);

				});
			}

			const updateMarcas = document.querySelectorAll('.save');
			for (const updateMarca of updateMarcas) {
			  	updateMarca.addEventListener('click', function(event) {

					let id_ = this.getAttribute("id").split("_");
					let id_brand = id_[2];
					let brand_name = document.querySelector('#brand_'+id_brand).value;

					let brand_status = 1;
       				const checkboxMarca = document.querySelector('#brand_id_'+id_brand);
       				if (!checkboxMarca.checked){brand_status=0;}
       				// console.log(id_brand);

					let xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							// console.log(this.response);
							myObj = JSON.parse(this.response);
							// console.log(myObj);
							if(myObj.return){
								// location.reload();
							}else{
								console.log(myObj.message);
							}
						}
					}
					xmlhttp.open("POST", "./include/STORE-updateBrand.php", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send(`id_brand=${id_brand}&brand_name=${brand_name}&brand_status=${brand_status}`);

				});
			}

			const updatePhotoBrands = document.querySelectorAll('.changeFotoBrand');
			for(const updatePhotoBrand of updatePhotoBrands){
				updatePhotoBrand.addEventListener('change', function(event) {
					event.preventDefault();

					const file = this.files[0];
					const id_media = this.getAttribute("id").split("_");; //category_file_
					const formData = new FormData();
					formData.append('file', file);
					formData.append('id_media', id_media[2]);
					formData.append('name', this.getAttribute("name"));

			
					const xhr = new XMLHttpRequest();
					xhr.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							myObj = JSON.parse(this.response);
							console.log(myObj);
							if(myObj.return){
								location.reload();
							}else{
								console.log(myObj.message);
							}
						}
					}
					xhr.open('POST', './include/STORE-updateBrandPhoto.php', true);
					xhr.send(formData);
				});
			}



		//categorias
		const categoryForm = document.querySelector('#categoryForm');
		categoryForm.onsubmit = function(event) {
			event.preventDefault();

			const fileInput = document.getElementById('categoryFile');
			const file = fileInput.files[0];

			const formData = new FormData();
			formData.append('file', file);
			formData.append('name', document.querySelector('#categoryNewName').value);

	
			const xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					myObj = JSON.parse(this.response);
					console.log(myObj);
					if(myObj.return){
						location.reload();
					}else{
						console.log(myObj.message);
					}
				}
			}
			xhr.open('POST', './include/STORE-insertCategory.php', true);
			xhr.send(formData);
		}


			//updateStatusCategoria
			const statusCategories = document.querySelectorAll('.statusCategory');
			for (const statusCategory of statusCategories) {
			  	statusCategory.addEventListener('change', function(event) {

					let id_ = this.getAttribute("id").split("_");
					let id_category = id_[2];
					let category_name = document.querySelector('#category_'+id_category).value;

					let category_status = 1;
       				if (!this.checked){category_status=0;}
       				console.log(category_status);
       				console.log(id_category);


					let xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							console.log(this.response);
							myObj = JSON.parse(this.response);
							console.log(myObj);
							if(myObj.return){
								// location.reload();
							}else{
								console.log(myObj.message);
							}
						}
					}
					xmlhttp.open("POST", "./include/STORE-updateCategory.php", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send(`id_category=${id_category}&category_name=${category_name}&category_status=${category_status}`);

				});
			}

			const updateCategories = document.querySelectorAll('.saveCategory');
			for (const updateCategory of updateCategories) {
			  	updateCategory.addEventListener('click', function(event) {

					let id_ = this.getAttribute("id").split("_");
					let id_category = id_[2];
					let category_name = document.querySelector('#category_'+id_category).value;

					let category_status = 1;
       				if (!this.checked){category_status=0;}
       				
					let xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							// console.log(this.response);
							myObj = JSON.parse(this.response);
							console.log(myObj);
							if(myObj.return){
								// location.reload();
							}else{
								console.log(myObj.message);
							}
						}
					}
					xmlhttp.open("POST", "./include/STORE-updateCategory.php", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send(`id_category=${id_category}&category_name=${category_name}&category_status=${category_status}`);

				});
			}


			const updatePhotoCategories = document.querySelectorAll('.changeFotoCategory');
			for(const updatePhotoCategory of updatePhotoCategories){
				updatePhotoCategory.addEventListener('change', function(event) {
					event.preventDefault();

					const file = this.files[0];
					const id_media = this.getAttribute("id").split("_");; //category_file_
					const formData = new FormData();
					formData.append('file', file);
					formData.append('id_media', id_media[2]);
					formData.append('name', this.getAttribute("name"));

			
					const xhr = new XMLHttpRequest();
					xhr.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							myObj = JSON.parse(this.response);
							console.log(myObj);
							if(myObj.return){
								location.reload();
							}else{
								console.log(myObj.message);
							}
						}
					}
					xhr.open('POST', './include/STORE-updateCategoryPhoto.php', true);
					xhr.send(formData);
				});
			}	




		//tipo producto
		document.querySelector("#typeProductForm").addEventListener('submit',function(event){
			event.preventDefault();
			const fileInput = document.getElementById('typeProductFile');
			const file = fileInput.files[0];

			const fileInputMobile = document.getElementById('typeProductFileMobile');
			const fileMobile = fileInputMobile.files[0];

			const formData = new FormData();
			formData.append('file', file);
			formData.append('fileMobile', file);
			formData.append('name', document.querySelector('#typeProductNewName').value);

	
			const xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					myObj = JSON.parse(this.response);
					console.log(myObj);
					if(myObj.return){
						location.reload();
					}else{
						console.log(myObj.message);
					}
				}
			}
			xhr.open('POST', './include/STORE-insertType.php', true);
			xhr.send(formData);
		});

		//updateStatusCategoria
			const statusTypes = document.querySelectorAll('.statusType');
			for (const statusType of statusTypes) {
			  	statusType.addEventListener('change', function(event) {

					let id_ = this.getAttribute("id").split("_");
					let id_type = id_[2];
					let type_name = document.querySelector('#type_'+id_type).value;

					let type_status = 1;
       				if (!this.checked){type_status=0;}
       				console.log(type_status);
       				console.log(id_type);


					let xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							console.log(this.response);
							myObj = JSON.parse(this.response);
							console.log(myObj);
							if(myObj.return){
								// location.reload();
							}else{
								console.log(myObj.message);
							}
						}
					}
					xmlhttp.open("POST", "./include/STORE-updateType.php", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send(`id_type=${id_type}&type_name=${type_name}&type_status=${type_status}`);

				});
			}

			const updateTypes = document.querySelectorAll('.saveType');
			for (const updateType of updateTypes) {
			  	updateType.addEventListener('click', function(event) {

					let id_ = this.getAttribute("id").split("_");
					let id_type = id_[2];
					let type_name = document.querySelector('#type_'+id_type).value;

					let type_status = 1;
       				if (!this.checked){type_status=0;}
       				
					let xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							// console.log(this.response);
							myObj = JSON.parse(this.response);
							console.log(myObj);
							if(myObj.return){
								// location.reload();
							}else{
								console.log(myObj.message);
							}
						}
					}
					xmlhttp.open("POST", "./include/STORE-updateType.php", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send(`id_type=${id_type}&type_name=${type_name}&type_status=${type_status}`);

				});
			}

			const updatePhotoTypes = document.querySelectorAll('.changeFototype');
			for(const updatePhotoType of updatePhotoTypes){
				updatePhotoType.addEventListener('change', function(event) {
					event.preventDefault();

					const file = this.files[0];
					const id_media = this.getAttribute("id").split("_");; //category_file_
					const formData = new FormData();
					formData.append('file', file);
					formData.append('id_media', id_media[2]);
					formData.append('name', this.getAttribute("name"));

					const img_title = this.getAttribute('title');
					if(img_title.includes('mobile')){
						formData.append('type','type_mobile');
					}else{
						formData.append('type','type');
					}

			
					const xhr = new XMLHttpRequest();
					xhr.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							myObj = JSON.parse(this.response);
							console.log(myObj);
							if(myObj.return){
								location.reload();
							}else{
								console.log(myObj.message);
							}
						}
					}
					xhr.open('POST', './include/STORE-updateTypePhoto.php', true);
					xhr.send(formData);
				});
			}	
