	const typePaymentBoxs = document.querySelectorAll('.typePaymentBox');
	const typePayments = document.querySelectorAll('input[name="typePayment"]');
	for(let typePayment of typePayments){
		typePayment.addEventListener('change',function(){
			for(let typePaymentBox of typePaymentBoxs){
				typePaymentBox.classList.remove('active');
			}
			let id_active = `box-${this.getAttribute('id')}`;
			document.getElementById(id_active).classList.add('active');
		});
	}