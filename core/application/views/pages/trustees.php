<script type="text/javascript">
//['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'] 
$(function(){ 
  $("#list").jqGrid({
    url:'<?php echo (site_url("grid/trustees")); ?>',
	editurl: '<?php echo (site_url("grid/trustees")); ?>',
    datatype: 'xml',
    mtype: 'POST',
    colNames:['Name', 'Trustee','Address','City','State','Zipcode','Phone','TIN'],
    colModel :[ 
	  {name:'name', index:'name', width:100, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'trustee', index:'trustee', width:80, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'address', index:'address', width:80, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'city', index:'city', width:40, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'state', index:'state', width:25, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'zipcode', index:'zipcode', width:30, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'phone', index:'phone', width:60, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'tin', index:'tin', width:40, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}
    ],
    pager: '#pager',
    rowNum:200,
	height:300,
    rowList:[200,400,600],
    sortname: 'nickname',
    sortorder: 'asc',
    viewrecords: true,
	autowidth: true,
	scrolling:true,
	//altRows:true,
    caption: 'Trustees'
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
<h1>Edit Trustees</h1>
<table id="list"></table> 
<div id="pager"></div>
