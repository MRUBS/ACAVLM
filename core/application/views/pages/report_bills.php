<h1>Billing</h1>
<?php 
$form_attributes = array('class' => 'niceform1', 'id' => 'form_target_report');
echo form_open(current_url(),$form_attributes); 
?>
<ul>
    <li class="small" style="width:140px;">
        <label for="billperc">Billing Perc.:</label>
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
    <li class="small" style="width:110px;">
        <label for="adv">ADV:</label>
        <?php 
		$field = array(
        	'name'        => 'adv',
            'id'          => 'adv',
			'class'       => 'textfield',
            'value'       => '',
            'maxlength'   => '3'
        );
		echo form_input($field);
		?>
        <small>Leave blank for all</small>
    </li>
    <li class="small" style="width:110px;">
        <label for="pa">PA:</label>
        <?php 
		$field = array(
        	'name'        => 'pa',
            'id'          => 'pa',
			'class'       => 'textfield',
            'value'       => '',
            'maxlength'   => '1'
        );
		echo form_input($field);
		?>
        <small>Leave blank for all</small>
    </li>
    <li class="small" style="width:90px;">
        <label for="year">BEFORE Year:</label>
        <?php 
		$field = array(
        	'name'        => 'year',
            'id'          => 'year',
			'class'       => 'textfield',
            'value'       => '',
            'maxlength'   => '5'
        );
		echo form_input($field);
		?>
        <small>Account Opened</small>
    </li>
    <div class="clearline">&nbsp;</div>
    <li>
        <label for="acct_types">Account Types (Leave blank to show all):</label>
        <ul class="checks">
        <?php 
		foreach($fundtypes as $fundtype){ 
			if($fundtype->type == "T"){
		?>
        <li><?php echo form_checkbox('acct_types[]', $fundtype->id); ?> <label><?php echo($fundtype->description); ?></label></li>
        <?php 
			}
		} 
		?>
        </ul>
    </li>
    <div class="clearline">&nbsp;</div>
    <li>
        <label for="acct_media">Account Company (Leave blank to show all):</label>
        <ul class="checks">
        <?php 
		foreach($fundtypes as $fundtype){ 
			if($fundtype->type == "C"){
		?>
        <li><?php echo form_checkbox('acct_media[]', $fundtype->id); ?><label><?php echo($fundtype->description); ?></label></li>
        <?php 
			}
		} 
		?>
        </ul>
    </li>
    <div class="clearline">&nbsp;</div>
    <li class="submit">
    	<?php echo form_hidden('action', 'target_report'); ?>
    	<?php echo form_submit('submitbt', 'Download'); ?>
    </li>
</ul>
<?php echo form_close(); ?>