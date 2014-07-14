$(document).ready(function(){
//START SCRIPT

//ON START
	//EXECUTE onload
	//ajax_get_graphics_data();
	fnBittionSetSelectsStyle();
	startDataTable();
	
	
$('#txtReportStartDate, #txtReportFinishDate').keydown(function(e){e.preventDefault();});
/////////////////////////////////////////
$('#btnGenerateReportItemsUtilities').click(function(){
		var items = getSelectedCheckboxes();
		var startDate = $('#txtReportStartDate').val();
		var finishDate = $('#txtReportFinishDate').val();
		var error = validate(startDate, finishDate, items);
		if(error === ''){
			ajax_generate_report_items_utilities(items);
			$('#boxMessage').html('');
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+error+'</ul></div>');
		}
	});
	
	function validate(startDate, finishDate, items){
	   var  error='';
	   if(startDate === ''){error+='<li> El campo "Fecha Inicio" esta vacio </li>';}
	   if(finishDate === ''){error+='<li> El campo "Fecha Fin" esta vacio </li>';}
	   startDate = startDate.split("/");
	   finishDate = finishDate.split("/");
	   if(error === ''){
		    if(validateSameYearOnly(startDate[2], finishDate[2]) === 1){
				error+='<li> La "Fecha Inicio" y "Fecha Fin" deben ser del mismo año </li>';
			}else{
				if(validateGreaterThanStartDate(startDate, finishDate) === 1){error+='<li> La "Fecha Inicio" es mayor a la "Fecha Fin" </li>';}
			}
	   }
	   if(items.length === 0){error+='<li> Debe elegir al menos un "Item" </li>';}
	   return error;
   }
	
   function validateGreaterThanStartDate(startDate, finishDate){
		//Don't validate year 'cause is obligatory to be from the same year in other function
	   if(startDate[1] > finishDate[1]){//month
			return 1;//error
		}
		if(startDate[1] === finishDate[1]){//month
			if(startDate[0] > finishDate[0]){//day
				return 1;//error
			}
		}
		return 0;//ok
   }
   
   function validateSameYearOnly(startYear, finishYear){
	   if(startYear !== finishYear){
		   return 1; //error
	   }
	   return 0;//ok
   }
	
	function ajax_generate_report_items_utilities(items){ //Report
		$.ajax({
            type:"POST",
			async:false, // the key to open new windows when success
            url:urlModuleController + "ajax_generate_report_items_utilities",			
            data:{startDate: $('#txtReportStartDate').val(),
				finishDate: $('#txtReportFinishDate').val(),
				currency:$('#cbxReportCurrency').val(),
				items:items,
				customer:$('#cbxCustomer').val(),
				customerName:$('#cbxCustomer option:selected').text(),
				salesman:$('#cbxSalesman').val(),
				salesmanName:$('#cbxSalesman option:selected').text()
			},
			beforeSend: function(){
				$('#boxProcessing').text('Procesando...');
			},
            success: function(data){
				open_in_new_tab(urlModuleController+'vreport_items_utilities');
				$('#boxProcessing').text('');
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#boxProcessing').text('');
			}
        });
	}
///////////////////////////////////////

	function createBarData(sentData){
		var splitData = sentData.split("|");
		var data = [];
		var finalData = [];
			for (var i=0; i < 12; i++){
				data[i]=[i+1,parseInt(splitData[i])];
			}
		finalData.push({
			data:data,
			bars: {
				show: true, 
				barWidth: 0.5, 
				order: 1
			}
		});
		return finalData;
	}
	
	function createPieData(sentData){
		//Format expected from ajax request is label1-data1|label2-data2
		var firstSplitedData = sentData.split("|");
		var secondSplitedData = [];
		var finalData = [];
		var label = "";
		var data = "";

		for(var i=0; i < firstSplitedData.length; i++){
			secondSplitedData = firstSplitedData[i].split("==");
			label = secondSplitedData[0];
			data = parseInt(secondSplitedData[1]);
			finalData[i] = {label:label, data:data};
		}
		return finalData;
	}
	
	function createBarOptions(){
		var options =
				{
					legend: true,
					/////////////////////
					 xaxis:{
							   ticks: [
										[1, "Ene"], [2, "Feb"], [3, "Mar"], [4, "Abr"], [5, "May"], [6, "Jun"],
										[7, "Jul"], [8, "Ago"], [9, "Sep"], [10, "Oct"], [11, "Nov"], [12, "Dic"]
							   ]
						}    
				/////////////////////
				};
		return options;
	}
	
	function createPieOptions(){
		var options =
			{
				series: {
					pie: {
						show: true,
						radius: 3/4,
						label: {
							show: true,
							radius: 3/4,
							formatter: function(label, series){
								return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
							},
							background: {
								opacity: 0.5,
								color: '#000'
							}
						},
						innerRadius: 0.2
					}
				},
					legend: {
						show: false
					}
			};
			return options;
	}
	/////////////////////////////////////////////////////////
/*
	function ajax_get_graphics_data(){ 
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_get_graphics_data",			
            data:{year: $('#cbxYear').val(), currency:$('#cbxCurrency').val() ,item:$('#cbxItem').val()},
			beforeSend: function(){
				$('#processing').text("Procesando...");
			},
            success: function(data){
				//var arrayData = data.split(",");
				var barOptions = createBarOptions();
				
				//Display graph    
				$.plot($(".bars"), createBarData(data), barOptions);
				
				//hide message
				$('#processing').text("");
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#processing').text("");
			}
        });
	}
*/	
	
	function ajax_get_graphics_items_customers(dataSent){ 
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_get_graphics_items_customers",			
            data:dataSent,
			beforeSend: function(){
				$('#boxProcessing').text("Procesando...");
			},
            success: function(data){
				var arrayData = data.split(",");
				var pieOptions = createPieOptions();
				var barOptions = createBarOptions();
				
				//Display graph    
//				$.plot($(".bars"), createBarData(arrayData[0]), barOptions);
//				$.plot($(".bars2"), createBarData(arrayData[1]), barOptions);
				$.plot($(".pie"), createPieData(arrayData[2]), pieOptions);
				$.plot($(".pie2"), createPieData(arrayData[3]), pieOptions);
				
				
				$("#topMoreQuantity").html(createTableTops("Cantidad", arrayData[4]));
				$("#topMoreMoney").html(createTableTops("Dinero", arrayData[5]));
				$("#topLessQuantity").html(createTableTops("Cantidad", arrayData[6]));
				$("#topLessMoney").html(createTableTops("Dinero", arrayData[7]));
				//hide message
				$('#boxProcessing').text("");
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#boxProcessing').text("");
			}
        });
	}
	
	function ajax_get_graphics_items_salesmen(dataSent){ 
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_get_graphics_items_salesmen",			
            data:dataSent,
			beforeSend: function(){
				$('#boxProcessing').text("Procesando...");
			},
            success: function(data){
				var arrayData = data.split(",");
				var pieOptions = createPieOptions();
				var barOptions = createBarOptions();
				
				//Display graph    
				
//				$.plot($(".bars"), createBarData(arrayData[0]), barOptions);
//				$.plot($(".bars2"), createBarData(arrayData[1]), barOptions);
				$.plot($(".pie"), createPieData(arrayData[2]), pieOptions);
				$.plot($(".pie2"), createPieData(arrayData[3]), pieOptions);
				
				
				
				$("#topMoreQuantity").html(createTableTops("Cantidad", arrayData[4]));
				$("#topMoreMoney").html(createTableTops("Dinero", arrayData[5]));
				$("#topLessQuantity").html(createTableTops("Cantidad", arrayData[6]));
				$("#topLessMoney").html(createTableTops("Dinero", arrayData[7]));
				//hide message
				$('#boxProcessing').text("");
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#boxProcessing').text("");
			}
        });
	}
	
	function createTableTops(fieldName, array){
		var counter = 0;
		var html = '';
		if(array.length === 0){
			return false;
		}
		var arrayData = array.split("|");
		var arrayFinal = [];
		
		html += '<table class="table table-striped table-bordered">';
		html += '<tr><th>#</th><th>Item</th><th>'+fieldName+'</th></tr>';
		for(var i = 0; i < arrayData.length; i++){
			html += '<tr>';
				counter = i +1;
				arrayFinal = arrayData[i].split("==");
				html += '<td>'+counter+'</td>';
				html += '<td>'+arrayFinal[0]+'</td>';
				html += '<td>'+arrayFinal[1]+'</td>';
			html += '</tr>';
		}
		html += '</table>';
		return html;
	}

	function showGrowlMessage(type, text, sticky){
		if(typeof(sticky)==='undefined') sticky = false;
		var title;
		var image;
		switch(type){
			case 'ok':
				title = 'EXITO!';
				image= urlImg+'check.png';
				break;
			case 'error':
				title = 'OCURRIO UN PROBLEMA!';
				image= urlImg+'error.png';
				break;
			case 'warning':
				title = 'PRECAUCIÓN!';
				image= urlImg+'warning.png';
				break;
		}
		$.gritter.add({
			title:	title,
			text: text,
			sticky: sticky,
			image: image
		});	
	}
	

	/*
	//events
	$('#cbxItem, #cbxYear, #cbxCurrency').change(function(){
		ajax_get_graphics_data();
	});
	*/
////////////////////////////////////////////////////////////////////////////////

$('#btnGenerateReportCustomers').click(function(){
	var currency = $('#cbxCurrency').val();
	var groupBy = $('#cbxReportGroupTypes').val();
	var year =  $("#cbxYear").val();
	var month =  $("#cbxMonth").val();
	var customer = $("#cbxCustomer").val();
	var showMode = $("#cbxShowMode").val();
	
	var items = getSelectedCheckboxes();
	if(items.length > 0){
		var DATA = {
						currency:currency,
						groupBy:groupBy,
						year:year,
						month:month,
						customer:customer,
						showMode:showMode,
						items:items
					   };
			//ajax_generate_report(DATA);
			//alert(DATA);
			ajax_get_graphics_items_customers(DATA);
			$('#boxMessage').html('');
	}else{
		$('#boxMessage').html('<div class="alert-error"><ul>'+'<li> Debe elegir al menos un "Item" </li>'+'</ul></div>');
	}
	return false;
});


$('#btnGenerateReportPurchasesCustomers').click(function(){
	var currency = $('#cbxCurrency').val();
	var groupBy = $('#cbxReportGroupTypes').val();
	var year =  $("#cbxYear").val();
	var month =  $("#cbxMonth").val();
	var zero =  $("#cbxShowZero").val();
	var customer = $("#cbxCustomer").val();
	var customerName = $("#cbxCustomer option:selected").text();
	var monthName =  $("#cbxMonth option:selected").text();
	var items = getSelectedCheckboxes();
	if(items.length > 0){
		var DATA = {
						currency:currency,
						groupBy:groupBy,
						year:year,
						month:month,
						customer:customer,
						customerName:customerName,
						zero:zero,
						monthName:monthName,
						items:items
					   };
			//alert(DATA);
			ajax_generate_report_purchases_customers(DATA);
			$('#boxMessage').html('');
	}else{
		$('#boxMessage').html('<div class="alert-error"><ul>'+'<li> Debe elegir al menos un "Item" </li>'+'</ul></div>');
	}
	return false;
});

	function ajax_generate_report_purchases_customers(dataSent){ //Report
		$.ajax({
            type:"POST",
			async:false, // the key to open new windows when success
            url:urlModuleController + "ajax_generate_report_purchases_customers",			
            data:dataSent,
			beforeSend: function(){
				$('#boxProcessing').text('Procesando...');
			},
            success: function(data){
				open_in_new_tab(urlModuleController+'vreport_purchases_customers');
				$('#boxProcessing').text('');
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#boxProcessing').text('');
			}
        });
	}


	function open_in_new_tab(url)
	{
	  var win=window.open(url, '_blank');
	  win.focus();
	}

$('#btnGenerateReportSalesmen').click(function(){
	var currency = $('#cbxCurrency').val();
	var groupBy = $('#cbxReportGroupTypes').val();
	var year =  $("#cbxYear").val();
	var month =  $("#cbxMonth").val();
	var salesman = $("#cbxSalesman").val();
	var showMode = $("#cbxShowMode").val();
	
	var items = getSelectedCheckboxes();
	if(items.length > 0){
		var DATA = {
						currency:currency,
						groupBy:groupBy,
						year:year,
						month:month,
						salesman:salesman,
						showMode:showMode,
						items:items
					   };
			ajax_get_graphics_items_salesmen(DATA);
			$('#boxMessage').html('');
	}else{
		$('#boxMessage').html('<div class="alert-error"><ul>'+'<li> Debe elegir al menos un "Item" </li>'+'</ul></div>');
	}
	return false;
});



$('#cbxReportGroupTypes').change(function(){
		getGroupItemsAndFilters();
});

function getGroupItemsAndFilters(){
	ajax_get_group_items_and_filters();
}

function ajax_get_group_items_and_filters(){ //Report
		$.ajax({
            type:"POST",
			//async:false, // the key to open new windows when success
            url:urlModuleController + "ajax_get_group_items_and_filters",			
            data:{type: $('#cbxReportGroupTypes').val()},
			beforeSend: function(){
				$('#boxProcessing').text('Procesando...');
				//alert("mierdaaa");
			},
            success: function(data){
				$('#boxGroupItemsAndFilters').html(data);
				fnBittionSetSelectsStyle();
				startDataTable();
				$('#boxGroupItemsAndFilters #cbxReportGroupFilters').bind("change",function(){ 
					var selected = new Array();
					$("#boxGroupItemsAndFilters #cbxReportGroupFilters option:selected").each(function () {
						selected.push($(this).val());
					});
					ajax_get_group_items(selected);
				});
				$('#boxProcessing').text('');
				//location.href = "startReport";
				//window.scrollTo(0, document.body.scrollHeight);
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#boxProcessing').text('');
			}
        });
	}
	
	function ajax_get_group_items(selected){ //Report
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_get_group_items",			
            data:{type: $('#cbxReportGroupTypes').val(), selected: selected},
			beforeSend: function(){
				$('#boxProcessing').text('Procesando...');
			},
            success: function(data){
				$('#boxGroupItems').html(data);
				startDataTable();
				$('#boxProcessing').text('');
			},
			error:function(data){
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#boxProcessing').text('');
			}
        });
	}
	
	function startDataTable(){
	   $('.data-table').dataTable({
			"bJQueryUI": true,
			//"sPaginationType": "full_numbers",
			"sDom": '<"">t<"F"f>i',
			"sScrollY": "400px",
			//"bScrollCollapse": true,
			"bPaginate": false,
			"aaSorting":[], //on start sorting setting to empty
			"oLanguage": {
				"sSearch": "Filtrar:",
				 "sZeroRecords":  "No se encontro nada.",
				 //"sInfo":         "Ids from _START_ to _END_ of _TOTAL_ total" //when pagination exists
				 "sInfo": "Encontrados _TOTAL_ Productos",
				 "sInfoEmpty": "Encontrados 0 Productos",
				 "sInfoFiltered": "(filtrado de _MAX_ Productos)"
			},
			"aoColumnDefs": [
			  { 'bSortable': false, 'aTargets': [ 0 ] }// do not sort first column
			]
		});
		$('input[type=checkbox]').uniform();
		$("#title-table-checkbox").click(function() {
			var checkedStatus = this.checked;
			var checkbox = $(this).parents('.widget-box').find('tr td:first-child input:checkbox');		
			checkbox.each(function() {
				this.checked = checkedStatus;
				if (checkedStatus === this.checked) {
					$(this).closest('.checker > span').removeClass('checked');
				}
				if (this.checked) {
					$(this).closest('.checker > span').addClass('checked');
				}
			});
		});	
   }
	
	function getSelectedCheckboxes(){
	   var selected = new Array();
	   $(".data-table tbody input:checkbox:checked").each(function() {
			selected.push($(this).val());
	   });
	   return selected;
   }
   
////////////////////////////////////////////////////////////////////////////////////////////
	
//END SCRIPT	
});
		
