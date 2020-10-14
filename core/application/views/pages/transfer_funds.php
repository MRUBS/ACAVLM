<script type="text/javascript">
$(document).ready(function(){
	$("#fund_type").change(function() {
		update_funds();
	});
	update_funds();
});
function update_funds(){
	//wait a second
	setTimeout(
		function(){
			//Update select box
			$("#fund_from").load("<?php echo (base_url()); ?>system/autofunds/transfer",{id: $("#fund_type").val(), ajax: 'true'});
			$("#fund_to").load("<?php echo (base_url()); ?>system/autofunds/transfer",{id: $("#fund_type").val(), ajax: 'true'});
		}, 
		300
	);
}
</script>
<h1>Transfer Funds</h1>
<?php 
$form_attributes = array('class' => 'niceform1', 'id' => 'form_transfer_funds');
echo form_open(current_url(),$form_attributes); 
?>
<ul>
    <li>
        <label for="fund_type">Fund Type:</label>
        <?php 
		$options = $funds;
		$addl = ' id = "fund_type" ';
		//$fields['payment_company']
		echo form_dropdown('fund_type', $options, '',$addl);
		//$funds
		?>
    </li>
    <li>
        <label for="fund_from">From Fund:</label>
        <?php 
		$options = array();
		$addl = ' id = "fund_from" ';
		//$fields['payment_company']
		echo form_dropdown('fund_from', $options, '',$addl);
		?>
    </li>
    <li>
        <label for="fund_from_price">From Fund Price:</label>
        <?php 
		$field = array(
        	'name'        => 'fund_from_price',
            'id'          => 'fund_from_price',
			'class'       => 'textfield',
            'value'       => '',
            'maxlength'   => '25'
        );
		echo form_input($field);
		?>
    </li>
    <li>
        <label for="fund_to">To Fund:</label>
        <?php 
		$options = array();
		$addl = ' id = "fund_to" ';
		//$fields['payment_company']
		echo form_dropdown('fund_to', $options, '',$addl);
		?>
    </li>
    <li>
        <label for="fund_to_price">To Fund Price:</label>
        <?php 
		$field = array(
        	'name'        => 'fund_to_price',
            'id'          => 'fund_to_price',
			'class'       => 'textfield',
            'value'       => '',
            'maxlength'   => '25'
        );
		echo form_input($field);
		?>
    </li>
    <li>
        <label for="percent">Percentage of Units:</label>
        <?php 
		$field = array(
        	'name'        => 'percent',
            'id'          => 'percent',
			'class'       => 'textfield',
            'value'       => '',
            'maxlength'   => '25'
        );
		echo form_input($field);
		?>
    </li>
    <div class="clearline">&nbsp;</div>
    <li class="submit">
    	<?php echo form_hidden('action', 'transfer_funds'); ?>
    	<?php echo form_submit('submitbt', 'Transfer'); ?>
    </li>
</ul>
<?php echo form_close(); ?>