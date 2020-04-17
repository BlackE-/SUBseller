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
			let brand = document.querySelector('#brandNewName').value;
			if(brand.length <= 0){
				return false;
			}

			let xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					console.log(this.response);
					myObj = JSON.parse(this.response);
					console.log(myObj);
					if(myObj.return){
						location.reload();
					}else{
						console.log(myObj.message);
					}
				}
			}
			xmlhttp.open("POST", "./include/STORE-insertBrand.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send(`brand=${brand}`);
		});

			//updateStatusMarca
			const statusMarcas = document.querySelectorAll('.status');
			for (const statusSlides of statusMarcas) {
			  	statusSlides.addEventListener('change', function(event) {

					let id_ = this.getAttribute("id").split("_");
					let id_brand = id_[2];
					let brand_name = document.querySelector('#brand_'+id_brand).value;

					let brand_status = 1;
       				if (!this.checked){brand_status=0;}


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
       				if (!this.checked){brand_status=0;}
       				console.log(id_brand);

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
					xmlhttp.open("POST", "./include/STORE-updateBrand.php", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send(`id_brand=${id_brand}&brand_name=${brand_name}&brand_status=${brand_status}`);

				});
			}


		//categorias





		//tipo producto