


	if("IntersectionObserver" in window){	
		let observerIMG = new IntersectionObserver((entries, observer) => { 
			entries.forEach(entry => {
				if(entry.isIntersecting){
					let src = entry.target.getAttribute('data-src');
					if (!src) { return; }
  					entry.target.src = src;
					// entry.target.classList.add('animated');
					// entry.target.classList.add('zoomIn');
				}
		  	});
		}, {threshold:1});
		// document.querySelectorAll('.slideImg').forEach( p => { observerIMG.observe(p) });
		// document.querySelectorAll('.slideImgMobile').forEach( p => { observerIMG.observe(p) });
		document.querySelectorAll('.bestSellersImg').forEach( p => { observerIMG.observe(p) });

	}
	else{
		console.log("no intersectionobserver");
	}

	

		new Glide('#glideCarousel',{
			type: 'slide',
			// autoplay: 2000,
  			hoverpause: true,
		}).mount();

		const glideBestSellers = document.getElementById('glideBestSellers');
		if(glideBestSellers !== 'undefined'){
			new Glide('#glideBestSellers',{
				type: 'slide',
				breakpoints:{
					// 640:{perView: 1},
					990: {	perView: 2},
			  		2000: { perView: 3}
				}
			}).mount();
		}

		const glideBrands = document.getElementById('glideBrands');
		if(glideBrands !== 'undefined'){
			new Glide('#glideBrands',{
				type: 'carousel',
				breakpoints:{
					440:{perView: 1},
					640:{perView: 2},
					990: {	perView: 4},
			  		2000: { perView: 6}
				}
			}).mount();
		}
