<h1>Account (#<?php echo($account->account); ?>) for <?php echo($customer->fname); ?> <?php echo($customer->mname); ?> <?php echo($customer->lname); ?></h1>
<?php 
$form_attributes = array('class' => 'niceform1 full', 'id' => 'form_account');
echo form_open(current_url(),$form_attributes); 
?>
<ul>
    <li class="medium">
        <label for="issuedate">Issue Date:</label>
        <?php 
		$field = array(
        	'name'        => 'issuedate',
            'id'          => 'issuedate',
			'class'       => 'textfield',
            'value'       => $account->issuedate,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
    </li>
    <div class="clearline">&nbsp;</div>
    <li class="medium">
        <label for="current_year">Current Year Inv.:</label>
        <?php 
		$field = array(
        	'name'        => 'current_year',
            'id'          => 'current_year',
			'class'       => 'textfield',
            'value'       => $account->cy_invest,
			//'readonly'    => 'readonly',
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
    </li>
    <li class="medium">
        <label for="company">Payment Company:</label>
        <?php 
		$field = array(
        	'name'        => 'company',
            'id'          => 'company',
			'class'       => 'textfield',
            'value'       => $account->company,
            'maxlength'   => '20'
        );
		echo form_input($field);
		?>
    </li>
    <li class="mini">
        <label for="pa">P/A:</label>
        <?php 
		$field = array(
        	'name'        => 'pa',
            'id'          => 'pa',
			'class'       => 'textfield',
            'value'       => $account->pa,
            'maxlength'   => '1'
        );
		echo form_input($field);
		?>
    </li>
    <li class="mini">
        <label for="adv">ADV:</label>
        <?php 
		$field = array(
        	'name'        => 'adv',
            'id'          => 'adv',
			'class'       => 'textfield',
            'value'       => $account->adv,
            'maxlength'   => '1'
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
            'value'       => $account->rep,
            'maxlength'   => '10'
        );
		echo form_input($field);
		?>
    </li>
    <div class="clearline">&nbsp;</div>
<li class="medium">
        <label for="cumulative">Cumulative:</label>
        <?php 
		$field = array(
        	'name'        => 'cumulative',
            'id'          => 'cumulative',
			'class'       => 'textfield',
            'value'       => $account->cumulative,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
    </li>
    <li class="medium">
        <label for="va1tova4">VA 1 to VA 4:</label>
        <?php 
		$field = array(
        	'name'        => 'va1tova4',
            'id'          => 'va1tova4',
			'class'       => 'textfield',
            'value'       => $account->va1tova4,
            'maxlength'   => '20'
        );
		echo form_input($field);
		?>
    </li>
    <li class="medium">
        <label for="seccode">SEC / Code:</label>
        <?php 
		$field = array(
        	'name'        => 'seccode',
            'id'          => 'seccode',
			'class'       => 'textfield',
            'value'       => $account->seccode,
            'maxlength'   => '20'
        );
		echo form_input($field);
		?>
    </li>
    <div class="clearline">&nbsp;</div>
<li class="medium">
        <label for="pr_yr_tgt">Prior Year Target:</label>
        <?php 
		$field = array(
        	'name'        => 'pr_yr_tgt',
            'id'          => 'pr_yr_tgt',
			'class'       => 'textfield',
            'value'       => $account->pr_yr_tgt,
            'maxlength'   => '20'
        );
		echo form_input($field);
		?>
    </li>
    <li class="medium">
        <label for="datetrnsf">Date Transferred:</label>
        <?php 
		$field = array(
        	'name'        => 'datetrnsf',
            'id'          => 'datetrnsf',
			'class'       => 'textfield',
            'value'       => $account->datetrnsf,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
    </li>
    <li class="medium">
      <label for="som">SOM:</label>
        <?php 
		$field = array(
        	'name'        => 'som',
            'id'          => 'som',
			'class'       => 'textfield',
            'value'       => $account->som,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
    </li>
    <div class="clearline">&nbsp;</div>
<li style="display:none;">
        <label for="act_total">Account Total:</label>
        <?php 
		$field = array(
        	'name'        => 'act_total',
            'id'          => 'act_total',
			'class'       => 'textfield',
            'value'       => $account->act_total,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
    </li>
<li class="submit">
    	<?php echo form_submit('submitbt', 'Save'); ?>
    </li>
</ul>
<table class="table1 zebra" cellpadding="0" cellspacing="0" border="0">
	<tr>
    	<th>Invest.</th>
        <th>P/Y Units</th>
        <th>P/Y Value</th>
        <th>New Units</th>
        <th>Trans Units</th>
        <th>Dist. Units</th>
        <th>Total Units</th>
        <th>Today's Value</th>
    </tr>
    <tr>
    	<td><strong><?php echo($acct_company->eq_descr); ?></strong></td>
        <td><?php 
		$field = array(
        	'name'        => 'eq_py_unts',
            'id'          => 'eq_py_unts',
			'class'       => 'textfield',
            'value'       => $account->eq_py_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo($acct_company->eq_price); ?></td>
        <td><?php 
		$field = array(
        	'name'        => 'eq_nw_unts',
            'id'          => 'eq_nw_unts',
			'class'       => 'textfield',
            'value'       => $account->eq_nw_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'eq_tr_unts',
            'id'          => 'eq_tr_unts',
			'class'       => 'textfield',
            'value'       => $account->eq_tr_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'eq_dt_unts',
            'id'          => 'eq_dt_unts',
			'class'       => 'textfield',
            'value'       => $account->eq_dt_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo(number_format($acct_totalunits['eq'],4)); ?></td>
        <td class="rightalign">$<?php echo(number_format($acct_todaysprice['eq'],2)); ?></td>
  </tr>
     <tr>
    	<td><strong><?php echo($acct_company->e1_descr); ?></strong></td>
        <td><?php 
		$field = array(
        	'name'        => 'e1_py_unts',
            'id'          => 'e1_py_unts',
			'class'       => 'textfield',
            'value'       => $account->e1_py_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo($acct_company->e1_price); ?></td>
        <td><?php 
		$field = array(
        	'name'        => 'e1_nw_unts',
            'id'          => 'e1_nw_unts',
			'class'       => 'textfield',
            'value'       => $account->e1_nw_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'e1_tr_unts',
            'id'          => 'e1_tr_unts',
			'class'       => 'textfield',
            'value'       => $account->e1_tr_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'e1_dt_unts',
            'id'          => 'e1_dt_unts',
			'class'       => 'textfield',
            'value'       => $account->e1_dt_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo(number_format($acct_totalunits['e1'],4)); ?></td>
        <td class="rightalign">$<?php echo(number_format($acct_todaysprice['e1'],2)); ?></td>
     </tr>
     <tr>
    	<td><strong><?php echo($acct_company->e2_descr); ?></strong></td>
        <td><?php 
		$field = array(
        	'name'        => 'e2_py_unts',
            'id'          => 'e2_py_unts',
			'class'       => 'textfield',
            'value'       => $account->e2_py_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo($acct_company->e2_price); ?></td>
        <td><?php 
		$field = array(
        	'name'        => 'e2_nw_unts',
            'id'          => 'e2_nw_unts',
			'class'       => 'textfield',
            'value'       => $account->e2_nw_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'e2_tr_unts',
            'id'          => 'e2_tr_unts',
			'class'       => 'textfield',
            'value'       => $account->e2_tr_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'e2_dt_unts',
            'id'          => 'e2_dt_unts',
			'class'       => 'textfield',
            'value'       => $account->e2_dt_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo(number_format($acct_totalunits['e2'],4)); ?></td>
        <td class="rightalign">$<?php echo(number_format($acct_todaysprice['e2'],2)); ?></td>
     </tr>
     <tr>
    	<td><strong><?php echo($acct_company->e3_descr); ?></strong></td>
        <td><?php 
		$field = array(
        	'name'        => 'e3_py_unts',
            'id'          => 'e3_py_unts',
			'class'       => 'textfield',
            'value'       => $account->e3_py_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo($acct_company->e3_price); ?></td>
        <td><?php 
		$field = array(
        	'name'        => 'e3_nw_unts',
            'id'          => 'e3_nw_unts',
			'class'       => 'textfield',
            'value'       => $account->e3_nw_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'e3_tr_unts',
            'id'          => 'e3_tr_unts',
			'class'       => 'textfield',
            'value'       => $account->e3_tr_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'e3_dt_unts',
            'id'          => 'e3_dt_unts',
			'class'       => 'textfield',
            'value'       => $account->e3_dt_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo(number_format($acct_totalunits['e3'],4)); ?></td>
        <td class="rightalign">$<?php echo(number_format($acct_todaysprice['e3'],2)); ?></td>
     </tr>
     <tr>
    	<td><strong><?php echo($acct_company->e4_descr); ?></strong></td>
        <td><?php 
		$field = array(
        	'name'        => 'e4_py_unts',
            'id'          => 'e4_py_unts',
			'class'       => 'textfield',
            'value'       => $account->e4_py_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo($acct_company->e4_price); ?></td>
        <td><?php 
		$field = array(
        	'name'        => 'e4_nw_unts',
            'id'          => 'e4_nw_unts',
			'class'       => 'textfield',
            'value'       => $account->e4_nw_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'e4_tr_unts',
            'id'          => 'e4_tr_unts',
			'class'       => 'textfield',
            'value'       => $account->e4_tr_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'e4_dt_unts',
            'id'          => 'e4_dt_unts',
			'class'       => 'textfield',
            'value'       => $account->e4_dt_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo(number_format($acct_totalunits['e4'],4)); ?></td>
        <td class="rightalign">$<?php echo(number_format($acct_todaysprice['e4'],2)); ?></td>
     </tr>
     <tr>
    	<td><strong><?php echo($acct_company->mm_descr); ?></strong></td>
        <td><?php 
		$field = array(
        	'name'        => 'mm_py_unts',
            'id'          => 'mm_py_unts',
			'class'       => 'textfield',
            'value'       => $account->mm_py_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo($acct_company->mm_price); ?></td>
        <td><?php 
		$field = array(
        	'name'        => 'mm_nw_unts',
            'id'          => 'mm_nw_unts',
			'class'       => 'textfield',
            'value'       => $account->mm_nw_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'mm_tr_unts',
            'id'          => 'mm_tr_unts',
			'class'       => 'textfield',
            'value'       => $account->mm_tr_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'mm_dt_unts',
            'id'          => 'mm_dt_unts',
			'class'       => 'textfield',
            'value'       => $account->mm_dt_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo(number_format($acct_totalunits['mm'],2)); ?></td>
        <td class="rightalign">$<?php echo(number_format($acct_todaysprice['mm'],2)); ?></td>
     </tr>
     <tr>
    	<td><strong><?php echo($acct_company->bd_descr); ?></strong></td>
        <td><?php 
		$field = array(
        	'name'        => 'bd_py_unts',
            'id'          => 'bd_py_unts',
			'class'       => 'textfield',
            'value'       => $account->bd_py_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo($acct_company->bd_price); ?></td>
        <td><?php 
		$field = array(
        	'name'        => 'bd_nw_unts',
            'id'          => 'bd_nw_unts',
			'class'       => 'textfield',
            'value'       => $account->bd_nw_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'bd_tr_unts',
            'id'          => 'bd_tr_unts',
			'class'       => 'textfield',
            'value'       => $account->bd_tr_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'bd_dt_unts',
            'id'          => 'bd_dt_unts',
			'class'       => 'textfield',
            'value'       => $account->bd_dt_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo(number_format($acct_totalunits['bd'],4)); ?></td>
        <td class="rightalign">$<?php echo(number_format($acct_todaysprice['bd'],2)); ?></td>
     </tr>
     <tr>
    	<td><strong><?php echo($acct_company->ot_descr); ?></strong></td>
        <td><?php 
		$field = array(
        	'name'        => 'ot_py_unts',
            'id'          => 'ot_py_unts',
			'class'       => 'textfield',
            'value'       => $account->ot_py_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo($acct_company->ot_price); ?></td>
        <td><?php 
		$field = array(
        	'name'        => 'ot_nw_unts',
            'id'          => 'ot_nw_unts',
			'class'       => 'textfield',
            'value'       => $account->ot_nw_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'ot_tr_unts',
            'id'          => 'ot_tr_unts',
			'class'       => 'textfield',
            'value'       => $account->ot_tr_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'ot_dt_unts',
            'id'          => 'ot_dt_unts',
			'class'       => 'textfield',
            'value'       => $account->ot_dt_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo(number_format($acct_totalunits['ot'],4)); ?></td>
        <td class="rightalign">$<?php echo(number_format($acct_todaysprice['ot'],2)); ?></td>
     </tr>
     <tr>
    	<td><strong><?php echo($acct_company->gn_descr); ?></strong></td>
        <td><?php 
		$field = array(
        	'name'        => 'gn_py_unts',
            'id'          => 'gn_py_unts',
			'class'       => 'textfield',
            'value'       => $account->gn_py_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo($acct_company->gn_price); ?></td>
        <td><?php 
		$field = array(
        	'name'        => 'gn_nw_unts',
            'id'          => 'gn_nw_unts',
			'class'       => 'textfield',
            'value'       => $account->gn_nw_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'gn_tr_unts',
            'id'          => 'gn_tr_unts',
			'class'       => 'textfield',
            'value'       => $account->gn_tr_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'gn_dt_unts',
            'id'          => 'gn_dt_unts',
			'class'       => 'textfield',
            'value'       => $account->gn_dt_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo(number_format($acct_totalunits['gn'],4)); ?></td>
        <td class="rightalign">$<?php echo(number_format($acct_todaysprice['gn'],2)); ?></td>
     </tr>
     <tr>
    	<td><strong><?php echo($acct_company->z1_descr); ?></strong></td>
        <td><?php 
		$field = array(
        	'name'        => 'z1_py_unts',
            'id'          => 'z1_py_unts',
			'class'       => 'textfield',
            'value'       => $account->z1_py_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo($acct_company->z1_price); ?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z1_nw_unts',
            'id'          => 'z1_nw_unts',
			'class'       => 'textfield',
            'value'       => $account->z1_nw_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z1_tr_unts',
            'id'          => 'z1_tr_unts',
			'class'       => 'textfield',
            'value'       => $account->z1_tr_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z1_dt_unts',
            'id'          => 'z1_dt_unts',
			'class'       => 'textfield',
            'value'       => $account->z1_dt_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo(number_format($acct_totalunits['z1'],4)); ?></td>
        <td class="rightalign">$<?php echo(number_format($acct_todaysprice['z1'],2)); ?></td>
     </tr>
     <tr>
    	<td><strong><?php echo($acct_company->z2_descr); ?></strong></td>
        <td><?php 
		$field = array(
        	'name'        => 'z2_py_unts',
            'id'          => 'z2_py_unts',
			'class'       => 'textfield',
            'value'       => $account->z2_py_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo($acct_company->z2_price); ?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z2_nw_unts',
            'id'          => 'z2_nw_unts',
			'class'       => 'textfield',
            'value'       => $account->z2_nw_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z2_tr_unts',
            'id'          => 'z2_tr_unts',
			'class'       => 'textfield',
            'value'       => $account->z2_tr_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z2_dt_unts',
            'id'          => 'z2_dt_unts',
			'class'       => 'textfield',
            'value'       => $account->z2_dt_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo(number_format($acct_totalunits['z2'],4)); ?></td>
        <td class="rightalign">$<?php echo(number_format($acct_todaysprice['z2'],2)); ?></td>
     </tr>
     <tr>
    	<td><strong><?php echo($acct_company->z3_descr); ?></strong></td>
        <td><?php 
		$field = array(
        	'name'        => 'z3_py_unts',
            'id'          => 'z3_py_unts',
			'class'       => 'textfield',
            'value'       => $account->z3_py_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo($acct_company->z3_price); ?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z3_nw_unts',
            'id'          => 'z3_nw_unts',
			'class'       => 'textfield',
            'value'       => $account->z3_nw_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z3_tr_unts',
            'id'          => 'z3_tr_unts',
			'class'       => 'textfield',
            'value'       => $account->z3_tr_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z3_dt_unts',
            'id'          => 'z3_dt_unts',
			'class'       => 'textfield',
            'value'       => $account->z3_dt_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo(number_format($acct_totalunits['z3'],4)); ?></td>
        <td class="rightalign">$<?php echo(number_format($acct_todaysprice['z3'],2)); ?></td>
     </tr>
     <tr>
    	<td><strong><?php echo($acct_company->z4_descr); ?></strong></td>
        <td><?php 
		$field = array(
        	'name'        => 'z4_py_unts',
            'id'          => 'z4_py_unts',
			'class'       => 'textfield',
            'value'       => $account->z4_py_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo($acct_company->z4_price); ?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z4_nw_unts',
            'id'          => 'z4_nw_unts',
			'class'       => 'textfield',
            'value'       => $account->z4_nw_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z4_tr_unts',
            'id'          => 'z4_tr_unts',
			'class'       => 'textfield',
            'value'       => $account->z4_tr_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z4_dt_unts',
            'id'          => 'z4_dt_unts',
			'class'       => 'textfield',
            'value'       => $account->z4_dt_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo(number_format($acct_totalunits['z4'],4)); ?></td>
        <td class="rightalign">$<?php echo(number_format($acct_todaysprice['z4'],2)); ?></td>
     </tr>
     <tr>
    	<td><strong><?php echo($acct_company->z5_descr); ?></strong></td>
        <td><?php 
		$field = array(
        	'name'        => 'z5_py_unts',
            'id'          => 'z5_py_unts',
			'class'       => 'textfield',
            'value'       => $account->z5_py_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo($acct_company->z5_price); ?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z5_nw_unts',
            'id'          => 'z5_nw_unts',
			'class'       => 'textfield',
            'value'       => $account->z5_nw_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z5_tr_unts',
            'id'          => 'z5_tr_unts',
			'class'       => 'textfield',
            'value'       => $account->z5_tr_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z5_dt_unts',
            'id'          => 'z5_dt_unts',
			'class'       => 'textfield',
            'value'       => $account->z5_dt_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo(number_format($acct_totalunits['z5'],4)); ?></td>
        <td class="rightalign">$<?php echo(number_format($acct_todaysprice['z5'],2)); ?></td>
     </tr>
     <tr>
    	<td><strong><?php echo($acct_company->z6_descr); ?></strong></td>
        <td><?php 
		$field = array(
        	'name'        => 'z6_py_unts',
            'id'          => 'z6_py_unts',
			'class'       => 'textfield',
            'value'       => $account->z6_py_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo($acct_company->z6_price); ?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z6_nw_unts',
            'id'          => 'z6_nw_unts',
			'class'       => 'textfield',
            'value'       => $account->z7_nw_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z6_tr_unts',
            'id'          => 'z6_tr_unts',
			'class'       => 'textfield',
            'value'       => $account->z6_tr_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z6_dt_unts',
            'id'          => 'z6_dt_unts',
			'class'       => 'textfield',
            'value'       => $account->z6_dt_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo(number_format($acct_totalunits['z6'],4)); ?></td>
        <td class="rightalign">$<?php echo(number_format($acct_todaysprice['z6'],2)); ?></td>
     </tr>
     <tr>
    	<td><strong><?php echo($acct_company->z7_descr); ?></strong></td>
        <td><?php 
		$field = array(
        	'name'        => 'z7_py_unts',
            'id'          => 'z7_py_unts',
			'class'       => 'textfield',
            'value'       => $account->z7_py_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo($acct_company->z7_price); ?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z7_nw_unts',
            'id'          => 'z7_nw_unts',
			'class'       => 'textfield',
            'value'       => $account->z7_nw_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z7_tr_unts',
            'id'          => 'z7_tr_unts',
			'class'       => 'textfield',
            'value'       => $account->z7_tr_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z7_dt_unts',
            'id'          => 'z7_dt_unts',
			'class'       => 'textfield',
            'value'       => $account->z7_dt_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo(number_format($acct_totalunits['z7'],4)); ?></td>
        <td class="rightalign">$<?php echo(number_format($acct_todaysprice['z7'],2)); ?></td>
     </tr>
     <tr>
    	<td><strong><?php echo($acct_company->z8_descr); ?></strong></td>
        <td><?php 
		$field = array(
        	'name'        => 'z8_py_unts',
            'id'          => 'z8_py_unts',
			'class'       => 'textfield',
            'value'       => $account->z8_py_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo($acct_company->z8_price); ?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z8_nw_unts',
            'id'          => 'z8_nw_unts',
			'class'       => 'textfield',
            'value'       => $account->z8_nw_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z8_tr_unts',
            'id'          => 'z8_tr_unts',
			'class'       => 'textfield',
            'value'       => $account->z8_tr_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z8_dt_unts',
            'id'          => 'z8_dt_unts',
			'class'       => 'textfield',
            'value'       => $account->z8_dt_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo(number_format($acct_totalunits['z8'],4)); ?></td>
        <td class="rightalign">$<?php echo(number_format($acct_todaysprice['z8'],2)); ?></td>
     </tr>
     <tr>
    	<td><strong><?php echo($acct_company->z9_descr); ?></strong></td>
        <td><?php 
		$field = array(
        	'name'        => 'z9_py_unts',
            'id'          => 'z9_py_unts',
			'class'       => 'textfield',
            'value'       => $account->z9_py_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo($acct_company->z9_price); ?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z9_nw_unts',
            'id'          => 'z9_nw_unts',
			'class'       => 'textfield',
            'value'       => $account->z9_nw_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z9_tr_unts',
            'id'          => 'z9_tr_unts',
			'class'       => 'textfield',
            'value'       => $account->z9_tr_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php 
		$field = array(
        	'name'        => 'z9_dt_unts',
            'id'          => 'z9_dt_unts',
			'class'       => 'textfield',
            'value'       => $account->z9_dt_unts,
            'maxlength'   => '50'
        );
		echo form_input($field);
		?></td>
        <td><?php echo(number_format($acct_totalunits['z9'],4)); ?></td>
        <td class="rightalign">$<?php echo(number_format($acct_todaysprice['z9'],2)); ?></td>
     </tr>
     
    <tr>
    	<td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><strong>TOTAL</strong></td>
        <td class="rightalign">$<?php echo(number_format($acct_totalprice,2)); ?></td>
    </tr>
</table>
<?php echo form_hidden('action', 'edit_account'); ?>
<?php echo form_submit('submitbt', 'Save'); ?>
<?php echo form_close(); ?>
<?php //print_r($acct_company); ?>
<?php //print_r($account); ?>