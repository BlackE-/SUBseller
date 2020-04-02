    const modal = document.getElementById("modal");
    const closeModal = document.getElementsByClassName("closeModal")[0];
    // When the user clicks on <span> (x), close the modal
    closeModal.onclick = function() { modal.style.display = "none";}
    window.onclick = function(event) {
      if (event.target === modal) {
        modal.style.display = "none";
      }
    }

    const addTemporaryClass = (element, className,duration) =>{
        setTimeout(()=>{
            element.classList.remove(className);
        },duration);
        element.classList.add(className);
    }
    

    const formSubmit = (event) =>{
        event.preventDefault();
        const database = document.querySelector('input[name="database"]');

        if(database.value.length === 0){
            addTemporaryClass(database ,'animated', 1000);
            addTemporaryClass(database ,'swing', 1000);
            return false;
        }

        const username = document.querySelector('input[name="username"]');
        // if(!checkPassword(pass_element.value)){
        if(username.value.length === 0){
            addTemporaryClass( username ,'animated', 1000);
            addTemporaryClass( username ,'swing', 1000);
            return false;
        }

        const pass_element = document.querySelector('input[name="pass1"]');
        // if(!checkPassword(pass_element.value)){
        if(pass_element.value.length === 0){
            addTemporaryClass( pass_element ,'animated', 1000);
            addTemporaryClass( pass_element ,'swing', 1000);
            return false;
        }

        //open modal for loading
        modal.style.display = "block";
        //ajax call
            // const inputs = document.querySelectorAll('input[type="text"]');
            // let sendString = '';
            // for (const prop in inputs) {
            //     if(!Object.is(inputs[prop].value,undefined)){
            //         let index = inputs[prop].name;
            //         let value = inputs[prop].value;
            //         sendString += index +  '=' + value + '&';
            //     }
            // }

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.response);
                    myObj = JSON.parse(this.response);
                    console.log(myObj);
                    if(myObj.return){
                        window.location.href = "register.php";
                    }
                }
            }
            xmlhttp.open("POST", "http://localhost/subseller/admin/include/INIT-subseller.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send(`database=${database.value}&username=${username.value}&password=${pass_element.value}`);

            // fetch('http://localhost/subseller/admin/include/INIT-subseller.php', {
            //     method: 'POST',
            //     headers : {
            //         'Content-Type': 'application/json'
            //     },
            //     body:JSON.stringify({database:`${database.value}`, username:`${username.value}`,password:`${pass_element.value}`})
            // })
            // .then((res) => {
            //     console.log("first then");
            //     res.json();
            // })
            // .then((data) =>{  
            //     setTimeout(()=>{
            //         console.log(data);
            //     },10000);
            //     //aqui es donde evaluo si esta bien o no la respuesta
            // })
            // .catch((err)=>{
            //     console.log(err);
            //     //show error in modal or under form
            // })
        
        
    }

    document.querySelector('#registerContainer').addEventListener('submit',formSubmit);