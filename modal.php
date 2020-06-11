<style type="text/css">
	.modal {position: fixed;z-index: 100;top:-9999px;padding-top: 100px;opacity:0;width: 100%;height: 100%;overflow: auto;background: rgba(0,0,0,0.5);overflow: hidden;}
	.modal.openModal{animation-duration: 300ms;animation-name: smoothOpenModal;opacity: 1;top:0;}
	.modal.closeModal{animation-duration: 300ms;animation-name: smoothCloseModal;opacity: 0;top:-9999px;}
	@keyframes smoothOpenModal {
	  0% { opacity: 0;}
	  50%{opacity: 1;top:-9999px; }
	  100% {top:0;}
	}@keyframes smoothCloseModal {
	  0% { opacity: 1;}
	  50%{ opacity: 0;top:0; }
	  100% {top:-9999px;}
	}
	.modal-content {background-color: #fefefe;  margin: auto; border: 1px solid #fdfdfd;align-items:center;text-align:center;border-radius:20px;width: 70%;position: relative;overflow: hidden;padding:20px;transform-origin: 50% 0;}

	.modal-header{height: 30px;border-bottom:1px solid #2361f0; position: relative;text-align: right;}
	.modal-body{height: auto;padding:20px 0;}
	.closeModal:hover,.closeModal:focus {cursor: pointer;}
	.lds-dual-ring {display: inline-block;width: 50px;height: 50px;margin:0 auto;}
	.lds-dual-ring:after {content: " ";display: block;width: 46px;height: 46px;margin: 1px;border-radius: 50%;border: 5px solid #2361f0;border-color: #2361f0 transparent #2361f0 transparent;animation: lds-dual-ring 1.2s linear infinite;}
	@keyframes lds-dual-ring {
	  0% {transform: rotate(0deg);}
	  100% {transform: rotate(360deg);}
	}
</style>
<div class="modal" id="modal">
	<div class="modal-content">
    	<div class="modal-header">
			<span class="closeModal">
				<svg xmlns="http://www.w3.org/2000/svg" width="16.97" height="17" viewBox="0 0 16.97 17">
				  <path class="cls-1" d="M1174.51,159.4l-12.91-12.954a2.007,2.007,0,1,1,2.83-2.847l12.91,12.954a2.019,2.019,0,0,1,.01,2.85A1.975,1.975,0,0,1,1174.51,159.4Zm-12.87-.011a2.019,2.019,0,0,1-.01-2.85l12.92-12.96a2.012,2.012,0,0,1,2.84,2.852l-12.88,12.931a2.013,2.013,0,0,1-2.87.027h0Z" transform="translate(-1161.03 -143)"/>
				</svg>
			</span>
		</div>
		<div class="modal-body">
			<div class="lds-dual-ring"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	const modal = document.getElementById("modal");
    const span = document.getElementsByClassName("closeModal")[0];
    span.onclick = function() {   closeModal();}
    window.onclick = function(event) {
      if (event.target == modal) {closeModal();}
    }   
    openModal = ()=>{
        modal.classList.remove('closeModal');
        modal.classList.add('openModal');
    }
    closeModal = () =>{
      modal.classList.remove('openModal');
      modal.classList.add('closeModal');
    }
</script>