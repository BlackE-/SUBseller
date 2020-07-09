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
	.modal-content {background-color: #fefefe;  margin: auto; border: 1px solid #fdfdfd;align-items:center;text-align:center;border-radius:20px;width: 70%;max-width:360px;position: relative;overflow: hidden;padding:20px;transform-origin: 50% 0;}

	.modal-header{height: 30px;border-bottom:1px solid #2361f0; position: relative;text-align: right;}
	.modal-body{height: auto;padding:20px 0;}
	.closeModal:hover,.closeModal:focus {cursor: pointer;}

	.lds-spinner {display: inline-block;position: relative;width: 80px;height: 80px;}
	.lds-spinner div {transform-origin: 40px 40px;animation: lds-spinner 800ms linear infinite;}
	.lds-spinner div:after {content: " ";display: block;position: absolute;width: 5px;border-radius: 20%;background: #2361f0;
	}
.lds-spinner div:nth-child(even):after {left: 37px;top: 3px;height:18px;}
.lds-spinner div:nth-child(odd):after {left:37px;top: 0px;height:25px;}
.lds-spinner div:nth-child(1) {transform: rotate(0deg);animation-delay: -700ms;}
.lds-spinner div:nth-child(2) {transform: rotate(45deg);animation-delay: -600ms;}
.lds-spinner div:nth-child(3) {transform: rotate(90deg);animation-delay: -500ms;}
.lds-spinner div:nth-child(4) {transform: rotate(135deg);animation-delay: -400ms;}
.lds-spinner div:nth-child(5) {transform: rotate(180deg);animation-delay: -300ms;}
.lds-spinner div:nth-child(6) {transform: rotate(225deg);animation-delay: -200ms;}
.lds-spinner div:nth-child(7) {transform: rotate(270deg);animation-delay: -100ms;}
.lds-spinner div:nth-child(8) {transform: rotate(315deg);animation-delay: 0s;}
.lds-spinner div:nth-child(9) {transform: translate(-4.5px,33px);animation-duration: 3s;}
.lds-spinner div:nth-child(9):after{content:'';width: 15px;height: 15px;border-radius: 15px;background: #12f9e7;}
@keyframes lds-spinner {
	0% {opacity: 1;}
  100% {opacity: 0;}
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
			<div class="lds-spinner">
				<div></div>
				<div></div>
				<div></div>
				<div></div>
				<div></div>
				<div></div>
				<div></div>
				<div></div>
				<div></div>
			</div>
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