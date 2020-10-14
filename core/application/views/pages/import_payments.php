<h1>Import Payments</h1>
<?php
if(!$uploaded){
?>
<p>Make sure your csv file follows the same structure of this <a href="<?php echo (base_url()); ?>assets/templates/importpayments_sample.csv">template</a></p>
<?php 
$form_attributes = array('class' => 'niceform1', 'id' => 'form_importpayment_upload');
echo form_open_multipart(current_url(),$form_attributes); 
?>
<ul>
    <li>
        <label for="csvfile">CSV File:</label>
        <?php 
        $field = array(
            'name'        => 'csvfile',
            'id'          => 'csvfile',
            'class'       => 'textfield',
            'value'       => ''
        );
        echo form_upload($field);
        ?>
    </li>
    <li>
        <label for="unittype">Unit Type:</label>
		<?php 
		$options = array('nw'=>'New Units','dt'=>'Dist. Units','tr'=>'Trans Units');
		echo form_dropdown('unittype', $options, 'nw');
		?>
    </li>
    <li class="submit">
        <?php echo form_hidden('action', 'importpayment_upload'); ?>
        <?php echo form_submit('submitbt', 'Upload File'); ?>
    </li>
</ul>
<?php echo form_close(); ?>
<br />
<?php
}
?>
<?php
if($uploaded){
	//print_r($csvData);
?>
<hr/>
<p>Below is the data that will be imported (Type: <strong><?php echo($unittype); ?></strong>). If any errors are below, please edit the file and re-upload. Any rows with errors will not be submitted.</p>
<?php 
$form_attributes = array('class' => 'niceform1', 'id' => 'form_importpayment');
echo form_open(current_url(),$form_attributes); 
?>
<ul>
    <li class="submit">
    	<?php echo form_hidden('file', $uploaddata['upload_data']['full_path']); ?>
        <?php echo form_hidden('action', 'importpayment'); ?>
        <?php echo form_hidden('unittype', $unittype); ?>
        <?php echo form_submit('submitbt', 'IMPORT PAYMENTS'); ?>
    </li>
</ul>
<?php echo form_close(); ?>
<table class="table1 zebra">
	<tr>
    	<th>Account</th>
    	<th>Fund</th>
  <th>Date</th>
      <th>Company</th>        
      <th>Amount</th>
        <th>Units</th>
        <th>&nbsp;</th>
    </tr>
   	<?php
	$ct = 0;
	foreach($csvdata as $csvrow){
		?>
        <tr class="<?php echo($csvrow['rowclass']); ?>">
        <td><?php echo($csvrow['account']); ?></td>
    	<td><?php echo($csvrow['fund']); ?></td>
        <td><?php echo($csvrow['date']); ?></td>
        <td><?php echo($csvrow['company']); ?></td>        
        <td align="right"><?php echo($csvrow['amount']); ?></td>
        <td align="right"><?php echo($csvrow['units']); ?></td>
        <td><span style="color:#F00;"><?php echo($csvrow['error']); ?></span></td>
        </tr>
        <?php
	}
	?>
</table>
<?php
}
?>
