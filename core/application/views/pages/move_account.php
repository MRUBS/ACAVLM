<h1>Move Account</h1>
<?php 
$form_attributes = array('class' => 'niceform1', 'id' => 'form_move_account');
echo form_open(current_url(),$form_attributes); 
?>
<ul>
    <li>
        <label for="from_account">From Account:</label>
        <?php echo form_dropdown('from_account', $account_options); ?>
    </li>
    <li>
        <label for="to_customer">To Customer:</label>
        <?php echo form_dropdown('to_customer', $customer_options); ?>
    </li>
    <div class="clearline">&nbsp;</div>
    <li class="submit">
    	<?php echo form_hidden('action', 'move_account'); ?>
    	<?php echo form_submit('submitbt', 'Move Account'); ?>
    </li>
</ul>
<?php echo form_close(); ?>