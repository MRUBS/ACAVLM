<script type="text/javascript">
var funddefault = "<?php echo($fields['payment_fund']); ?>";
$(document).ready(function(){
	$("#account").autocomplete("<?php echo (base_url()); ?>system/autoaccount",{
		selectFirst: false,
		formatItem: function(data, i, n, value) {
			return value;
		},
		formatResult: function(data, value) {
			return value.split(" - ")[0];
		}
	});
	$("#account").change(function() {
		funddefault="";
		update_funds();
	});
	$(window).load(function () {
    	$('#form_customer .accountfield').focus();
  	});
	update_funds();
	$('#account').click(function() { 
		$('#account').focus();
    	$('#account').select();
	});
});
function update_funds(){
	//wait a second
	setTimeout(
		function(){
			//Update select box
			$("#fund").load("<?php echo (base_url()); ?>system/autofunds/"+funddefault,{id: $("#account").val(), ajax: 'true'});
		}, 
		300
	);
}
</script>
<h1>Payments</h1>
<h2>Add Payment</h2>
<?php 
$form_attributes = array('class' => 'niceform1', 'id' => 'form_customer');
echo form_open(current_url(),$form_attributes); 
?>
<ul>
    <li>
        <label for="account">Account:</label>
        <?php 
		$field = array(
        	'name'        => 'account',
            'id'          => 'account',
			'class'       => 'textfield accountfield',
            'value'       => $fields['payment_account'],
            'maxlength'   => '25'
        );
		echo form_input($field);
		?>
    </li>
    <li>
        <label for="fund">Fund:</label>
        <?php 
		$options = array();
		$addl = ' id = "fund" ';
		//$fields['payment_company']
		echo form_dropdown('fund', $options, $fields['payment_fund'],$addl);
		?>
    </li>
    <li>
        <label for="type">Type:</label>
        <?php 
		$field = array(
        	'name'        => 'type',
            'id'          => 'type',
			'class'       => 'textfield',
            'value'       => 'nw',
            'maxlength'   => '10'
        );
		echo form_input($field);
		?>
    </li>
    <li>
        <label for="date">Date:</label>
        <?php 
		$field = array(
        	'name'        => 'date',
            'id'          => 'date',
			'class'       => 'textfield date',
            'value'       => $fields['payment_date'],
            'maxlength'   => '25'
        );
		echo form_input($field);
		?>
    </li>
    <li>
        <label for="company">Company:</label>
        <?php 
		$field = array(
        	'name'        => 'company',
            'id'          => 'company',
			'class'       => 'textfield',
            'value'       => $fields['payment_company'],
            'maxlength'   => '25'
        );
		echo form_input($field);
		?>
    </li>
    <li>
        <label for="amount">Amount:</label>
        <?php 
		$field = array(
        	'name'        => 'amount',
            'id'          => 'amount',
			'class'       => 'textfield',
            'value'       => '0',
            'maxlength'   => '25'
        );
		echo form_input($field);
		?>
    </li>
    <li>
        <label for="units">Units:</label>
        <?php 
		$field = array(
        	'name'        => 'units',
            'id'          => 'units',
			'class'       => 'textfield',
            'value'       => '',
            'maxlength'   => '25'
        );
		echo form_input($field);
		?>
    </li>
    <div class="clearline">&nbsp;</div>
    <li class="submit">
    	<?php echo form_hidden('action', 'edit_customer'); ?>
    	<?php echo form_submit('submitbt', 'Save'); ?>
    </li>
</ul>
<?php echo form_close(); ?>
<h2>Modify / Delete Payments</h2>
<?php 
$form_attributes = array('class' => 'niceform1', 'id' => 'form_filtercompany');
echo form_open(current_url(),$form_attributes); 
?>
<ul>
    <li class="small">
        <label for="company">Company:</label>
		<?php 
		$options = array();
		echo form_dropdown('company', $companyoptions, $currentcompany);
		?>
    </li>
    <li class="submit small">
    	<?php echo form_hidden('action', 'edit_filtercompany'); ?>
    	<?php echo form_submit('submitbt', 'Filter'); ?>
    </li>
    <div class="clearline">&nbsp;</div>
</ul>
<?php echo form_close(); ?>
<?php
$gridoptions = array();
$gridoptions[] = "company:".$currentcompany;
//
$gridoptions = implode("_",$gridoptions);
?>
<script type="text/javascript">
//Input boxes
$(function() {
	$(".csvlink").click( function() { 
		var pd =$("#list").getPostData(); 
		var r ="<?php echo(site_url("grid/payments/".$gridoptions)); ?>/outaction:csv";
		$.each(pd,function(i){ 
			r += "_"+i+":"+pd[i]; 
		})
		window.open(r);
	}); 
});
</script>
<p><a href="javascript:void(0)" class="csvlink">Download CSV</a></p>
<script type="text/javascript">
//['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'] 
$(function(){ 
  $("#list").jqGrid({
    url:'<?php echo (site_url("grid/payments/".$gridoptions)); ?>',
	editurl: '<?php echo (site_url("grid/payments/".$gridoptions)); ?>',
    datatype: 'xml',
    mtype: 'POST',
    colNames:['Account','Fund','Type','Date','Company','Amount','Units'],
    colModel :[ 
      {name:'account', index:'account', width:60, editable:false, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'fund', index:'fund', width:60, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'type', index:'type', width:20, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'date', index:'date', width:60, editable:false, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'company', index:'company', width:60, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'amount', index:'amount', width:60, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'units', index:'units', width:60, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}
    ],
    pager: '#pager',
    rowNum:500,
	height:400,
    rowList:[500,1000,5000],
    sortname: 'account',
    sortorder: 'asc',
    viewrecords: true,
	autowidth: true,
	scrolling:true,
	//altRows:true,
    caption: 'Payments'
  }); 
  $("#list").jqGrid(
  	'navGrid',
	'#pager',
	{edit:true,add:false,del:true,search:true},//Options
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
 // console.log(postdata);
  var respxml = response.responseText;
  if(respxml.indexOf("<error>") > 0){
	  success = false;
	  var str1 = respxml.split("<error>");
	  var str2 = str1[1].split("</error>");
	  message = str2[0];
	  //console.log(postdata);
  }
  var new_id = "1";
  return [success,message,new_id];
}
</script>
<table id="list"></table> 
<div id="pager"></div>