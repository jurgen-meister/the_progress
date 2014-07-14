$(document).ready(function(){
//START SCRIPT

// Form Validation Change Password
    $("#AdmUserFormPassword").validate({
		onkeyup:false,
		submitHandler: function(form) {
            //Replace form submit for:
			ajax_change_password();
        },
		rules:{
			txtPassword1:{
				required: true,
				minlength:5,
				maxlength:15
			},
			txtPassword2:{
				required:true,
				minlength:5,
				maxlength:15,
				equalTo:"#txtPassword1"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
			$(element).parents('.control-group').removeClass('success');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

// Form Validation Change Email
    $("#AdmUserFormEmail").validate({
		onkeyup:false,
		submitHandler: function(form) {
            //Replace form submit for:
			ajax_change_email();
        },
		rules:{
			txtEmail1:{
				required:true,
				email: true
			},
			txtEmail2:{
				required:true,
				email: true,
				equalTo:"#txtEmail1"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
			$(element).parents('.control-group').removeClass('success');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});


	function ajax_change_email(){
	   $.ajax({
			type:"POST",
			url:urlModuleController + "ajax_change_email",
			data:{
					email:$('#txtEmail1').val()
			  },
			success: function(data){
				if(data=='success'){
					$.gritter.add({
						title:	'EXITO!',
						text: 'Correo electrónico cambiado',
						sticky: false,
						image:urlImg+'check.png'
					});	
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
   
   function ajax_change_password(){
	   $.ajax({
			type:"POST",
			url:urlModuleController + "ajax_change_password",
			data:{
					password:$('#txtPassword1').val()
			  },
			success: function(data){
				if(data==='success'){
					$.gritter.add({
						title:	'EXITO!',
						text: 'Contraseña cambiada',
						sticky: false,
						image:urlImg+'check.png'
					});	
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

//END SCRIPT	
});


