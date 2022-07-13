	const selector = new Selectr('#productDrop', {
		    searchable: true,
		    defaultSelected:false,
		    placeholder:"Buscar condición visual o producto"
	});
	selector.on('selectr.select', function(option) {
		window.location.href = option.value;
		// console.log(option.value);
	});