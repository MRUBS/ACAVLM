<?php if($sent){ ?>


<script type="text/javascript">
parent.$.fn.colorbox.close();
</script>
<h1>Permissions have been set!</h1>
<p><strong><a href="javascript:parent.$.fn.colorbox.close();">Click here to return.</a></strong></p>


<?php }else{ ?>


<h1>Set Permissions for <?php echo($editfund->description); ?></h1>
<?php 
$form_attributes = array('class' => 'niceform1', 'id' => 'form_fundtype');
echo form_open(current_url(),$form_attributes); 
?>
<ul>
    <li class="small">
    	<label>eq_descr</label>
        <?php 
		$field = array(
        	'name'        => 'eq_descr',
            'id'          => 'eq_descr',
			'class'       => 'textfield',
            'value'       => $editfund->eq_descr,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>eqpy_price</label>
        <?php 
		$field = array(
        	'name'        => 'eqpy_price',
            'id'          => 'eqpy_price',
			'class'       => 'textfield',
            'value'       => $editfund->eqpy_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>eq_price</label>
        <?php 
		$field = array(
        	'name'        => 'eq_price',
            'id'          => 'eq_price',
			'class'       => 'textfield',
            'value'       => $editfund->eq_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <div class="clearline">&nbsp;</div>
    <li class="small">
    	<label>e1_descr</label>
        <?php 
		$field = array(
        	'name'        => 'e1_descr',
            'id'          => 'e1_descr',
			'class'       => 'textfield',
            'value'       => $editfund->e1_descr,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>e1py_price</label>
        <?php 
		$field = array(
        	'name'        => 'e1py_price',
            'id'          => 'e1py_price',
			'class'       => 'textfield',
            'value'       => $editfund->e1py_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>e1_price</label>
        <?php 
		$field = array(
        	'name'        => 'e1_price',
            'id'          => 'e1_price',
			'class'       => 'textfield',
            'value'       => $editfund->e1_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <div class="clearline">&nbsp;</div>
    <li class="small">
    	<label>e2_descr</label>
        <?php 
		$field = array(
        	'name'        => 'e2_descr',
            'id'          => 'e2_descr',
			'class'       => 'textfield',
            'value'       => $editfund->e2_descr,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>e2py_price</label>
        <?php 
		$field = array(
        	'name'        => 'e2py_price',
            'id'          => 'e2py_price',
			'class'       => 'textfield',
            'value'       => $editfund->e2py_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>e2_price</label>
        <?php 
		$field = array(
        	'name'        => 'e2_price',
            'id'          => 'e2_price',
			'class'       => 'textfield',
            'value'       => $editfund->e2_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <div class="clearline">&nbsp;</div>
    <li class="small">
    	<label>e3_descr</label>
        <?php 
		$field = array(
        	'name'        => 'e3_descr',
            'id'          => 'e3_descr',
			'class'       => 'textfield',
            'value'       => $editfund->e3_descr,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>e3py_price</label>
        <?php 
		$field = array(
        	'name'        => 'e3py_price',
            'id'          => 'e3py_price',
			'class'       => 'textfield',
            'value'       => $editfund->e3py_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>e3_price</label>
        <?php 
		$field = array(
        	'name'        => 'e3_price',
            'id'          => 'e3_price',
			'class'       => 'textfield',
            'value'       => $editfund->e3_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <div class="clearline">&nbsp;</div>
    <li class="small">
    	<label>e4_descr</label>
        <?php 
		$field = array(
        	'name'        => 'e4_descr',
            'id'          => 'e4_descr',
			'class'       => 'textfield',
            'value'       => $editfund->e4_descr,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>e4py_price</label>
        <?php 
		$field = array(
        	'name'        => 'e4py_price',
            'id'          => 'e4py_price',
			'class'       => 'textfield',
            'value'       => $editfund->e4py_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>e4_price</label>
        <?php 
		$field = array(
        	'name'        => 'e4_price',
            'id'          => 'e4_price',
			'class'       => 'textfield',
            'value'       => $editfund->e4_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <div class="clearline">&nbsp;</div>
    <li class="small">
    	<label>bd_descr</label>
        <?php 
		$field = array(
        	'name'        => 'bd_descr',
            'id'          => 'bd_descr',
			'class'       => 'textfield',
            'value'       => $editfund->bd_descr,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>bdpy_price</label>
        <?php 
		$field = array(
        	'name'        => 'bdpy_price',
            'id'          => 'bdpy_price',
			'class'       => 'textfield',
            'value'       => $editfund->bdpy_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>bd_price</label>
        <?php 
		$field = array(
        	'name'        => 'bd_price',
            'id'          => 'bd_price',
			'class'       => 'textfield',
            'value'       => $editfund->bd_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <div class="clearline">&nbsp;</div>
    <li class="small">
    	<label>ot_descr</label>
        <?php 
		$field = array(
        	'name'        => 'ot_descr',
            'id'          => 'ot_descr',
			'class'       => 'textfield',
            'value'       => $editfund->ot_descr,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>otpy_price</label>
        <?php 
		$field = array(
        	'name'        => 'otpy_price',
            'id'          => 'otpy_price',
			'class'       => 'textfield',
            'value'       => $editfund->otpy_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>ot_price</label>
        <?php 
		$field = array(
        	'name'        => 'ot_price',
            'id'          => 'ot_price',
			'class'       => 'textfield',
            'value'       => $editfund->ot_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <div class="clearline">&nbsp;</div>
    <li class="small">
    	<label>mm_descr</label>
        <?php 
		$field = array(
        	'name'        => 'mm_descr',
            'id'          => 'mm_descr',
			'class'       => 'textfield',
            'value'       => $editfund->mm_descr,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>mmpy_price</label>
        <?php 
		$field = array(
        	'name'        => 'mmpy_price',
            'id'          => 'mmpy_price',
			'class'       => 'textfield',
            'value'       => $editfund->mmpy_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>mm_price</label>
        <?php 
		$field = array(
        	'name'        => 'mm_price',
            'id'          => 'mm_price',
			'class'       => 'textfield',
            'value'       => $editfund->mm_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <div class="clearline">&nbsp;</div>
    <li class="small">
    	<label>gn_descr</label>
        <?php 
		$field = array(
        	'name'        => 'gn_descr',
            'id'          => 'gn_descr',
			'class'       => 'textfield',
            'value'       => $editfund->gn_descr,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>gnpy_price</label>
        <?php 
		$field = array(
        	'name'        => 'gnpy_price',
            'id'          => 'gnpy_price',
			'class'       => 'textfield',
            'value'       => $editfund->gnpy_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>gn_price</label>
        <?php 
		$field = array(
        	'name'        => 'gn_price',
            'id'          => 'gn_price',
			'class'       => 'textfield',
            'value'       => $editfund->gn_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <div class="clearline">&nbsp;</div>
    <li class="small">
    	<label>z1_descr</label>
        <?php 
		$field = array(
        	'name'        => 'z1_descr',
            'id'          => 'z1_descr',
			'class'       => 'textfield',
            'value'       => $editfund->z1_descr,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>z1py_price</label>
        <?php 
		$field = array(
        	'name'        => 'z1py_price',
            'id'          => 'z1py_price',
			'class'       => 'textfield',
            'value'       => $editfund->z1py_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>z1_price</label>
        <?php 
		$field = array(
        	'name'        => 'z1_price',
            'id'          => 'z1_price',
			'class'       => 'textfield',
            'value'       => $editfund->z1_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <div class="clearline">&nbsp;</div>
    <li class="small">
    	<label>z2_descr</label>
        <?php 
		$field = array(
        	'name'        => 'z2_descr',
            'id'          => 'z2_descr',
			'class'       => 'textfield',
            'value'       => $editfund->z2_descr,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>z2py_price</label>
        <?php 
		$field = array(
        	'name'        => 'z2py_price',
            'id'          => 'z2py_price',
			'class'       => 'textfield',
            'value'       => $editfund->z2py_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>z2_price</label>
        <?php 
		$field = array(
        	'name'        => 'z2_price',
            'id'          => 'z2_price',
			'class'       => 'textfield',
            'value'       => $editfund->z2_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <div class="clearline">&nbsp;</div>
    <li class="small">
    	<label>z3_descr</label>
        <?php 
		$field = array(
        	'name'        => 'z3_descr',
            'id'          => 'z3_descr',
			'class'       => 'textfield',
            'value'       => $editfund->z3_descr,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>z3py_price</label>
        <?php 
		$field = array(
        	'name'        => 'z3py_price',
            'id'          => 'z3py_price',
			'class'       => 'textfield',
            'value'       => $editfund->z3py_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>z3_price</label>
        <?php 
		$field = array(
        	'name'        => 'z3_price',
            'id'          => 'z3_price',
			'class'       => 'textfield',
            'value'       => $editfund->z3_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <div class="clearline">&nbsp;</div>
    <li class="small">
    	<label>z4_descr</label>
        <?php 
		$field = array(
        	'name'        => 'z4_descr',
            'id'          => 'z4_descr',
			'class'       => 'textfield',
            'value'       => $editfund->z4_descr,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>z4py_price</label>
        <?php 
		$field = array(
        	'name'        => 'z4py_price',
            'id'          => 'z4py_price',
			'class'       => 'textfield',
            'value'       => $editfund->z4py_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>z4_price</label>
        <?php 
		$field = array(
        	'name'        => 'z4_price',
            'id'          => 'z4_price',
			'class'       => 'textfield',
            'value'       => $editfund->z4_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <div class="clearline">&nbsp;</div>
    <li class="small">
    	<label>z5_descr</label>
        <?php 
		$field = array(
        	'name'        => 'z5_descr',
            'id'          => 'z5_descr',
			'class'       => 'textfield',
            'value'       => $editfund->z5_descr,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>z5py_price</label>
        <?php 
		$field = array(
        	'name'        => 'z5py_price',
            'id'          => 'z5py_price',
			'class'       => 'textfield',
            'value'       => $editfund->z5py_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>z5_price</label>
        <?php 
		$field = array(
        	'name'        => 'z5_price',
            'id'          => 'z5_price',
			'class'       => 'textfield',
            'value'       => $editfund->z5_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <div class="clearline">&nbsp;</div>
    <li class="small">
    	<label>z6_descr</label>
        <?php 
		$field = array(
        	'name'        => 'z6_descr',
            'id'          => 'z6_descr',
			'class'       => 'textfield',
            'value'       => $editfund->z6_descr,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>z6py_price</label>
        <?php 
		$field = array(
        	'name'        => 'z6py_price',
            'id'          => 'z6py_price',
			'class'       => 'textfield',
            'value'       => $editfund->z6py_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>z6_price</label>
        <?php 
		$field = array(
        	'name'        => 'z6_price',
            'id'          => 'z6_price',
			'class'       => 'textfield',
            'value'       => $editfund->z6_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <div class="clearline">&nbsp;</div>
    <li class="small">
    	<label>z7_descr</label>
        <?php 
		$field = array(
        	'name'        => 'z7_descr',
            'id'          => 'z7_descr',
			'class'       => 'textfield',
            'value'       => $editfund->z7_descr,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>z7py_price</label>
        <?php 
		$field = array(
        	'name'        => 'z7py_price',
            'id'          => 'z7py_price',
			'class'       => 'textfield',
            'value'       => $editfund->z7py_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>z7_price</label>
        <?php 
		$field = array(
        	'name'        => 'z7_price',
            'id'          => 'z7_price',
			'class'       => 'textfield',
            'value'       => $editfund->z7_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <div class="clearline">&nbsp;</div>
    <li class="small">
    	<label>z8_descr</label>
        <?php 
		$field = array(
        	'name'        => 'z8_descr',
            'id'          => 'z8_descr',
			'class'       => 'textfield',
            'value'       => $editfund->z8_descr,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>z8py_price</label>
        <?php 
		$field = array(
        	'name'        => 'z8py_price',
            'id'          => 'z8py_price',
			'class'       => 'textfield',
            'value'       => $editfund->z8py_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>z8_price</label>
        <?php 
		$field = array(
        	'name'        => 'z8_price',
            'id'          => 'z8_price',
			'class'       => 'textfield',
            'value'       => $editfund->z8_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <div class="clearline">&nbsp;</div>
    <li class="small">
    	<label>z9_descr</label>
        <?php 
		$field = array(
        	'name'        => 'z9_descr',
            'id'          => 'z9_descr',
			'class'       => 'textfield',
            'value'       => $editfund->z9_descr,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>z9py_price</label>
        <?php 
		$field = array(
        	'name'        => 'z9py_price',
            'id'          => 'z9py_price',
			'class'       => 'textfield',
            'value'       => $editfund->z9py_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <li class="small">
    	<label>z9_price</label>
        <?php 
		$field = array(
        	'name'        => 'z9_price',
            'id'          => 'z9_price',
			'class'       => 'textfield',
            'value'       => $editfund->z9_price,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
	</li>
    <div class="clearline">&nbsp;</div>
    <li class="submit">
    	<?php echo form_hidden('edit_fund', $editfund->id); ?>
    	<?php echo form_hidden('action', 'edit_fund'); ?>
    	<?php echo form_submit('submitbt', 'Save'); ?>
    </li>
</ul>
<?php echo form_close(); ?>


<?php } ?>