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

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                modal.style.display = "none";
                myObj = JSON.parse(this.response);
                if(myObj.return){
                    document.getElementById("error").innerHTML = myObj.message;

                    document.getElementById('form1').classList.add('noShow');
                     document.getElementById('divToLogin').classList.remove('noShow');
                     document.getElementById('divToLogin').classList.add('show');
                     
                }else{
                    document.getElementById("error").innerHTML = this.responseText;
                }
                
            }
        };
        
        xhttp.open("POST", "include/REGISTER-user.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`email=${email_element.value}&password=${pass_element.value}`);
        
        
    }

    document.querySelector('#registerContainer').addEventListener('submit',formSubmit);

// $(document).ready(function(){
    
// 	$.fn.extend({ 
//         addTemporaryClass: function(className, duration) {
//             var elements = this;
//             setTimeout(function() {
//                 elements.removeClass(className);
//             }, duration);

//             return this.each(function() {
//                 $(this).addClass(className);
//             });
//         }
//     });
	
// 	function checkPassword(str){
//         var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/;
//         return re.test(str);
//     }
    
//     function checkForm(){
//         $(".error p").remove();
// 		var fd = new FormData();
// 		var email = $("input[name='email']").val();
// 		if(email.length === 0){
// 			$("input[name='email']").addTemporaryClass("animated swing", 1000);
// 			return false;
// 		}
		
// 		var pass = $("input[name='pass1']").val();
// 		if(pass.length === 0){
// 		    $("input[name='pass1']").addTemporaryClass("animated swing", 1000);
// 			return false;
// 		}
		
// 		fd.append( 'email', email );
// 		fd.append( 'password', pass );
// 		fd.append( 'tipo', 1 );
// 		return fd;
// 	}
	
// 	$(".loginForm").on("submit",function(e){
// 	    e.preventDefault();
// 	    var datos = checkForm();
// 		if(typeof(datos) === 'object'){
//     	    $.ajax({
//                 type: 'POST',
//                 dataType: "json",
//                 url  : 'include/REGISTER-usuariogeneral.php',
//                 data: datos,
// 				processData: false,
//         		contentType: false,
//                 beforeSend:function(){
//                     $(".error p").remove();
//                 },
//                 success : function(data) {
//                     if(data.return !== true){
//                         var apendhtml = "<p>"+data.message+"</p>";
//                         $(".error").append(apendhtml);
//                         $(".error").show().delay(5000).fadeOut();
//                     }
//                     else{
                        
//                         var htmlAppend = "";
//                         htmlAppend += '<label class="type5">Hemos guardado tus datos</label>';
//                         htmlAppend += '<label class="type5">Comienza a usar tu tienda</label>';
//                         htmlAppend += '<a href="index.php"><i class="fa fa-play-circle"></i></a>';
                        
//                         newDiv = $(document.createElement('div')); 
//                         newDiv.html(htmlAppend);
//                         newDiv.dialog({
//                               width: 350,
//                               modal: true,
//                               position: {
//                                     my: "center",
//                                     at: "center",
//                                     of: window,
//                                     collision: 'fit'
//                               },
//                               close: function() {
//                                 //newDiv.allFields.removeClass( "ui-state-error" );
//                                 window.location.href="login.php";
//                               }
                            
//                         });
                        
                        
//                     }
//                 },
//                 error: function (jqXHR, exception) {
//                     var msg = '';
//                     if (jqXHR.status === 0) {
//                         msg = 'Not connect.\n Verify Network.';
//                     } else if (jqXHR.status == 404) {
//                         msg = 'Requested page not found. [404]';
//                     } else if (jqXHR.status == 500) {
//                         msg = 'Internal Server Error [500].';
//                     } else if (exception === 'parsererror') {
//                         msg = 'Requested JSON parse failed.';
//                     } else if (exception === 'timeout') {
//                         msg = 'Time out error.';
//                     } else if (exception === 'abort') {
//                         msg = 'Ajax request aborted.';
//                     } else {
//                         msg = 'Uncaught Error.\n' + jqXHR.responseText;
//                     }
//                     console.log(msg);
//                 }
//             });
// 		}
// 	});
	    
// });