<div id="header">
  <div id="logo">
    <h1><a href="<?php echo site_url(); ?>">ACA Prudent Investors</a></h1>
  </div>
  <div id="search">
    <?php 
$form_attributes = array('class' => 'searchform', 'id' => 'form_search');
echo form_open(current_url(),$form_attributes); 
?>
      <ul>
        <li class="searchfld">
          <?php 
		$field = array(
        	'name'        => 'search',
            'id'          => 'searchfld',
			'class'       => 'textfield',
            'value'       => '',
            'maxlength'   => '50'
        );
		echo form_input($field);
		?>
        </li>
        <li class="submit">
    	<?php echo form_hidden('action', 'search'); ?>
    	<?php echo form_submit('submitbt', 'Search'); ?>
    </li>
      </ul>
    </form>
  </div>
</div>
<div id="navigation">
  <?php 
	function makemenu($m){
		$out = "<ul>";
		foreach($m as $i){
			$class = "";
			if($i['link'] == "system/coming_soon"){
				$class = "comingsoon";
			}
			$out .= "<li class='".$i['name']." ".$class."'>";
			if(!empty($i['link'])){
				$link = $i['link'];
				$target = "";
				if(strstr($link,"http")){
					$target = " target = '_blank' ";
				}else{
					$link = site_url($link);
				}
				$out .= "<a href='".$link."' ".$target.">";
			}
			$out .= $i['title'];
			if(!empty($i['link'])){
				$out .= "</a>";
			}
			if(isset($i['children'])){
				$out .= makemenu($i['children']);
			}
			$out .= "</li>\n";
		}
		$out .= '<div class="clearline">&nbsp;</div>';
		$out .= '</ul>';
		return $out;
	}
	echo makemenu($menu);
	?>
</div>
