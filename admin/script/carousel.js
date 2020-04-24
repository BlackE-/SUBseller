	document.querySelector('#carouselSlideForm').addEventListener('submit',(e)=>{
		e.preventDefault();
		const fileInput = document.getElementById('typeProductFile');
		const file = fileInput.files[0];

		const fileInputMobile = document.getElementById('typeProductFileMobile');
		const fileMobile = fileInputMobile.files[0];

		const formData = new FormData();
		formData.append('file', file);
		formData.append('fileMobile', file);
		formData.append('id_carousel', document.querySelector('#id_carousel').value);
		formData.append('url', document.querySelector('#url').value);
		formData.append('number', document.querySelector('#numberSlide').value);
		formData.append('text', document.querySelector('#carousel_slide_text').value);


		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
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
		xhr.open('POST', './include/CAROUSEL-insertSlide.php', true);
		xhr.send(formData);
	});

	const saveSliders = document.querySelectorAll('.saveText');
	for (const saveSlider of saveSliders) {
	  	saveSlider.addEventListener('click', function(event) {
			let id_carousel_slider = this.getAttribute('id').split('_');
			let id = id_carousel_slider[1];
			let text_id = '#carousel_text_'+id;
			let url_id = '#carousel_url_'+id;
    		const xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
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
			xhr.open('POST', './include/CAROUSEL-updateSlide.php', true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send(`id_carousel_slide=${id}&url=${document.querySelector(url_id).value}&text=${document.querySelector(text_id).value}`);
    		
		});
	}

	const deleteSliders = document.querySelectorAll('.delete');
	for (const deleteSlider of deleteSliders) {
	  	deleteSlider.addEventListener('click', function(event) {
			let id_carousel_slider = this.getAttribute('id').split('_');
			let id = id_carousel_slider[1];
    		const xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
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
			xhr.open('POST', './include/CAROUSEL-deleteSlide.php', true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send(`id_carousel_slide=${id}&id_carousel=${document.querySelector('#id_carousel').value}`);
    		
		});
	}

	const fileChanges = document.querySelectorAll('.changeFotocarousel');
	for (const fileChange of fileChanges) {
	  	fileChange.addEventListener('change', function(event) {
	  		event.preventDefault();

			const file = this.files[0];
			const id_media = this.getAttribute("id").split("_");; //category_file_
			const formData = new FormData();
			formData.append('file', file);
			formData.append('id_media', id_media[1]);
			formData.append('type', this.getAttribute('name'));

	
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
			xhr.open('POST', './include/CAROUSEL-updateCarouselPhoto.php', true);
			xhr.send(formData);
		});
	}

$(document).ready(function(){
	//SORTABLE CHANGE
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
    
    
    $( "#sortable" ).on( "sortstop", function( event, ui ) {
        var lista = [];
        var cont = 1;
        $(".slide").each(function(){
            var index = $(this).attr("id");
            lista.push([index,cont]);
            cont++;
        });
        const formData = new FormData();
		formData.append('lista', JSON.stringify(lista));

        const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
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
		xhr.open('POST', './include/CAROUSEL-updateSlidesNumber.php', true);
		xhr.send(formData);      
    } );
});