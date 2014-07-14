$(document).ready(function(){
//START SCRIPT

//ON START
	//EXECUTE onload
	//ajax_get_graphics_data();
	if(urlAction === 'vgraphics' || urlAction === 'vgraphics#'){
		startDataTable();
	}
	$('#txtReportStartDate, #txtReportFinishDate').keydown(function(e){e.preventDefault();});
	
/////////////
	
	$('#cbxReportGroupTypes').change(function(){
		getGroupItemsAndFilters();
	});
	
	function getGroupItemsAndFilters(){
		ajax_get_group_items_and_filters();
	}
	
	$('#btnGenerateGraphicsMovements').click(function(){
		var items = getSelectedCheckboxes();
		if(items.length > 0){
			ajax_get_graphics_data(items);	
			$('#boxMessage').html('');
		}else{
			$('#boxMessage').html('<div class="alert-error"><ul>'+'<li> Debe elegir al menos un "Item" </li>'+'</ul></div>');
		}
		
	});
	
	function getSelectedCheckboxes(){
	   var selected = new Array();
	   $(".data-table tbody input:checkbox:checked").each(function() {
			selected.push($(this).val());
	   });
	   return selected;
   }
	
	$('#btnGenerateGraphicsHistoricalPrices').click(function(){
		
		var items = $('#cbxItems').val(); //getSelectedCheckboxes();
		var startDate = $('#txtReportStartDate').val();
		var finishDate = $('#txtReportFinishDate').val();
		//alert(startDate);
		//alert(finishDate);
		var error = validate(startDate, finishDate, items);
		if(error === ''){
			ajax_get_graphics_data_historical_prices(startDate, finishDate, items);
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
	   //if(items.length === 0){error+='<li> Debe elegir al menos un "Item" </li>';}
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
	
	function startDataTable(){
	   $('.data-table').dataTable({
			"bJQueryUI": true,
			//"sPaginationType": "full_numbers",
			"sDom": '<"">t<"F"f>i',
			"sScrollY": "240px",
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
function ajax_get_group_items_and_filters(){ //Report
	$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_get_group_items_and_filters",			
            data:{type: $('#cbxReportGroupTypes').val()},
			beforeSend: function(){
				$('#boxProcessing').text('Procesando...');
			},
            success: function(data){
				$('#boxGroupItemsAndFilters').html(data);
				$('select').select2();
				startDataTable();
				$('#boxGroupItemsAndFilters #cbxReportGroupFilters').bind("change",function(){ 
					var selected = new Array();
					$("#boxGroupItemsAndFilters #cbxReportGroupFilters option:selected").each(function () {
						selected.push($(this).val());
					});
					ajax_get_group_items(selected);
				});
				$('#boxProcessing').text('');
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
	
	
	////////////////////////////////////////////////////////////////////////
	function createPieData(sentData){
		//Format expected from ajax request is label1-data1|label2-data2
		var firstSplitedData = sentData.split("|");
		var secondSplitedData = [];
		var finalData = [];
		var label = "";
		var data = "";

		for(var i=0; i < firstSplitedData.length; i++){
			secondSplitedData = firstSplitedData[i].split("-");
			label = secondSplitedData[0];
			data = parseInt(secondSplitedData[1]);
			finalData[i] = {label:label, data:data};
		}
		return finalData;
	}

	//var series = Math.floor(Math.random()*10)+1;


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

	function createBarData(sentData){
		var splitData = sentData.split("|");
		var data = [];
		var finalData = [];
			for (var i=0; i < splitData.length; i++){
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
	
	function createBarDataFloat(sentData){
		var splitData = sentData.split("|");
		var data = [];
		var finalData = [];
			for (var i=0; i < splitData.length; i++){
				data[i]=[i+1,parseFloat(splitData[i]).toFixed(2)];
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
	
	function createBarOptionsDynamic(stringXaxis){
		
		var arrayAux = [];
		var arrayXaxis = [];
		var ticks = [];
		var key = 0;
		arrayAux = stringXaxis.split("|");
		
		for(var i=0; i<arrayAux.length; i++){
			key = i + 1;
			ticks.push([key,arrayAux[i]]);
		}
		
		
		
		var options =
				{
					legend: true,
					/////////////////////
					 xaxis:{
						 ticks: ticks
					 }
				/////////////////////
				};
		return options;
	}
	/////////////////////////////////////////////////////////

	function ajax_get_graphics_data(items){ 
		//var items = getSelectedCheckboxes();
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_get_graphics_data",			
            data:{year: $('#cbxYear').val(), movementType: $('#cbxMovementType').val(), warehouse:$('#cbxWarehouse').val(), item:items},
			beforeSend: function(){
				$('#boxProcessing').text("Procesando...");
			},
            success: function(data){
				//var arrayData = data.split(",");
				//var pieOptions = createPieOptions();
				var barOptions = createBarOptions();
				
				//Display graph    
				//$.plot($(".pie"), createPieData(arrayData[0]), pieOptions);
				//$.plot($(".pie2"), createPieData(arrayData[1]), pieOptions);
				$.plot($(".bars"), createBarData(data), barOptions);
				//$.plot($(".bars2"), createBarData(arrayData[3]), barOptions);
				
				//hide message
				$('#boxProcessing').text("");
			},
			error:function(data){
				//hideBittionAlertModal();
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#boxProcessing').text("");
			}
        });
	}
	
	
	function ajax_get_graphics_data_historical_prices(startDate, finishDate, items){ 
		//var items = getSelectedCheckboxes();
		$.ajax({
            type:"POST",
            url:urlModuleController + "ajax_get_graphics_data_historical_prices",			
            data:{startDate:startDate, finishDate:finishDate, item:items, currency:$("#cbxReportCurrency").val()},
			beforeSend: function(){
				$('#boxProcessing').text("Procesando...");
			},
            success: function(data){
				var arrayData = data.split(",");
				var barOptions = createBarOptionsDynamic(arrayData[0]);
				$.plot($(".bars"), createBarDataFloat(arrayData[1]), barOptions);
				
				var barOptions = createBarOptionsDynamic(arrayData[2]);
				$.plot($(".bars2"), createBarDataFloat(arrayData[3]), barOptions);
				
				var barOptions = createBarOptionsDynamic(arrayData[4]);
				$.plot($(".bars3"), createBarDataFloat(arrayData[5]), barOptions);
				//Display graph    
				
				//$.plot($(".bars2"), createBarData(arrayData[1]), barOptions);
				//$.plot($(".bars3"), createBarData(arrayData[2]), barOptions);
				
				//hide message
				$('#boxProcessing').text("");
			},
			error:function(data){
				//hideBittionAlertModal();
				showGrowlMessage('error', 'Vuelva a intentarlo.');
				$('#boxProcessing').text("");
			}
        });
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
	
	//EXECUTE onload
	//ajax_get_graphics_data();
	//$('#cbxItem').select2();
	
	//events
	/*
	$('#cbxWarehouse, #cbxItem, #cbxYear').change(function(){
		ajax_get_graphics_data();
	});
	*/
	////////////////////////////////////////////////////////
//	var data = createPieData("Compras-175|Traspasos-25|Aperturas-25|Otros-25");
//	var options = createPieOptions();
//	
//	
//	//Display graph    
//	$.plot($(".pie"), data, options);
//	$.plot($(".pie2"), data, options);
//	////////////////////////////////////////////////////////
//
//
//	data = createBarData("62867|0|0|0|0|0|0|0|8769|0|0|0");
//	options = createBarOptions();
//
//	//Display graph
//	$.plot($(".bars"), data, options);
//	$.plot($(".bars2"), data, options);
	
	
//END SCRIPT	
});
		