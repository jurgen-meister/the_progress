//$(document).ready(function(){ // with this doesn't work
//START SCRIPT	
	//***************************************************************************//
	//************************START - BITTION ALERT MODAL************************//
	//***************************************************************************//
	//alert('cargo');
	var html ='';
	function showBittionAlertModal(arg){
		if(arg === undefined){
			//alert('No hay objeto definido');
			//return false;
			var arg = {
			title:'Mensaje',
			content: '¿Esta seguro?',
			btnYes:'Si',
			btnNo:'No',
			btnOptional:''
			};
		}else{
			if(arg.title === undefined){
				arg.title ='Mensaje';
			}
			if(arg.content === undefined){
				arg.content ='¿Esta seguro?';
			}
			if(arg.btnYes === undefined){
				arg.btnYes ='Si';
			}
			if(arg.btnNo === undefined){
				arg.btnNo ='No';
			}
			if(arg.btnOptional === undefined){
				arg.btnOptional ='';
			}
		}

		$('#content').append(createAlertModal(arg));
		if($('#bittionBtnNo').length > 0){
			$('#bittionBtnNo').bind("click",function(){ 
						hideBittionAlertModal();
			});
		}
		$('#bittionAlertModal').modal({
					show: 'true',
					backdrop:'static'
		});
		
		
	}
	
	function hideBittionAlertModal(){
		$('#bittionAlertModal').modal('hide');
		$('#bittionAlertModal').remove();
	}
	
	
	function createAlertModal(arg){
		html = '<div id="bittionAlertModal" class="modal hide">';
		html += createHeader(arg.title);
		html += createBody(arg.content);
		html += createFooter(arg.btnYes, arg.btnNo, arg.btnOptional);
		html += '</div>';
		return html;
	}

	function createHeader(title){
		html =  '<div class="modal-header">';
		//html += '<button data-dismiss="modal" class="close" type="button">×</button>'; //not using it 'cause will need to call hideBittionAlertModal()
		html += '<h3>'+title+'</h3>';
		html += '</div>';
		return html;
	}
	function createBody(content){
		html = '<div class="modal-body">';
		html += '<p>'+content+'</p>';
		html += '</div>';
		return html;
	}
	function createFooter(btnYes, btnNo, btnOptional){
		
		if(btnYes === '' && btnNo === '' && btnOptional === ''){
			return '';
		}else{
			html = '<div class="modal-footer">';
			if(btnYes !== ''){
				html += '<a class="btn btn-primary" id="bittionBtnYes" href="#">'+btnYes+'</a>';
			}
			if(btnNo !== ''){
				html += '<a class="btn" id="bittionBtnNo" href="#">'+btnNo+'</a>';
			}
			if(btnOptional !== ''){
				html += '<a class="btn btn-primary" id="bittionBtnOptional" href="#">'+btnOptional+'</a>';
			}
			html +='</div>';
			return html;
		}
		
	}
	//***************************************************************************//
	//************************FINISH - BITTION ALERT MODAL************************//
	//***************************************************************************//


//END SCRIPT
//});
