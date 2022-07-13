		// if("IntersectionObserver" in window){	
		// 	let observerIMG = new IntersectionObserver((entries, observer) => { 
		// 		entries.forEach(entry => {
		// 			if(entry.isIntersecting){
		// 				let src = entry.target.getAttribute('data-src');
		// 				if (!src) { return; }
	 //  					entry.target.src = src;
		// 			}
		// 	  	});
		// 	}, {threshold:1});
		// 	document.querySelectorAll('.bestSellersImg').forEach( p => { observerIMG.observe(p) });
		// }
		// else{
		// 	console.log("no intersectionobserver");
		// }
		new Glide('#glideCarousel',{
			type: 'slide',
			autoplay: 2000,
  			hoverpause: true
		}).mount();
		const glideBestSellers = document.getElementById('glideBestSellers');
		if(glideBestSellers !== 'undefined'){
			new Glide('#glideBestSellers',{
				type: 'carousel',
				perView:2
			}).mount();
		}
		const glideBrands = document.getElementById('glideBrands');
		if(glideBrands !== 'undefined'){
			new Glide('#glideBrands',{
				type: 'carousel',
				perView:2
			}).mount();
		}