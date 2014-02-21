<?php
	$page_owner = page_owner_entity();
	$myid=$page_owner->getGUID();
	$counter = get_entities("object","userstats");
	global $count;
	global $arrayCounter;
	global $todayCounter;
	global $yesterdayCounter;
	global $weekCounter;
	global $lweekCounter;
	global $monthCounter;
	global $locArray;
	$locArray=array();
	$todayCounter=0;
	$yesterdayCounter=0;
	$weekCounter=0;
	$lweekCounter=0;
	$monthCounter=0;
	
	$visitors = array();
	$count=0;
	$arrayCounter=0;

	/* Get number of profile visits, Recent Visitors and gather data to plot the profile visit graph*/

	if(is_array($counter)){
		foreach ($counter as $key => $value) {
			if($value->owner == $myid){
				$count+=1;
				
				$visitors[$arrayCounter]=$value->visitor;
				$locArray[$arrayCounter]=array($value->lat,$value->lat);
				$arrayCounter+=1;


				if($value->date > date('Y-m-d',strtotime("-7 days"))){
					$weekCounter+=1;
					
					if($value->date == date('Y-m-d',strtotime("-0 days"))){
						$todayCounter+=1;
					}else{
						if($value->date == date('Y-m-d',strtotime("-1 days"))){
						$yesterdayCounter+=1;

						}
					}
				}else if($value->date > date('Y-m-d',strtotime("-14 days"))){
						
						$lweekCounter+=1;
				}
				if($value->date > date('Y-m-d',strtotime("-30 days"))){
						$monthCounter+=1;
				}
			}
		}
		$visitors=array_unique($visitors);
	}



?>
	<script type="text/javascript" src="<?php print $CONFIG->url?>mod/user_statistics/js/highcharts.js"></script>
	<div class="contentWrapper user_settings">
    <h3><?php echo elgg_echo('user_statistics:stats:title'); ?></h3>
    <table><tr><td style='vertical-align:middle;' width=100%>
	<?php echo sprintf(elgg_echo('user_statistics:stats:currentcount'),$count);  ?>
	
	<?php
	if(!empty($visitors)){
		print "<br/><br/>Your recent Visitors are... <br/>";
		foreach ($visitors as $value) {
			$user=get_user($value);
			print "<img src='".$user->getIcon('small')."'/> ".$user->name;
		}
		print "<br/><br/><h3>Your profile view statistics </h3><br/>";
		echo "<br/>Today :".$todayCounter;
		echo "<br/>Yesterday :".$yesterdayCounter;
		echo "<br/>This Week :".$weekCounter;
		echo "<br/>Last Week :".$lweekCounter;
		echo "<br/>This Month :".$monthCounter;
		?>
 	
<?php }	if (isadminloggedin()){
	$button = elgg_view("input/submit", array("internalname"=>"submitButton", "value"=>elgg_echo("user_statistics:stats:reset"), "js" => "OnClick='return confirm(\"" . elgg_echo("user_statistics:stats:confirm") . "\");'"));
	$form = elgg_view("input/form", array("internalname" => "resetForm", "method" => "post", "action" => $vars['url'] . "action/user_statistics/reset", "body" => $button));
}?>
<div id="viewsStat"></div>
	
	</td><td style='vertical-align:middle;'>
	<?php echo $form; ?>
	</td></tr></table>
<?php 


?>
</div>

<div class="contentWrapper user_settings">
    <h3><?php echo elgg_echo("Your viewer's location"); ?></h3>
    <table><tr><td style='vertical-align:middle;' width="100%">
    	<div id="mapStat"></div>
  </td><td style='vertical-align:middle;'>
	
	</td></tr></table>
</div>


<div class="contentWrapper user_settings">
    <h3><?php echo elgg_echo("Your's most commented blog posts"); ?></h3>
    <table><tr><td style='vertical-align:middle;' width=100%>
    <?php $blogs = get_entities("object","blog",$myid);
    	foreach ($blogs as $value) {
			$bcount=elgg_count_comments($value);
			print $value->description." count of comments =".$bcount;
		}

    ?>
  </td><td style='vertical-align:middle;'>
	
	</td></tr></table>
</div>

<div class="contentWrapper user_settings">
    <h3><?php echo elgg_echo("Your message statistics"); ?></h3>
    <table><tr><td style='vertical-align:middle;' width="100%">

  </td><td style='vertical-align:middle;'>
	
	</td></tr></table>
</div>

<script type="text/javascript">

	$(document).ready(function(){


		createGraphs();

	});	


	function createGraphs(){


			$.ajax({

				url:"<?php print $CONFIG->url?>/pg/user_statistics/getstat",
				type:"GET",
				success:function(data){
					data = $.parseJSON(data);

					var profData= data['PROFILE'];
					var xCat = [];
					var yData = [];
					for(var i in profData){

						xCat.push(profData[i]["DATE"]);
						yData.push(profData[i]["COUNT"]);

					}

					$('#viewsStat').highcharts({
		            chart: {
		                type: 'column'
		            },
		            title: {
		                text: 'Last 5 days views'
		            },
		            xAxis: {
		                categories: xCat
		            },
		            yAxis: {
		                min: 0,
		                title: {
		                    text: 'Views'
		                }
		            },
		            series: [{
		                name: 'Profile Views',
		                data: yData
		    
		            }]
		        });
    

				},
				error:function(err){

					console.log(err);
				}

			});

			
    
	}
</script>