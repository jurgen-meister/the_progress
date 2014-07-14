/* 
 * Bittion Software
 */

jQuery(document).ready(function() {
//START SCRIPT

//********************************MAIN ONLOAD - START***************************//
/////////////////////MAIN EXEC
    var requestType = jQuery("#spanHiddenRequestType").text();
    var groupId = 0;
    var groupType = "";
    setBoxTableTitleOnLoad();
//    generateGraphicsGroups();
/////////////////////EVENTS
    jQuery("#cbxLocation").change(function() {
        ajaxGenerateWarehousesByLocation();
    });

    jQuery("#btnGenerateGraphicsGroups").click(function(event) {
        generateGraphicsGroups();
        event.preventDefault();
    });

    jQuery("#accordionGraphics").click(function(event) {
        if (jQuery("#GraphicsDataTable").length === 0) {//if table does not exist
            showBittionAlertModal({btnNo: "Aceptar", btnYes: "", content: "Primero debe \"Generar Grafica\" "});
            return false;// preventDefault doesn't work in this case
        }
    });

//    jQuery(".collapse").collapse({  //will avoid togle on tabs accordion
//        toggle: false
//    });

//********************************MAIN - END***************************//

//////////////////FUNCTIONS

    //************Main functions
    function generateGraphicsGroups() {
        groupId = getGroupId();
        groupType = getGroupType(groupId);
        setBoxTableTitle();
        var monthSelected = getSelected("#InvMovementGraphicsMovementsProductsForm #cbxMonth option:selected");

        var selectedGroupsIds = 0;
        if (jQuery("#spanHiddenLastSelectedGroup").text() === jQuery("#cbxGroup").val()) { //groups validation 
            selectedGroupsIds = getSelected("#GraphicsDataTable tbody input:checkbox:checked");
            if (selectedGroupsIds.length === 0) {
                selectedGroupsIds = 0;
            }
        }
        if (groupId > 0) {//products validation
            selectedGroupsIds = getSelected("#GraphicsDataTable tbody input:checkbox:checked");
            if (selectedGroupsIds.length === 0) {
                selectedGroupsIds = 0;
            }
        }
        var validation = validate({month: monthSelected, group: selectedGroupsIds});
        if (validation === "") {
            ajaxGetGraphicsMovementsProducts(monthSelected, selectedGroupsIds);
            jQuery("#boxMessage").html('');
        } else {
            jQuery("#boxMessage").html('<ul>' + validation + '</ul>');
        }
    }


    //*********AJAX
    function ajaxGenerateWarehousesByLocation() {
        jQuery.ajax({
            type: "POST",
            url: urlModuleController + "ajax_generate_warehouses_by_location",
            dataType: "json", //The key
            data: {location: jQuery("#cbxLocation").val()},
            beforeSend: function() {
                jQuery("#boxProcessing").text("Procesando...");
            },
            success: function(data) {
                var locations = data;//json
                jQuery("#cbxWarehouse option").remove();
//                if ((typeof locations[1] !== "undefined")) { //array"s index is 1 because DB table Id always starts in 1
                jQuery.each(locations, function(i, val) {
                    jQuery('#cbxWarehouse').append('<option value="' + i + '">' + val + '</option>');
                });
//                }
                jQuery("#cbxWarehouse").select2();
                jQuery("#boxProcessing").text("");
            },
            error: function(xhr, textStatus, error) {
                jQuery.gritter.add({title: 'ERROR!', text: 'Al obtener la información.', sticky: false, image: urlImg + 'error.png'});
                jQuery("#boxProcessing").text("");
            }
        });
    }


    function ajaxGetGraphicsMovementsProducts(monthSelected, selectedIds) {
        jQuery.ajax({
            type: "POST",
            url: urlModuleController + "ajax_get_graphics_movements_products",
            dataType: "json", //The key
            data: {
                year: jQuery("#cbxYear").val()
//                , month: jQuery("#cbxMonth").val()
                , month: monthSelected
                , movementType: jQuery("#cbxMovementType").val()
                , location: jQuery("#cbxLocation").val()
                , warehouse: jQuery("#cbxWarehouse").val()
                , group: groupType
                , selectedIds: selectedIds
                , groupId: groupId
            },
            beforeSend: function() {
                jQuery("#boxProcessing").text("Procesando...");
            },
            success: function(data) {
//                //Open Pie tab only the first time - Bug not showing Pie plot om 1080p resolution
//                if (jQuery("#GraphicsDataTable").length === 0) {//if table does not exist
////                jQuery("#collapsePie").collapse("show"); //doesn't work toogle
//                    jQuery("#collapsePie").collapse({"toggle": true, 'parent': '#accordionGraphics'}); //toogle works, the key for toogle is propertie "parent"
//                }
                //Pie
                var plotPie = creatPieChart(data["Pie"]);
                //Bars
                createStackedBarsChart(data["LinesBars"]);
                //Lines
                createLineChart(data["LinesBars"]);
                //Get Plot Colors
                var plotColors = getPlotColors(plotPie);
                //Datatable
                createDataTable(data["DataTable"], plotColors, groupId);
                //Set Last Selected Group
                jQuery("#spanHiddenLastSelectedGroup").text(data["LastSelectedGroup"]);

                //hide message
                jQuery("#boxProcessing").text("");
            },
            error: function(xhr, textStatus, error) {
                jQuery.gritter.add({title: 'ERROR!', text: 'Al obtener la información.', sticky: false, image: urlImg + 'error.png'});
                jQuery("#boxProcessing").text("");
            }
        });
    }
    //*********DATATABLE
    //1.- Create Data Table
    function createDataTable(data, plotColors, groupId) {

//        formatDataForDataTable(data, plotColors);
        var tbodyContent = fillTableTbody(data, plotColors);
        var columnLinkTitle = "Grupo";
        if (groupId > 0) {
            columnLinkTitle = "Producto";
        }
        jQuery('#boxDataTable').html('<table id="GraphicsDataTable" class="table table-bordered table-hover" style="border-bottom: 1px solid #ddd;"><thead></thead><tbody>' + tbodyContent + '</tbody></table>');
        jQuery('#GraphicsDataTable').dataTable({
//            "data": data,  //unnecesary, 'cause fill tbody rows with other function
            "aoColumns": [
                {"sWidth": "5%"}
                , {"sWidth": "5%"}
                , {"sTitle": columnLinkTitle}
                , {"sTitle": "Cantidad"}
            ],
            "bJQueryUI": true,
            //"sPaginationType": "full_numbers",
            "sDom": '<"">t<"F"f>i',
            "sScrollY": "450px",
            //"bScrollCollapse": true,
            "bPaginate": false,
            "aaSorting": [], //on start sorting setting to empty
            "oLanguage": {
                "sSearch": "Filtrar:",
                "sZeroRecords": "No se encontro nada.",
                //"sInfo":         "Ids from _START_ to _END_ of _TOTAL_ total" //when pagination exists
                "sInfo": "Encontrados _TOTAL_ Productos",
                "sInfoEmpty": "Encontrados 0 Productos",
                "sInfoFiltered": "(filtrado de _MAX_ Productos)"
            },
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [0]}// do not sort first column
            ]
        });
        jQuery('input[type=checkbox]').uniform();
    }
    //2. Fill Html Table Tbody
    function fillTableTbody(data, plotColors) {
        var html = "";
        for (var i = 0; i < data.length; i++) {
            var checked = "";
            var color = "#282828";//default table color
            html += "<tr>";
            if (data[i]["checked"]) {
                checked = "checked=\"checked\" ";
            }
            html += '<td align="center"><input type="checkbox" ' + checked + ' value="' + data[i]["id"] + '" /></td>';
            if (plotColors[i] !== "undefined") {
                color = plotColors[i];
            }
            html += '<td style="background-color:' + color + '"></td>';
            if (groupId === 0) {
                html += '<td><a href="/imexport/inv_movements/graphics_movements_products/groupName:' + data[i]["label"] + '/groupId:' + data[i]["id"] + '/groupType:' + jQuery("#cbxGroup").val() + '" target="_blank">' + data[i]["label"] + '</a></td>';
            } else {
                html += '<td>' + data[i]["label"] + '</td>';
            }
            html += '<td>' + data[i]["data"] + '</td>';
            html += "</tr>";
        }
        return html;
    }
    //VALIDATIONS
    function validate(fieldsObj) {
        var error = '';
        if (fieldsObj.month.length === 0) {
            error += '<li> El campo "Mes" no puede estar vacio </li>';
        }
        if (jQuery("#GraphicsDataTable").length > 0) {//if table exists
            if (jQuery("#spanHiddenLastSelectedGroup").text() === jQuery("#cbxGroup").val()) {
                if (fieldsObj.group === 0) {
                    error += '<li> Debe elegir al menos un "Grupo" en la tabla "Resumen" </li>';
                }
            }
            if (groupId > 0) {//products validation
                if (fieldsObj.group === 0) {
                    error += '<li> Debe elegir al menos un "Grupo" en la tabla "Resumen" </li>';
                }
            }
        }
//        alert(fieldsObj.group);
        return error;
    }

    //*********GRAPHICS
    //1.LINE CHART
    function createLineChart(data) {

//        var d1 = [[01, 10], [02, 20], [03, 30]];
//        var d2 = [[01, 8], [02, 12], [03, 23]];
//        var d3 = [[01, 24], [02, 14], [03, 25]];
//        var d4 = [[01, 7], [02, 40], [03, 38]];
//        var data = [{data: d1, label: "AFI 212 AFI"},/* {data: d2, label: "C1020"}, {data: d3, label: "C1040"}, {data: d4, label: "TZ203"}*/];

        jQuery.plot(jQuery(".chart"), data, {
            series: {
                lines: {show: true},
                points: {show: true}
            },
            grid: {hoverable: true, clickable: true},
            xaxis: {
                axisLabel: "Meses",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 10,
                ticks: [
                    [1, "Ene"], [2, "Feb"], [3, "Mar"], [4, "Abr"], [5, "May"], [6, "Jun"],
                    [7, "Jul"], [8, "Ago"], [9, "Sep"], [10, "Oct"], [11, "Nov"], [12, "Dic"]
                ]
            },
            yaxis: {
                axisLabel: "Productos",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 3
            },
            legend: {show: false}
        });
        //Exec ToolTip
        createToolTip(".chart", "lines");
    }

    //2.BAR CHART (STACKED)
    function createStackedBarsChart(data) {
//        //Data
//        var d1 = [[1, 10], [2, 20], [3, 30]];
//        var d2 = [[1, 8], [2, 12], [3, 23]];
//        var d3 = [[1, 24], [2, 14], [3, 25]];
//        var d4 = [[1, 7], [2, 40], [3, 38]];
////	var data = [{data:d1, color: "#cb4b4b", label:"T-115"}, {data:d2, color: "rgb(237, 194, 64)", label:"ATF-248 ATF"}, {data:d3, color: "rgb(148, 64, 237)", label:"C1012"}, {data:d4, color: "rgb(152, 199, 255)", label:"C1420"}];
//        var data = [{data: d1, label: "T-115"}, {data: d2, label: "ATF-248 ATF"}, {data: d3, label: "C1012"}, {data: d4, label: "C1420"}];
        //Display Graph		
        var plot = jQuery.plot(jQuery(".bars"), data, {// data, options
            series: {
                stack: true,
                bars: {
                    show: true
                }
            },
            bars: {
//		align:"center",
                barWidth: 0.5,
                order: 1
            },
            legend: {//Para letrero descripcipn de variables
                noColumns: 1,
                labelBoxBorderColor: "#000000",
                position: "nw",
                show: false
            },
            grid: {
                hoverable: true,
                clickable: true,
                borderWidth: 2
//			mouseActiveRadius: 100,
//                backgroundColor: {colors: ["#EDF5FF", "#ffffff"]}
            },
            xaxis: {
                axisLabel: "Meses",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 10,
                ticks: [[1, "Ene"], [2, "Feb"], [3, "Mar"], [4, "Abr"], [5, "May"], [6, "Jun"],
                    [7, "Jul"], [8, "Ago"], [9, "Sep"], [10, "Oct"], [11, "Nov"], [12, "Dic"]
                ]
            },
            yaxis: {
                axisLabel: "Productos",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 3
            }
        });
        //Create Hover ToolTip
        createToolTip(".bars", "stackedBars");
//        getPlotColors(plot);//inside is static array plotColors

    }//End function

    //3.PIE CHART
    function creatPieChart(data) {
//        var data = [{label: "AF2132", data: 50}, {label: "C1012", data: 200}, {label: "C4020", data: 30}, {label: "KI899", data: 90}];
        var plot = jQuery.plot(jQuery(".pie"), data, {
            series: {
                pie: {
                    show: true,
                    radius: 4 / 4,
                    label: {
                        show: true,
                        radius: 3 / 4,
                        formatter: function(label, series) {
//                        return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
//                            return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">' + label + '<br/>' + parseFloat(series.percent).toFixed(2) + '%</div>';
                            return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">' + parseFloat(series.percent).toFixed(2) + '%</div>';
                        },
                        background: {
                            opacity: 0.5,
                            color: '#000'
                        }
                    },
                    innerRadius: 0
                }
            },
            legend: {show: false}
        });
        return plot;
    }

    //4.TOOLTIP
    function createToolTip(identifier, type) {
        var xPrevious = null, yPrevious = null, areaCounter = 0;
        jQuery(identifier).bind("plothover", function(event, pos, item) {
            if (item) {
                var x = item.datapoint[0];	//3	
                var y = item.datapoint[1]; //180
                var areaValue = 0;
                if (x === xPrevious && y === yPrevious) { //the same stack bar
                    if (areaCounter === 0) {//first time hover the stacked bar
                        areaValue = y;
                        if (type === "stackedBars") {
                            areaValue = y - item.datapoint[2];
                        }
//                        createLabelToolTip(item.pageX, item.pageY, item.series.label + "</br> Cantidad: " + stackedBarValue + " | Total: " + y);
                        createLabelToolTip(item.pageX, item.pageY, areaValue);
                    }
                    areaCounter++;
                } else {//Different stack bar
                    areaCounter = 0;
                    jQuery("#tooltip").remove();
                }
                xPrevious = item.datapoint[0];
                yPrevious = item.datapoint[1];

            } else {
                if (areaCounter > 0) {
                    jQuery("#tooltip").remove();
                }
                areaCounter = 0;
            }
        });
    }//End functions

    //5.TOOLTIP LABEL
    function createLabelToolTip(x, y, contents) {
        jQuery('<div id="tooltip">' + contents + '</div>').css({
            position: 'absolute',
            top: y - 30,
            left: x - 40
        }).appendTo("body").fadeIn(200);
    }

    //6.GET PLOT COLORS
    function getPlotColors(plot) {
        var series = plot.getData(),
                plotColors = [];
        for (var i = 0; i < series.length; ++i) {
            plotColors[i] = series[i].color;
        }
        return plotColors;
    }

    //***********OTHER FUNCTIONS
    function getSelected(identificator) {
        var selected = [];
        jQuery(identificator).each(function() {
            selected.push(jQuery(this).val());
        });
        return selected;
    }

    function getUrlVariable(variable)
    {
        var query = urlPathName; //urlPathName comes from BittionMain.js
        var vars = query.split("/");
        for (var i = 0; i < vars.length; i++) {
            var vars2 = vars[i].split(":");
            if (vars2[0] === variable) {
                return vars2[1];
            }
        }
        return("");
    }

    //*********************
    function getGroupId() {
        if (requestType === "") {//http request
            var urlGroupId = getUrlVariable("groupId");
            if (urlGroupId !== "") {
                return urlGroupId;
            }
            return 0;
        } else if (requestType === "ajax") {
            return jQuery("#spanHiddenGroupId").text();
        }
    }

    function getGroupType() {
        if (requestType === "") {//http request
            if (groupId > 0) {
                return getUrlVariable("groupType");
            }
            return jQuery("#cbxGroup").val();
        } else if (requestType === "ajax") {
            return jQuery("#spanHiddenGroupType").text();
        }
    }

    function setBoxTableTitle() {
        var titlePart1 = "";
        var titlePart2 = "";
        var urlGroupName = "";
        if (groupId > 0) {
            titlePart1 = "Categoria: ";
            if (groupType === "brand") {
                titlePart1 = "Marca: ";
            }
        }
        ///////
        if (requestType === "") {//http request
            urlGroupName = decodeURIComponent(getUrlVariable("groupName"));
            if (urlGroupName !== "") {
                titlePart2 = urlGroupName;
                jQuery("#spanBoxGraphics").text(titlePart1 + titlePart2);
            }
        } else if (requestType === "ajax") {
            titlePart2 = jQuery("#spanHiddenGroupName").text();
            jQuery("#spanBoxGraphics").text(titlePart1 + titlePart2);
        }
    }

    function setBoxTableTitleOnLoad() {
        var titlePart1 = "";
        var titlePart2 = "";
        var urlGroupName = "";

        ///////
        if (requestType === "") {//http request
            urlGroupName = decodeURIComponent(getUrlVariable("groupName"));
            if (urlGroupName !== "") {
                titlePart1 = "Categoria: ";
                if (getUrlVariable("groupType") === "brand") {
                    titlePart1 = "Marca: ";
                }
                ///////////////
                titlePart2 = urlGroupName;
                jQuery("#spanBoxGraphics").text(titlePart1 + titlePart2);
            }
        } else if (requestType === "ajax") {
            titlePart1 = "Categoria: ";
            if (jQuery("#spanHiddenGroupType").text() === "brand") {
                titlePart1 = "Marca: ";
            }
            ///////////////
            titlePart2 = jQuery("#spanHiddenGroupName").text();
            jQuery("#spanBoxGraphics").text(titlePart1 + titlePart2);
        }
    }
    //**********************

//END SCRIPT	
});

