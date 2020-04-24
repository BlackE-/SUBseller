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

	// const saveS = document.querySelectorAll('.save');
	// for (const save of saveS) {
	//   	save.addEventListener('click', function(event) {
	// 		let attribute = this.getAttribute("name");
    		
	// 	});
	// }

	document.querySelector('#carouselForm').addEventListener('submit',(e)=>{
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