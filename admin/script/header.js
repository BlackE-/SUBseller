	const newURL = window.location.protocol + "/" + window.location.host + "/" + window.location.pathname + window.location.search;
	// console.log(newURL);
	const urlArray = newURL.split('/');
	const urlActive = urlArray[urlArray.length-1];
	const liActive = '#sidebar ul #nav_'+urlActive;
	document.querySelector(liActive).classList.add('active');