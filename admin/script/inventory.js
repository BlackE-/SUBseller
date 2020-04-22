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

    const inputsQty = document.querySelectorAll('.inputQty');
    for (const inputQty of inputsQty) {
        inputQty.addEventListener('focus', function(event) {
            let id_ = this.getAttribute("id");
            document.querySelector('#inventario_'+id_+' i').style.display = 'inline-block';
            document.querySelector('#inventario_'+id_+' input').style.display = 'inline-block';
            document.querySelector('#updateQry_'+id_+' input[type="submit"]').disabled = false;
        });
        inputQty.addEventListener('blur', function(event) {
            let id_ = this.getAttribute("id");
            document.querySelector('#inventario_'+id_+' i').style.display = 'none';
            document.querySelector('#inventario_'+id_+' input').style.display = 'none';
            setTimeout(function(){
                document.querySelector('#updateQry_'+id_+' input[type="submit"]').disabled = true;
            },1000);
            
        });
        inputQty.addEventListener('change', function(event) {
            let id_ = this.getAttribute("id");
            document.querySelector('#qty_update_'+id_).value = this.value;
        });
    }

    const formsUpdate = document.querySelectorAll('.formUpdateQty');
    for (const formUpdate of formsUpdate) {
        formUpdate.addEventListener('submit', function(event) {
            event.preventDefault();
            let id_ = this.getAttribute("id");
            let id = id_.split('_');
            console.log(id[1]);

            let stock = this.children[0].value;

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // console.log(this.response);
                    myObj = JSON.parse(this.response);
                    if(myObj.return){
                        location.reload();
                    }else{
                        console.log(myObj.message);
                    }
                }
            }
            xmlhttp.open("POST", "./include/INVENTORY-updateInventory.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send(`id_product=${id[1]}&stock=${stock}`);

        });
    }



$(document).ready(function(){
    $('#example').DataTable( {
        dom: 'Bfrtip',
        "info": false
    } );
    
});