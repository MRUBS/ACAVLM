<h1>Target Report</h1>
<?php 
$form_attributes = array('class' => 'niceform1', 'id' => 'form_target_report');
echo form_open(current_url(),$form_attributes); 
?>
<ul>
    <li class="small">
        <label for="billperc">Billing Percent:</label>
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
        <label for="month">Month:</label>
        <?php 
				$options = array(
                  '1'  => 'January',
                  '2'  => 'February',
				  '3'  => 'March',
				  '4'  => 'April',
				  '5'  => 'May',
				  '6'  => 'June',
				  '7'  => 'July',
				  '8'  => 'August',
				  '9'  => 'September',
				  '10'  => 'October',
				  '11'  => 'November',
				  '12'  => 'December',
                );
echo form_dropdown('month', $options);
		?>
    </li>
    <li class="small">
        <label for="year">Year:</label>
        <?php 
		$field = array(
        	'name'        => 'year',
            'id'          => 'year',
			'class'       => 'textfield',
            'value'       => date('Y'),
            'maxlength'   => '4'
        );
		echo form_input($field);
		?>
    </li>
    <div class="clearline">&nbsp;</div>
    <li class="submit">
    	<?php echo form_hidden('action', 'target_report'); ?>
    	<?php echo form_submit('submitbt', 'Download'); ?>
    </li>
</ul>
<?php echo form_close(); ?>