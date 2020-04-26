	const buttons = document.querySelectorAll('.buttonOption');
	for (const button of buttons) {
	  	button.addEventListener('click', function(event) {
			let attribute = this.getAttribute("name");
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

	const saveS = document.querySelectorAll('.save');
	for (const save of saveS) {
	  	save.addEventListener('click', function(event) {
	  		const id_carousel = this.getAttribute('id').split('_');
			let name = document.getElementById('carousel_'+id_carousel[2]).value;
			let status = (document.getElementById('carousel_id_'+id_carousel[2]).checked) ? 1:0;

			const xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					console.log(this.response);
					myObj = JSON.parse(this.response);
					if(!myObj.return){
						console.log(myObj.message);
					}
				}
			}
			xhr.open('POST', './include/CAROUSEL-updateCarousel.php', true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send(`id_carousel=${id_carousel[2]}&name=${name}&status=${status}`);
		});
	}

	const statusChanges = document.querySelectorAll('.status');
	for (const statusChange of statusChanges) {
	  	statusChange.addEventListener('change', function(event) {
	  		const id_carousel = this.getAttribute('id').split('_');
			let name = document.getElementById('carousel_'+id_carousel[2]).value;
			let status = (this.checked) ? 1: 0;

			const xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					console.log(this.response);
					myObj = JSON.parse(this.response);
					if(!myObj.return){
						console.log(myObj.message);
					}
				}
			}
			xhr.open('POST', './include/CAROUSEL-updateCarousel.php', true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send(`id_carousel=${id_carousel[2]}&name=${name}&status=${status}`);
		});
	}

	document.getElementById('carouselForm').addEventListener('submit',(e)=>{
		e.preventDefault();

		const formData = new FormData();
		formData.append('name', document.querySelector('#carouselNew').value);

		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.response);
				myObj = JSON.parse(this.response);
				if(!myObj.return){
					console.log(myObj.message);
				}else{
					location = 'carousel?id_carousel='+myObj.return;
				}
			}
		}
		xhr.open('POST', './include/CAROUSEL-insertCarousel.php', true);
		xhr.send(formData);
	});


	document.getElementById('htmlForm').addEventListener('submit',(e)=>{
		e.preventDefault();
		openModalFunction();

		const formData = new FormData();
		formData.append('type', document.getElementById('type').value);
		switch(document.getElementById('type').value){
			case '1':
				let fileInput = document.getElementById('file_1');
				const file = fileInput.files[0];
				if(!file){
					closeModalFunction();
					return false;
				}
				formData.append('file', file);
				formData.append('url_page', document.getElementById('url_page_1').value);
				formData.append('text1', document.getElementById('text1_1').value);
				formData.append('text2', document.getElementById('text2_1').value);
				formData.append('textButton', document.getElementById('textButton1').value);
				formData.append('url', document.getElementById('url_1').value);
			break;
		}
		
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
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
		xhr.open('POST', './include/HTML-insertContent.php', true);
		xhr.send(formData);

	})