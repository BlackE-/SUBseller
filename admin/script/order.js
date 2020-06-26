	let status = document.getElementById('status');
	let error = document.getElementById('error');
	const id_order = document.getElementById('id_order').value;
	const updateStatus = document.getElementById('updateStatus');
	updateStatus.addEventListener('click',function(){
		let status_ = status.value;
		const formData = new FormData();
        formData.append('id_order', id_order);
		formData.append('status', status_);
		//open modal for loading
        modal.style.display = "block";
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				modal.style.display = "none";
				console.log(this.response);
				myObj = JSON.parse(this.response);
				if(myObj.return){
					location.reload();
				}else{
					error.innerHTML = 'No se pudo actualizar';
				}
			}
		}
		xhr.open('POST', './include/ORDER-updateStatus.php', true);
		xhr.send(formData);

	});