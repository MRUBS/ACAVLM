<h1>Customer (#<?php echo($customer->key); ?>) <?php echo($customer->fname); ?> <?php echo($customer->mname); ?> <?php echo($customer->lname); ?></h1>
<h2>Accounts</h2>
<script type="text/javascript">
//['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'] 
$(function(){ 
  $("#list").jqGrid({
    url:'<?php echo (site_url("grid/customer_accounts/".$customer->id)); ?>',
	editurl: '<?php echo (site_url("grid/customer_accounts/".$customer->id)); ?>',
    datatype: 'xml',
    mtype: 'POST',
    colNames:['Edit Account','Account #','Fund Type','Fund Media'],
    colModel :[ 
	  {name:'edit', index:'edit', width:60, editable:false, sortable:false, search:false}, 
      {name:'account', index:'account', width:60, editable:true, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'type', index:'type', width:60, editable:true, edittype:"select", editoptions:{value:"<?php echo($code_types); ?>"}, sortable:true, searchoptions:{sopt: ['cn']}}, 
	  {name:'code', index:'code', width:60, editable:true, edittype:"select", editoptions:{value:"<?php echo($code_companies); ?>"}, sortable:true, searchoptions:{sopt: ['cn']}}
    ],
    pager: '#pager',
    rowNum:500,
	height:100,
    rowList:[500,1000,5000],
    sortname: 'account',
    sortorder: 'asc',
    viewrecords: true,
	autowidth: true,
	scrolling:true,
	//altRows:true,
    caption: 'Accounts'
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
<table id="list"></table> 
<div id="pager"></div>
<br/>
<h2>Customer Information</h2>
<?php 
$form_attributes = array('class' => 'niceform1', 'id' => 'form_customer');
echo form_open(current_url(),$form_attributes); 
?>
<ul>
    <li>
        <label for="key">Customer ID:</label>
        <?php 
		$field = array(
        	'name'        => 'key',
            'id'          => 'key',
			'class'       => 'textfield',
            'value'       => $customer->key,
            'maxlength'   => '25'
        );
		echo form_input($field);
		?>
    </li>
    <li class="mini">
        <label for="title">Title:</label>
        <?php 
		$field = array(
        	'name'        => 'title',
            'id'          => 'title',
			'class'       => 'textfield',
            'value'       => $customer->title,
            'maxlength'   => '10'
        );
		echo form_input($field);
		?>
    </li>
    <li class="small">
        <label for="fname">First Name:</label>
        <?php 
		$field = array(
        	'name'        => 'fname',
            'id'          => 'fname',
			'class'       => 'textfield',
            'value'       => $customer->fname,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
    </li>
    <li class="mini">
        <label for="mname">MI:</label>
        <?php 
		$field = array(
        	'name'        => 'mname',
            'id'          => 'mname',
			'class'       => 'textfield',
            'value'       => $customer->mname,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
    </li>
    <li class="small">
        <label for="lname">Last Name:</label>
        <?php 
		$field = array(
        	'name'        => 'lname',
            'id'          => 'lname',
			'class'       => 'textfield',
            'value'       => $customer->lname,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
    </li>
    <div class="clearline">&nbsp;</div>
    <li>
        <label for="address">Address:</label>
        <?php 
		$field = array(
        	'name'        => 'address',
            'id'          => 'address',
			'class'       => 'textfield',
            'value'       => $customer->address,
            'maxlength'   => '100'
        );
		echo form_input($field);
		?>
    </li>
    <li class="small">
        <label for="city">City:</label>
        <?php 
		$field = array(
        	'name'        => 'city',
            'id'          => 'city',
			'class'       => 'textfield',
            'value'       => $customer->city,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
    </li>
    <li class="small">
        <label for="state">***State:</label>
        <?php 
		$field = array(
        	'name'        => 'state',
            'id'          => 'state',
			'class'       => 'textfield',
            'value'       => $customer->state,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
    </li>
    <li class="small">
        <label for="zipcode">Zipcode:</label>
        <?php 
		$field = array(
        	'name'        => 'zipcode',
            'id'          => 'zipcode',
			'class'       => 'textfield',
            'value'       => $customer->zipcode,
            'maxlength'   => '20'
        );
		echo form_input($field);
		?>
    </li>
    <div class="clearline">&nbsp;</div>
    <li class="small">
        <label for="phone_home">Home Phone:</label>
        <?php 
		$field = array(
        	'name'        => 'phone_home',
            'id'          => 'phone_home',
			'class'       => 'textfield',
            'value'       => $customer->phone_home,
            'maxlength'   => '20'
        );
		echo form_input($field);
		?>
    </li>
    <li class="small">
        <label for="phone_work">Work Phone:</label>
        <?php 
		$field = array(
        	'name'        => 'phone_work',
            'id'          => 'phone_work',
			'class'       => 'textfield',
            'value'       => $customer->phone_work,
            'maxlength'   => '20'
        );
		echo form_input($field);
		?>
    </li>
    <div class="clearline">&nbsp;</div>
    <li>
        <label for="dob">Date of Birth:</label>
        <?php 
		$field = array(
        	'name'        => 'dob',
            'id'          => 'dob',
			'class'       => 'textfield date',
            'value'       => $customer->dob,
            'maxlength'   => '20'
        );
		echo form_input($field);
		?>
    </li>
    <li>
        <label for="tax_id">SSN:</label>
        <?php 
		$field = array(
        	'name'        => 'tax_id',
            'id'          => 'tax_id',
			'class'       => 'textfield ssn',
            'value'       => $customer->tax_id,
            'maxlength'   => '20'
        );
		echo form_input($field);
		?>
    </li>
    <li class="mini">
        <label for="rep">Rep:</label>
        <?php 
		$field = array(
        	'name'        => 'rep',
            'id'          => 'rep',
			'class'       => 'textfield',
            'value'       => $customer->rep,
            'maxlength'   => '10'
        );
		echo form_input($field);
		?>
    </li>
    <li class="mini">
        <label for="pybill">PY Bill Amt:</label>
        <?php 
		$field = array(
        	'name'        => 'pybill',
            'id'          => 'pybill',
			'class'       => 'textfield',
            'value'       => $customer->pybill,
            'maxlength'   => '10'
        );
		echo form_input($field);
		?>
    </li>
    <li class="mini">
        <label for="paid">Paid:</label>
        <?php 
		$field = array(
        	'name'        => 'paid',
            'id'          => 'paid',
			'class'       => 'textfield',
            'value'       => $customer->paid,
            'maxlength'   => '10'
        );
		echo form_input($field);
		?>
    </li>
    <li class="small">
        <label for="mailnick">Mail Nick:</label>
        <?php 
		$field = array(
        	'name'        => 'mailnick',
            'id'          => 'flag',
			'class'       => 'textfield',
            'value'       => $customer->mailnick,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
    </li>
    <div class="clearline">&nbsp;</div>
    <li class="mini">
        <label for="label">Label:</label>
        <?php 
		$field = array(
        	'name'        => 'label',
            'id'          => 'label',
			'class'       => 'textfield',
            'value'       => $customer->label,
            'maxlength'   => '2'
        );
		echo form_input($field);
		?>
    </li>
    <li class="small">
        <label for="new_client">New Client: (mm/yy)</label>
        <?php 
		$field = array(
        	'name'        => 'new_client',
            'id'          => 'new_client',
			'class'       => 'textfield',
            'value'       => $customer->new_client,
            'maxlength'   => '20'
        );
		echo form_input($field);
		?>
    </li>
    <li class="small">
        <label for="label_title">Label Title:</label>
        <?php 
		$field = array(
        	'name'        => 'label_title',
            'id'          => 'label_title',
			'class'       => 'textfield',
            'value'       => $customer->label_title,
            'maxlength'   => '20'
        );
		echo form_input($field);
		?>
    </li>
    <div class="clearline">&nbsp;</div>
    <li>
        <label for="notes">Notes:</label>
        <?php 
		$field = array(
        	'name'        => 'notes',
            'id'          => 'notes',
            'value'       => $customer->notes
        );
		echo form_textarea($field);
		?>
    </li>
    <div class="clearline">&nbsp;</div>
    <li class="submit">
    	<?php echo form_hidden('action', 'edit_customer'); ?>
    	<?php echo form_submit('submitbt', 'Save'); ?>
    </li>
</ul>
<?php echo form_close(); ?>
