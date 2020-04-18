

	const brand = new Selectr('#brandSelect');
	const type = new Selectr('#typeSelect');
	const category = new Selectr('#categorySelect', {
		searchable: true,
		multiple: true,
		selectedValue: ["#8e44ad", "#e74c3c"]
	});

	const tags = new Selectr('#taggable',{
		taggable: true,
		tagSeperators: [",", "|"]
	})

	