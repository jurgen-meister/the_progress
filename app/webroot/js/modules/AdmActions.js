$(document).ready(function(){
//START SCRIPT

	//Initialize dropdown lists to position 0 for firefox refresh bug
    $('#modules option:nth-child(1)').attr("selected", "selected");
    $('#controllers option:nth-child(1)').attr("selected", "selected");
	$('#actions option:nth-child(1)').attr("selected", "selected");
	
	   //Initialize AJAX
    $('#modules').change(function(){
        ajax_list_controllers();
		$("#message").hide();
    });

    $('#controllers').change(function(){
		//alert($('#controllers').val());
        ajax_list_actions();
		//$("#message").hide();
    });
	
	function ajax_list_controllers(){
        $.ajax({
            type:"POST",
            url:urlModuleController + "ajax_list_controllers",
            data:{module: $('#modules').val()},
            beforeSend: showProcessing,
            success:function(data){
				showControllers(data);
				$('#controllers').bind("change",function(){
					ajax_list_actions();
				});
			}
        });
    }

    function ajax_list_actions(){
        $.ajax({
            type:"POST",
            url:urlModuleController + "ajax_list_actions",			
            data:{controllerId: $("#controllers").val(), controllerName: $("#controllers option:selected").text()},
            beforeSend: showProcessing,
            success: function(data){
				showActions(data);
			}
				
        });
    }
	
	function showProcessing(){
        $("#processing").text("Procesando...");
    }
    function showControllers(data){
        $("#processing").text("");
        $("#boxControllers").html(data);
		fnBittionSetSelectsStyle();
    }
    function showActions(data){
        $("#processing").text("");
        $("#boxActions").html(data);
		fnBittionSetSelectsStyle();
    }
	
});