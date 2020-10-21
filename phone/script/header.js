//menu
    const menuIcon = document.getElementById('menuIcon');
    const menu = document.getElementById('menu');
    menuIcon.addEventListener('click',()=>{
        if(menuIcon.classList.contains('open')){closeMenu();}else{openMenu();}
    });

    openMenu = () =>{
        menuIcon.classList.add('open');
        menu.classList.remove('close');
        menu.classList.add('open');
    }
    closeMenu = () =>{
        menuIcon.classList.remove('open');
        menu.classList.remove('open');
        menu.classList.add('close');
    }

    //search
    const searchIcon = document.getElementById('searchIcon');
    const search = document.getElementById('search');
    searchIcon.addEventListener('click',()=>{
        if(searchIcon.classList.contains('open')){closeSearch();}else{openSearch();}
    });

    openSearch = ()=>{
        searchIcon.classList.add('open');
        search.classList.remove('close');
        search.classList.add('open');
    }
    closeSearch = () =>{
        searchIcon.classList.remove('open');
        search.classList.remove('open');
        search.classList.add('close');
    }

    const selector = new Selectr('#productDrop', {
            searchable: true,
            defaultSelected:false,
            placeholder:"Buscar"
    });
    selector.on('selectr.select', function(option) {
        window.location.href = option.value;
    });