	const typePaymentBoxs = document.querySelectorAll('.box');
	const typePayments = document.querySelectorAll('input[name="mycheckbox"]');
	for(let typePayment of typePayments){
		typePayment.addEventListener('change',function(){
			for(let typePaymentBox of typePaymentBoxs){
				typePaymentBox.classList.remove('active');
			}
			let id_active = `caja_${this.getAttribute('id')}`;
			document.getElementById(id_active).classList.add('active');
		});
	}