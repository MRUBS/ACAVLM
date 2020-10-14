<h1 style="color:#900;">END OF YEAR SCRIPT</h1>
<p>Running this script will perform the following tasks</p>
<ul>
	<li>Database will be <strong>backed up</strong> to prevent data loss</li>
    <li>All accounts will <strong>replace</strong> the existing <em>Prior Year Target</em> values with <em>Current Target Value</em></li>
    <li>All accounts will have <em>Today's Value</em> <strong>added</strong> to <em>Cumulative</em></li>
</ul>
<br />
<br />
<?php if($run){ echo("Year end script completed"); }else{ ?>
<?php 
$form_attributes = array('class' => 'niceform1', 'id' => 'form_yearend');
echo form_open(current_url(),$form_attributes); 
?>
<ul>
	<li class="small">
        <label for="billperc">Target Percent:</label>
        %<?php 
		$field = array(
        	'name'        => 'billperc',
            'id'          => 'billperc',
			'class'       => 'textfield',
            'value'       => '15',
            'maxlength'   => '10'
        );
		echo form_input($field);
		?>
    </li>
    <li class="small">
        <label for="year">Year <strong>That Has Ended</strong>:</label>
        <?php 
		$field = array(
        	'name'        => 'year',
            'id'          => 'year',
			'class'       => 'textfield',
            'value'       => $endedyear,
            'maxlength'   => '4'
        );
		echo form_input($field);
		?>
    </li>
    <li class="submit">
    	<?php echo form_hidden('action', 'yearend'); ?>
    	<?php echo form_submit('submitbt', 'RUN SCRIPT'); ?>
    </li>
</ul>
<?php echo form_close(); ?>
<?php } ?>