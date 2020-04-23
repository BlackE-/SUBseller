$(document).ready(function(){
    let table = $('#example').DataTable({
         dom: 'Bfrtip',
        "info": false
    });
    $('#example-select-all').on('change', function(){
        var rows = table.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    document.querySelector('#newCouponForm').addEventListener('submit',function(e){
        e.preventDefault();
        openModalFunction();
        const code = document.querySelector('#code');
        if(code.value.length === 0){
            errorMessage("Falta Código");
            addTemporaryClass(code ,'animated', 1000);
            addTemporaryClass(code ,'swing', 1000);
            return false;
        }
        const description = document.querySelector('#description');
        const date_expires = document.querySelector('#date_expires');
        if(date_expires.value.length === 0){
            errorMessage("Falta tiempo de uso");
            addTemporaryClass(date_expires ,'animated', 1000);
            addTemporaryClass(date_expires ,'swing', 1000);
            return false;
        }

        const amount = document.querySelector('#amount');
        if(amount.value.length === 0){
            errorMessage("Falta Valor");
            addTemporaryClass(amount ,'animated', 1000);
            addTemporaryClass(amount ,'swing', 1000);
            return false;
        }
        

        let typeSelect = document.querySelector('input[name="type"]:checked').value;
        if(typeSelect === 'null'){
            errorMessage("Falta tipo");
            return false;
        }
        let appliesTo = 0;
        if(typeSelect !== 'free_shipping'){
            appliesTo = document.querySelector('input[name="appliesTo"]:checked');
            if(appliesTo == null){
                errorMessage("Falta a que aplica el Cupon");
                return false;
            }
            appliesTo = appliesTo.value;
        }
        let type;
        switch(typeSelect){
            case 'fixed':
                type = (appliesTo === 'total') ? 'fixed' : 'fixed_products';
            break;
            case 'percetage':
                type = (appliesTo === 'total') ? 'percetage' : 'percetage_products';
            break;
            case 'free_shipping':
                type = 'free_shipping';
            break;
        }
        let product_ids;
        switch(type){
            case 'fixed_products': case 'percetage_products':
                product_ids = [];
                table.$('input[type="checkbox"]').each(function(){
                    if(this.checked){ product_ids.push($(this).attr("id")); }
                });
                if(product_ids.length <= 0){
                    errorMessage('Elegir al menos un producto');
                    return false;
                }
            break;
        }

        

        let formData = new FormData();
        formData.append('code', code.value);
        formData.append('description', description.value);
        formData.append('date_expires', date_expires.value);
        formData.append('type', type);
        formData.append('amount', amount.value);
        formData.append('product_ids', product_ids);


        list.style.opacity = '0';
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.response);
                myObj = JSON.parse(this.response);
                if(!myObj.return){
                    console.log(myObj.message);
                    errorMessage(myObj.message);
                }else{
                    console.log('Cupon Guardado');
                    list.style.opacity = '1';
                    para.innerText = 'Cupon Guardado';
                    a.style.display = 'block';
                }
            }
        }
        xhttp.open("POST", "./include/COUPON_NEW-insertCoupon.php", true);
        xhttp.send(formData);


    });

});

 const modalBody = document.querySelector('.modal-body');
    const para = document.createElement("P");
    para.setAttribute("id", "modalNote");
    para.innerText = "Faltan datos"; 
    modalBody.appendChild(para);
    const list = document.querySelector(".modal-body p"); 

    const a = document.createElement('a');
    a.href = "discounts";
    a.appendChild(document.createTextNode('Cupones'));
    a.style.display = 'none'; 
    modalBody.appendChild(a);

    const addTemporaryClass = (element, className,duration) =>{
        setTimeout(()=>{
            element.classList.remove(className);
        },duration);
        element.classList.add(className);
    }

    errorMessage = (message) =>{
        para.innerText = message;
        list.style.opacity = '1';
        setTimeout(function(){
            list.style.opacity = '0';
            closeModalFunction();
        },2000);
    }

    const inputsAppliesTo = document.querySelectorAll('input[name="appliesTo"]');
    for (const inputAppliesTo of inputsAppliesTo) {
        inputAppliesTo.addEventListener('change', function(event) {
            switch(this.value){
                case 'products':
                    document.querySelector('#example_wrapper').style.display = 'block';
                    break;
                default:
                    document.querySelector('#example_wrapper').style.display = 'none';
                    break;
            }
        });
    }

    const inputsType = document.querySelectorAll('input[name="type"]');
    for (const inputType of inputsType) {
        inputType.addEventListener('change', function(event) {
            switch(this.value){
                case 'percetage':
                    document.querySelector('.amountLabel').innerHTML = '%';
                    document.querySelector('.amountContainer').style.opacity = '1';
                    break;
                case 'fixed':
                    document.querySelector('.amountLabel').innerHTML = '$';
                    document.querySelector('.amountContainer').style.opacity = '1';
                    break;
                case 'free_shipping':
                    document.querySelector('.amountContainer').style.opacity = '0';
                    document.querySelector('.amountLabel').innerHTML = '';
                break;
            }
        });
    }

    document.querySelector('.codeGenerator').addEventListener('click',function(){
        openModalFunction();
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.response);
                myObj = JSON.parse(this.response);
                if(!myObj.return){
                    console.log(myObj.message);
                    errorMessage(myObj.message);
                }else{
                    document.querySelector('#code').value = myObj.return;
                    closeModalFunction();
                }
            }
        }
        xhttp.open("POST", "./include/COUPON_NEW-getCode.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`name=CODE`);
    });

    