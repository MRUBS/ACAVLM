<script type="text/javascript">
//['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'] 
$(function(){ 
  $("#list").jqGrid({
    url:'<?php echo (site_url("grid/fund_types")); ?>',
	editurl: '<?php echo (site_url("grid/fund_types")); ?>',
    datatype: 'xml',
    mtype: 'POST',
    colNames:['Type', 'Description', 'Values'],
    colModel :[ 
	  {name:'type', index:'type', width:60, editable:true, edittype:"select", editoptions:{value:"T:T;C:C"}, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'description', index:'description', width:60, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'values', index:'values', width:50, editable:false, sortable:false, search:false} 
    ],
    pager: '#pager',
    rowNum:100,
	height:300,
    rowList:[100,200,500],
    sortname: 'type',
    sortorder: 'asc',
    viewrecords: true,
	autowidth: true,
	scrolling:true,
	//altRows:true,
    caption: 'Codes'
  }); 
  $("#list").jqGrid(
  	'navGrid',
	'#pager',
	{edit:true,add:true,del:true,search:true},//Options
	{afterSubmit:processAddEdit, reloadAfterSubmit:true, closeAfterEdit:true},//Edit Options
	{afterSubmit:processAddEdit, reloadAfterSubmit:true, closeAfterAdd:true},//Add Options
	{reloadAfterSubmit:true}//Delete Options
  ); 
  //Colorbox
 // $(".framepop").colorbox({});
}); 
//Check for errors
function processAddEdit(response, postdata) {
  var success = true;
  var message = "";
  var respxml = response.responseText;
  if(respxml.indexOf("<error>") > 0){
	  success = false;
	  var str1 = respxml.split("<error>");
	  var str2 = str1[1].split("</error>");
	  message = str2[0];
  }
  var new_id = "1";
  return [success,message,new_id];
}
</script>
<h1>Edit Fund Types</h1>
<table id="list"></table> 
<div id="pager"></div>
