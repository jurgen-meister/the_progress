$(document).ready(function(){
//START SCRIPT

$.validator.addMethod('diNumberUnique', function(value,element){
	if($('#txtDiNumberHidden').length > 0){
		if($('#txtDiNumberHidden').val() === value){
			return true;
		}
	}
	var response;
	$.ajax({
		type:"POST",
		url:urlModuleController + "ajax_verify_unique_di_number",
		async:false,//the key for jquery.validation plugin, if it's true it finishes the function rigth there and it doesn't work
		data:{
			diNumber:value
		  },
		success: function(data){			
			response = data;
		},
		error:function(data){
			alert('ocurrio un problema al validar el Documento de Identidad, vuelva a llenarlo');
			$('#txtDiNumber').val('');
		}
	});
	if (response === '0'){
		return true;
	}else{
		return false;
	}
}, 'El documento de identidad ya existe');


 //$('input[type=checkbox],input[type=radio],input[type=file]').uniform(); // to verify if complete multiple options controls
 //$('select').select2(); // to create advanced select or combobox


// Form Validation Add
    $("#AdmUserFormAdd").validate({
		onkeyup:false,
		submitHandler: function(form) {
            //Replace form submit for:
				ajax_add_user_profile();
        },
		rules:{
			txtFirstName:{
				required:true
			},
			txtLastName1:{
				required:true
			},
			txtLastName2:{
				required:true
			},
			cbxActive:{
				required:true
				//,date:true
			},
			txtActiveDate:{
				required:true
				//,date:true
			},
			txtEmail:{
				required:true,
				email: true
			},
			txtJob:{
				required:true
			},
			txtBirthdate:{
				required:true
				//,date: true
			},
			txtDiNumber:{
				digits:true,
				required:true,
				diNumberUnique:true
			},
			txtBirthplace:{
				required:true
			},
			txtDiPlace:{
				required:true
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

// Form Validation Edit
    $("#AdmUserFormEdit").validate({
		onkeyup:false,
		submitHandler: function(form) {
            //Replace form submit for:
				ajax_edit_user_profile();
        },
		rules:{
			txtFirstName:{
				required:true
			},
			txtLastName1:{
				required:true
			},
			txtLastName2:{
				required:true
			},
			cbxActive:{
				required:true
				//,date:true
			},
			txtActiveDate:{
				required:true
				//,date:true
			},
			txtEmail:{
				required:true,
				email: true
			},
			txtJob:{
				required:true
			},
			txtBirthdate:{
				required:true
				//,date: true
			},
			txtDiNumber:{
				digits:true,
				required:true,
				diNumberUnique:true
			},
			txtBirthplace:{
				required:true
			},
			txtDiPlace:{
				required:true
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


// Form Validation Add UserRestriction
    $("#AdmUserRestrictionFormAdd").validate({
		onkeyup:false,
		submitHandler: function(form) {
            //Replace form submit for:
				ajax_add_user_restrictions();
        },
		rules:{
			cbxActive:{
				required:true
				//,date:true
			},
			txtActiveDate:{
				required:true
				//,date:true
			},
			cbxRoles:{
				required:true
				//,date:true
			},
			cbxPeriods:{
				required:true
				//,date:true
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


// Form Validation Edit UserRestriction
    $("#AdmUserRestrictionFormEdit").validate({
		onkeyup:false,
		submitHandler: function(form) {
            //Replace form submit for:
				//ajax_add_user_restrictions();
				ajax_edit_user_restrictions();
        },
		rules:{
			cbxActive:{
				required:true
				//,date:true
			},
			txtActiveDate:{
				required:true
				//,date:true
			},
			cbxRoles:{
				required:true
				//,date:true
			},
			cbxPeriods:{
				required:true
				//,date:true
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



	function ajax_add_user_profile(){
		$.ajax({
			type:"POST",
			async:false, // the key to open new windows when success
			url:urlModuleController + "ajax_add_user_profile",
			data:{
					txtDiNumber:$('#txtDiNumber').val()
					,txtDiPlace:$('#txtDiPlace').val()
				    ,txtFirstName:$('#txtFirstName').val()
					,txtLastName1:$('#txtLastName1').val()
					,txtLastName2:$('#txtLastName2').val()
					,cbxActive:$('#cbxActive').val()
					,txtActiveDate:$('#txtActiveDate').val()
					,txtEmail:$('#txtEmail').val()
					,txtJob:$('#txtJob').val()
					,txtBirthdate:$('#txtBirthdate').val()
					,txtBirthplace:$('#txtBirthplace').val()
					,txtAddress:$('#txtAddress').val()
					,txtPhone:$('#txtPhone').val()
			  },
			 // beforeSend:function(data){alert('sdhfjdshk')},
			success: function(data){			
				if(data === 'success'){
					$.gritter.add({
						title:	'EXITO!',
						text: 'Usuario creado',
						sticky: false,
						image:urlImg+'check.png'
					});	
						$('input').val('');
						$('#txtBirthplace').val('Bolivia');
						open_in_new_tab(urlModuleController+'view_user_created.pdf');
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
   
   
   function ajax_edit_user_profile(){
		$.ajax({
			type:"POST",
			async:false, // the key to open new windows when success
			url:urlModuleController + "ajax_edit_user_profile",
			data:{
					idUser:$('#txtIdHidden').val()
					,txtDiNumber:$('#txtDiNumber').val()
					,txtDiPlace:$('#txtDiPlace').val()
				    ,txtFirstName:$('#txtFirstName').val()
					,txtLastName1:$('#txtLastName1').val()
					,txtLastName2:$('#txtLastName2').val()
					,cbxActive:$('#cbxActive').val()
					,txtActiveDate:$('#txtActiveDate').val()
					,txtEmail:$('#txtEmail').val()
					,txtJob:$('#txtJob').val()
					,txtBirthdate:$('#txtBirthdate').val()
					,txtBirthplace:$('#txtBirthplace').val()
					,txtAddress:$('#txtAddress').val()
					,txtPhone:$('#txtPhone').val()
			  },
			 // beforeSend:function(data){alert('sdhfjdshk')},
			success: function(data){
				if(data === 'success'){
					$.gritter.add({
						title:	'EXITO!',
						text: 'Cambios guardados',
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
   
   function ajax_reset_password(){
	   $.ajax({
			type:"POST",
			async:false, // the key to open new windows when success
			url:urlModuleController + "ajax_reset_password",
			data:{
					idUser:$('#txtIdHidden').val()
			  },
			success: function(data){
				if(data === 'success'){
					$.gritter.add({
						title:	'EXITO!',
						text: 'Contraseña reseteada',
						sticky: false,
						image:urlImg+'check.png'
					});	
					open_in_new_tab(urlModuleController+'view_user_created.pdf');
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
   
   function ajax_add_user_restrictions(){
	   $.ajax({
			type:"POST",
			//async:false, // the key to open new windows when success
			url:urlModuleController + "ajax_add_user_restrictions",
			data:{
					 period:$('#cbxPeriods').val()
					,areaId:$('#cbxAreas').val()
					,roleId:$('#cbxRoles').val()
					,userId:$('#txtUserIdHidden').val()
					,active:$('#cbxActive').val()
					,activeDate:$('#txtActiveDate').val()
					,selected:$('#cbxSelected').val()
			  },
			success: function(data){			
				var arrayCatch = data.split('|');
					if(arrayCatch[0] === 'success'){
						$.gritter.add({
						title:	'EXITO!',
						text: 'Rol adicionado al Usuario',
						sticky: false,
						image:urlImg+'check.png'
					});	
					
					$('#cbxRoles option[value='+arrayCatch[1]+']').remove();
					$('#cbxRoles').select2();
					$('input[type=text]').val('');
					
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
   
   function ajax_edit_user_restrictions(){
	   $.ajax({
			type:"POST",
			//async:false, // the key to open new windows when success
			url:urlModuleController + "ajax_edit_user_restrictions",
			data:{
					 areaId:$('#cbxAreas').val()
					,userRestrictionId:$('#txtIdUserRestrictionHidden').val()
					,active:$('#cbxActive').val()
					,activeDate:$('#txtActiveDate').val()
				    ,selected:$('#cbxSelected').val()
					,userId:$('#txtUserIdHidden').val()
			  },
			success: function(data){			
					if(data === 'success'){
						$.gritter.add({
						title:	'EXITO!',
						text: 'Cambios Guardados',
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
   
   function ajax_list_roles_areas(){
	    $.ajax({ 
            type:"POST",
            url:urlModuleController + "ajax_list_roles_areas",			
            data:{period: $("#cbxPeriods").val(), userId:$("#txtUserIdHidden").val()},
            //beforeSend: showProcessing,
            success: function(data){
				 $("#boxRolesAreas").html(data);
			},
			error: function(data){
				$.gritter.add({
					title:	'OCURRIO UN PROBLEMA!',
					text:	'Vuelva a intentarlo',
					sticky: false,
					image:urlImg+'error.png'
				});		
			}
        });
   }
   
   $('#cbxPeriods').change(function(){
	  ajax_list_roles_areas();
	  //alert('hola');
   });
   
   function open_in_new_tab(url)
	{
	  var win=window.open(url, '_blank');
	  win.focus();
	}
   
   $('#btnResetPassword').click(function(){
	  //alert('Se cambiara el password esta de acuerdo?'); 
	  ajax_reset_password();
   });
//END SCRIPT	
});
