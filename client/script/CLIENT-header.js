	const newURL = window.location.protocol + "/" + window.location.host + "/" + window.location.pathname + window.location.search;
	const urlArray = newURL.split('/');
	const urlActive = urlArray[urlArray.length-1];
	if(!urlActive.includes('?')){
		const liActive = '#nav_'+urlActive;
		const active = document.querySelector(liActive);
		// console.log(active);
		if(active !== null){
			active.classList.add('active');
		}
	}else{
		let liActive = urlActive.split('?');
		switch(liActive[0]){
			case 'billing': document.getElementById('nav_billings').classList.add('active');break;
			case 'shipping': document.getElementById('nav_shippings').classList.add('active');break;
		}
	}