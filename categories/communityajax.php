
<table border="0" height="100%"  align="left" cellspacing="0" cellpadding="15" class="dir"><tr>

<?php
// Categories
$sql = "SELECT catid, catname AS catname FROM $t_cats WHERE catid = '5' $sortcatsql";
$rescats = mysql_query($sql) or die(mysql_error());
$catcount = @mysql_num_rows($rescats);
$percol_short = floor($catcount/$dir_cols);
$percol_long = $percol_short+1;
$longcols = $catcount%$dir_cols;
$i = 0;
$j = 0;
$col = 0;
$currentCount=0;
$currentCounterAbove10=0;
$catLimit=10;
$thiscolcats = 0;
while($rowcat=mysql_fetch_array($rescats))
{  
   
   $catlink = buildURL("ads", array($xcityid, $rowcat['catid'], $rowcat['catname'])); 
	$adcount = 0+$catadcounts[$rowcat['catid']];
?>

<?php $category_icon = file_exists("images/category/{$rowcat[catid]}.png") ?
"images/category/{$rowcat[catid]}.png" : "images/category.png"; ?>
<center>
      <div style="
	     background: none repeat scroll 0 0 rgba(49, 77, 94, 0);
    border: 1px solid rgba(14, 41, 57, 0.1);
    border-radius: 2px 2px 2px 2px;
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5) inset, 0 1px 0 rgba(255, 255, 255, 0.5);
    color: #455B67;
    display: block;


    opacity: 1;
    padding: 1px;
    text-align: center;
    text-decoration: none;
    text-shadow: 0 1px 0 rgba(255, 255, 255, 0.33);
	  
	  ">
<center>
<h2 >
<img style="padding-top:1px;min-height:30px;height:30px;cursor:pointer;width:auto;opacity:.8;" src="images/closedelete.png" align="left" style="line-height:30px;"onmouseover="this.src='images/closedeletehover.png'" onmouseout="this.src='images/closedelete.png'" />&nbsp;<a style="line-height:32px;color:#626263;padding-top:10px;font-family: 'Myriad Pro', Arial, Helvetica, sans-serif;" href="<?php echo $catlink; ?>"><?php echo $rowcat['catname']; ?></a>
<?php if($show_cat_adcount) { ?><a  style="font-family: 'Myriad Pro', Arial, Helvetica, sans-serif;font-size:12px;color:#959595;" class="aright"><span class="count"><?php echo $adcount; ?>&nbsp;ad's</span></a><?php } ?>	
</h2></center>

	</div>
	</div>

	
</div>
</div>
</div>
</th>
	</tr>
	<table class="mainpagecats2" border="0" cellspacing="3" cellpadding="1" width="100%" style="border-top:1px #CCCCCC;margin-top:15px">

<?php
	$sql = "SELECT scat.subcatid, scat.subcatname AS subcatname
	FROM $t_subcats scat
	WHERE scat.catid = $rowcat[catid]
		AND scat.enabled = '1'
	$sortsubcatsql";
	$ressubcats = mysql_query($sql) or die(mysql_error()."<br>$sql");
	$subcatcount = mysql_num_rows($ressubcats);
		
	while ($rowsubcat = mysql_fetch_array($ressubcats))
	{
	    	$currentCount++;
	    if ($shortcut_categories && $subcatcount == 1 
	            && $rowsubcat['subcatname'] == $rowcat['catname']) {
	        continue;
	    }
 	 		 	
		
		$adcount = 0+$subcatadcounts[$rowsubcat['subcatid']];      
        $subcat_url = buildURL("ads", array($xcityid, $rowcat['catid'], $rowcat['catname'], 
            $rowsubcat['subcatid'], $rowsubcat['subcatname']));
			?> 
	
	<center>
		
		<td border="0" cellspacing="4" cellpadding="2" style="letter-spacing: 0.007em;font-family: 'Myriad Pro Lite', Arial, Helvetica, sans-serif;position:relative;float:middle;font-size:14px;padding-left:10px;padding-right:10px;padding-top:10px;">
	


	</center>
		<?php 
		
		////look here
		if ($currentCount%5 ==0)
		{
		
		?>
			<a href="<?php echo $subcat_url; ?>"style="align:middle"> <?php echo $rowsubcat['subcatname']; ?></a>
		<?php if($show_subcat_adcount) { ?><span class="count">(<?php echo $adcount; ?>)</span><?php } 
	echo "<tr>";
		}else{
		?>
		<a href="<?php echo $subcat_url; ?>"style="align:middle"><?php echo $rowsubcat['subcatname']; ?></a>
		<?php if($show_subcat_adcount) { ?><span class="count">(<?php echo $adcount; ?>)</span><?php } 
	?>
			
		
<?php
	} //end my else
	}
	
	}
	
		
	
?>
<td>
<td style="height:20px;">
</td>
</td>

<?php 
?>

</table>
