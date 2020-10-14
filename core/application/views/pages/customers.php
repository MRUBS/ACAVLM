<script type="text/javascript">
//['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'] 
$(function(){ 
  $("#list").jqGrid({
    url:'<?php echo (site_url("grid/customers")); ?>',
	editurl: '<?php echo (site_url("grid/customers")); ?>',
    datatype: 'xml',
    mtype: 'POST',
    colNames:['More Info','Last Name','First Name','MI','Title','Customer ID','New Client','Address','City','State','Zipcode'],
    colModel :[ 
	  {name:'edit', index:'edit', width:60, editable:false, sortable:false, search:false}, 
	  {name:'lname', index:'lname', width:60, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'fname', index:'fname', width:60, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'mname', index:'mname', width:20, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 	  
	  {name:'title', index:'title', width:50, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
      {name:'key', index:'key', width:60, editable:false, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'new_client', index:'new_client', width:60, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'address', index:'address', width:60, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'city', index:'city', width:60, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'state', index:'state', width:30, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'zipcode', index:'zipcode', width:35, editable:true, sortable:true, searchoptions:{sopt: ['cn']}} 
    ],
    pager: '#pager',
    rowNum:100,
	height:300,
    rowList:[100,250,1000,5000],
    sortname: 'lname',
    sortorder: 'asc',
    viewrecords: true,
	autowidth: true,
	scrolling:true,
	//altRows:true,
    caption: 'Customers'
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
<h1>Edit Customers</h1>
<table id="list"></table> 
<div id="pager"></div>
