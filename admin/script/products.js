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

    document.querySelector('#import').addEventListener('change',function(){
        openModalFunction();
        const file = this.files[0];
        if(!file){errorMessage('Falta archivo');return false;}
        let formData = new FormData();
        formData.append('file', file);
        console.log(formData);

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.response);
                myObj = JSON.parse(this.response);
                if(!myObj.return){
                    console.log(myObj.message);
                    para.innerText = myObj.message;
                }else{
                    console.log('producto Guardado');
                    list.style.opacity = '1';
                    para.innerText = 'Producto Guardado';
                    location.reload();
                }
            }
        }
        xhttp.open("POST", "./include/PRODUCTS-importProducts.php", true);
        // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(formData);
    });

    const statusProducts = document.querySelectorAll('.status');
    for (const statusProduct of statusProducts) {
        statusProduct.addEventListener('change', function(event) {
            let id_ = this.getAttribute("id");
            let status = 1;
            if (!this.checked){status=0;}
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // console.log(this.response);
                    myObj = JSON.parse(this.response);
                    if(myObj.return){
                        // location.reload();
                    }else{
                        console.log(myObj.message);
                    }
                }
            }
            xmlhttp.open("POST", "./include/PRODUCTS-setStatus.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send(`id=${id_}&status=${status}`);

        });
    }
    const favProducts = document.querySelectorAll('.fav');
    for (const favProduct of favProducts) {
        favProduct.addEventListener('change', function(event) {

            let id_ = this.getAttribute("id").split("_");
            let id_fav = id_[1];
            let fav_status = 1;
            if (!this.checked){fav_status=0;}


            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // console.log(this.response);
                    myObj = JSON.parse(this.response);
                    if(myObj.return){
                        // location.reload();
                    }else{
                        console.log(myObj.message);
                    }
                }
            }
            xmlhttp.open("POST", "./include/PRODUCTS-setFav.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send(`id=${id_fav}&fav=${fav_status}`);

        });
    }



$(document).ready(function(){
    $('#example').DataTable( {
        dom: 'Bfrtip',
        "info": false,
        //"pageLength": 50,
        buttons: [
            { extend: 'pdf', text:'PDF <i class="fas fa-download"></i>',className: 'btn-pdf' },
            { extend: 'excel', text: 'EXCEL <i class="fas fa-download"></i>',className: 'btn-excel' }
            //'excel'
            // 'excelHtml5','pdfHtml5'
        ]
    } );
    
});