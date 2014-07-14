$(document).ready(function(){
//START SCRIPT

function ajax_add_period(){
	 $.ajax({ 
            type:"POST",
            url:urlModuleController + "ajax_add_period",			
            data:{period: $("#txtPeriod").val()},
            //beforeSend: showProcessing,
            success: function(data){			
				var arrayCatch = data.split('|');
				if(arrayCatch[0] === 'success'){
					$.gritter.add({
						title:	'EXITO!',
						text: 'Nueva gestión creada',
						sticky: false,
						image:urlImg+'check.png'
					});	
					$('#txtPeriod').val(arrayCatch[1]);
					$('#spaPeriod').text(arrayCatch[1]);
				}else{
					$.gritter.add({
					title:	'OCURRIO UN PROBLEMA!',
					text:	'Vuelva a intentarlo',
					sticky: false,
					image:urlImg+'error.png'
					});		
				}
			},
			error:function(data){
				$.gritter.add({
					title:	'OCURRIO UN PROBLEMA!',
					text:	'Vuelva a intentarlo',
					sticky: false,
					image:urlImg+'error.png'
				});		
			}
        });
}


$('#btnYes').click(function(){
	ajax_add_period();
});

//END SCRIPT	
});

