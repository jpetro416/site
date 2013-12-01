<?php




require_once("initvars.inc.php");
require_once("config.inc.php");


if ($xview == "main" || $show_sidebar_always) 
{
	$searchbox_on_top = 0;
	$field_sep = "<br><img src=\"images/spacer.gif\" height=\"2\" width=\"2\"><br>";
}
else
{
	$searchbox_on_top = 1;
	$field_sep = " &nbsp; ";
}



if($dir_sort) 
{
	$sortcatsql = "ORDER BY catname";
	$sortsubcatsql = "ORDER BY subcatname";
}
else
{
	$sortcatsql = "ORDER BY pos";
	$sortsubcatsql = "ORDER BY scat.pos";
}

?>
<form action="?" method="get">
<input type="hidden" name="cityid" value="<?php echo $xcityid; ?>">
<input type="hidden" name="lang" value="<?php echo $xlang; ?>">

<input name="search" type="text" style="height:20px;color:gray;" value=" ... Enter search terms here " size="<?php echo $searchbox_on_top?35:25; ?>" onFocus="clearText(this)">


<?php


if ($xsubcatid > 0 || $postable_category)


{

?>

	<?php
	
	if ($xsubcathasprice)
	{

	?>

		<?php echo $field_sep; ?>

		<?php echo $xsubcatpricelabel; ?>:
		<input type="text" name="pricemin" size="3"><?php echo $lang['SEARCH_TO']; ?> 
		<input type="text" name="pricemax" size="3">

	<?php

	}

	?>

	<?php

	foreach ($xsubcatfields as $fldnum=>$fld)
	{
		if($fld['SEARCHABLE'])
		{

	?>

		<?php echo $field_sep; ?>

		<?php echo $fld['NAME']; ?>: 

		<?php if ($fld['TYPE'] == 'N') { ?>

			<input type="text" name="x[<?php echo $fldnum; ?>][min]" size="3">
			<input type="text" name="x[<?php echo $fldnum; ?>][max]" size="3">

		<?php } else if ($fld['TYPE'] == "D") { ?>

			<select name="x[<?php echo $fldnum; ?>]">
			<option value="">- <?php echo $lang['ALL']; ?> -</option>
			<?php
			foreach ($fld['VALUES_A'] as $v)
			{
				echo "<option value=\"$v\">$v</option>";
			}
			?>
			</select>

		<?php } else { ?>

			<input type="text" name="x[<?php echo $fldnum; ?>]" size="10">

		<?php } ?>


	<?php

		}
	}

	?>

	<input type="hidden" name="view" value="ads">

	<?php if ($xsubcatid) { ?>
	<input type="hidden" name="subcatid" value="<?php echo $xsubcatid; ?>">
	<?php } else { ?>
	<input type="hidden" name="catid" value="<?php echo $xcatid; ?>">
	<?php } ?>

	
<?php

}

elseif ($xcatid > 0)
{
  
	
	$sql = "SELECT subcatid, subcatname AS subcatname
			FROM $t_subcats scat
			WHERE catid = $xcatid
				AND enabled = '1'
			$sortsubcatsql";

	$scatres = mysql_query($sql);
	$subcatcount = mysql_num_rows($scatres);
	$show_subcats = true;

	if ($shortcut_categories && $subcatcount == 1) {
	
	    // Check if the only subcat has got the same name as the cat.
	    $only_subcat = mysql_fetch_array($scatres);
	    if ($only_subcat['subcatname'] == $xcatname) {
	        $show_subcats = false;
	    }
	    
	    // Reset resultset pointer.
	    mysql_data_seek($scatres, 0);
	}
			    
    
?>
    
   
    <?php if ($show_subcats) { ?>

    	<?php echo $field_sep; ?>
    
    	<select name="subcatid">
    	<option value="0">- <?php echo $xcatname; ?> -</option>
    	<?php
    
    	while ($row=mysql_fetch_array($scatres))
    	{
    		echo "<option value=\"$row[subcatid]\">$row[subcatname]</option>\n";
    	}
    
    	?>
    	</select>
	
	<?php } ?>
	
	
	<input type="hidden" name="view" value="ads">
	<input type="hidden" name="catid" value="<?php echo $xcatid; ?>">

<?php

}

elseif ($xview == "events" || $xview == "showevent")
{

?>

	<select><option value="0">- <?php echo $xcatname; ?> -</option></select>
	<input type="hidden" name="view" value="events">


<?php

}

else
{

?>
	
	<?php echo $field_sep; ?>

	<select name="catid">
	<option value="0">- <?php echo $lang['ALL']; ?> -</option>
	<?php
	
	$sql = "SELECT catid, catname AS catname
			FROM $t_cats
			WHERE enabled = '1'
			$sortcatsql";

	$catres = mysql_query($sql);

	while ($row=mysql_fetch_array($catres))
	{
		echo "<option value=\"$row[catid]\">$row[catname]</option>\n";
	}

	?>
	<?php if($enable_calendar) { ?><option value="-1"><?php echo $lang['EVENTS']; ?></option><?php } ?>
	</select>
	<input type="hidden" name="view" value="ads">

<?php

}

?>

<?php 

if($xcityid>0 || $postable_country)
{
    $cityid = ($xcityid > 0 ? $xcityid : $child_city['cityid']);

?>

	<?php
	if($location_sort) $sort = "ORDER BY areaname";
    else $sort = "ORDER BY pos";
    
	$sql = "SELECT areaname FROM $t_areas WHERE cityid = $cityid $sort";

	$area_res = mysql_query($sql);
	if (mysql_num_rows($area_res))
	{
	?>

	<?php echo $field_sep; ?>
	<?php echo $lang['POST_LOCATION']; ?>:
	<select name="area">
	<option value="">- <?php echo $lang['ALL']; ?> -</option>

	<?php

		while($area_row = mysql_fetch_array($area_res))
		{
			echo "<option value=\"$area_row[areaname]\"";
			if ($_GET['area'] == $area_row['areaname']) echo " selected";
			echo ">$area_row[areaname]</option>";
		}

	?>

	</select>

	<?php 
	}
	?>

<?php 
}
?>

<button type="submit"><?php echo $lang['BUTTON_SEARCH']; ?></button>
</form>