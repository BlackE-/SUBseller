    const modalBody = document.querySelector('.modal-body');
    const para = document.createElement("P");
    para.setAttribute("id", "modalNote");
    para.innerText = ""; 
    modalBody.appendChild(para);
    const list = document.querySelector(".modal-body p"); 

    errorMessage = (message) =>{
        para.innerText = message;
        list.style.opacity = '1';
        setTimeout(function(){
            list.style.opacity = '0';
            closeModalFunction();
        },2000);
    }

    const selectAll = document.getElementById('example-select-all');
    const allCheckboxes = document.querySelectorAll('.checkboxProduct');
    selectAll.addEventListener('change',function(event){
        if (!this.checked){for(checkBox of allCheckboxes){checkBox.checked = false;}}
        else{for(checkBox of allCheckboxes){checkBox.checked = true;}}
    });

    const applyDisc = document.getElementById('applyDisc');
    let discValue = document.getElementById('descuentoText');
    applyDisc.addEventListener('click',function(){
        openModalFunction();
        if(discValue.value == ''){
            errorMessage('Campo vacio');
            return false;
        }
        let productSelectedValues = [];
        let productSelected = document.querySelectorAll('.checkboxProduct:checked');
        if(productSelected.length == 0){
            errorMessage('Elegir al menos un producto');
            return false;
        }
        else{
            for(product of productSelected){
                productSelectedValues.push(product.getAttribute('id'));
            }
        }
        let discount = discValue.value
        if(discount != 0){
            discount = (100 - discValue.value)/100;
        } 
        let formData = new FormData();
        formData.append('discount', discount);
        formData.append('products', productSelectedValues);

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.response);
                myObj = JSON.parse(this.response);
                if(!myObj.return){
                    console.log(myObj);
                    errorMessage(myObj.message);
                }else{
                    errorMessage('Actualizado');
                    setTimeout(function(){location.reload()},1000);
                }
            }
        }
        xhttp.open("POST", "./include/PRODUCTSDISCOUNTS-setDiscount.php", true);
        xhttp.send(formData);

    });




$(document).ready(function(){
    $('#example').DataTable( {
        dom: 'Bfrtip',
        "info": false
    } );
    
});