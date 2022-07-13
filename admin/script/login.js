    
    const addTemporaryClass = (element, className,duration) =>{
        setTimeout(()=>{
            element.classList.remove(className);
        },duration);
        element.classList.add(className);
    }
    const checkPassword = (pwd) =>{
        const re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{0,9}$/;
        return re.test(pwd);
    }
    const formSubmit = (event) =>{
        event.preventDefault();
        const email_element = document.querySelector('input[name="email"]');
        if(email_element.value.length === 0){
            addTemporaryClass(email_element ,'animated', 1000);
            addTemporaryClass(email_element ,'swing', 1000);
            return false;
        }
        const pass_element = document.querySelector('input[name="pass"]');
        if(pass_element.value.length === 0){
            addTemporaryClass( pass_element ,'animated', 1000);
            addTemporaryClass( pass_element ,'swing', 1000);
            return false;
        }
        //open modal for loading
        modal.style.display = "block";
        //ajax call
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                modal.style.display = "none";
                console.log(this.response);
                myObj = JSON.parse(this.response);
                console.log(myObj);
                if(myObj.return){
                    document.getElementById("error").innerHTML = myObj.message;
                    window.location.href = 'index';
                }else{
                    document.getElementById("error").innerHTML = myObj.message;
                }
                
            }
        };
        
        xhttp.open("POST", "include/LOGIN-user.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`email=${email_element.value}&password=${pass_element.value}`);
         
    }

    document.querySelector('#loginForm').addEventListener('submit',formSubmit);