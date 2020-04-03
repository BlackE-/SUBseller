    const addTemporaryClass = (element, className,duration) =>{
        setTimeout(()=>{
            element.classList.remove(className);
        },duration);
        element.classList.add(className);
    }
    

    const formSubmit = (event) =>{
        event.preventDefault();
        const host = document.querySelector('input[name="host"]');

        if(host.value.length === 0){
            addTemporaryClass(host ,'animated', 1000);
            addTemporaryClass(host ,'swing', 1000);
            return false;
        }

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

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.response);
                    myObj = JSON.parse(this.response);
                    console.log(myObj);
                    if(myObj.return){
                        window.location.href = "config.php";
                    }
                }
            }
            xmlhttp.open("POST", "http://localhost/subseller/admin/include/INIT-subseller.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send(`host=${host.value}&database=${database.value}&username=${username.value}&password=${pass_element.value}`);
    }

    document.querySelector('#registerContainer').addEventListener('submit',formSubmit);