<?php
	$page_owner = page_owner_entity();
	$myid=$page_owner->getGUID();
	/* Get number of profile visits, Recent Visitors and gather data to plot the profile visit graph*/

?>
	 <script type='text/javascript' src='https://www.google.com/jsapi'></script>
	<script type="text/javascript" src="<?php print $CONFIG->url?>mod/user_statistics/js/highcharts.js"></script>
	<div class="contentWrapper user_settings">
    <h3><?php echo elgg_echo('User Profile View Statistics'); ?></h3>
    <table><tr><td style='vertical-align:middle;' width=100%>
	<div id="view_count"></div> 
	 	
		<?php 	
		if (isadminloggedin()){
			$button = elgg_view("input/submit", array("internalname"=>"submitButton", "value"=>elgg_echo("user_statistics:stats:reset"), "js" => "OnClick='return confirm(\"" . elgg_echo("user_statistics:stats:confirm") . "\");'"));
			$form = elgg_view("input/form", array("internalname" => "resetForm", "method" => "post", "action" => $vars['url'] . "action/user_statistics/reset", "body" => $button));
		}
		?>

		</td><td style='vertical-align:middle;'>
		<?php echo $form; ?>
		</td></tr>
		<tr><td><div id="viewsStat"></div>
		<div id='viewers'></div>
			</td></tr>
		</table>

	
	</div>

	<div class="contentWrapper user_settings">
	    <h3><?php echo elgg_echo("Your viewer's locations"); ?></h3>
	    <table><tr><td style='vertical-align:middle;' width="100%">
	    <div id="mapStat">
	    	<img src="#" id="mapimage"/>
	    </div>
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
<script type='text/javascript' src='https://www.google.com/jsapi'></script>
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
					$('div#view_count').html("Your profile has been viewed :<b> " +(data['VIEWS']==null?0:data['VIEWS'])+" </b>time(s)<br/><br/>");
					var profCountry=data['COUNTRY'];
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



					//Map

				 google.load('visualization', '1', {'packages': ['geochart']});
			    // google.setOnLoadCallback(drawRegionsMap);

			     
				},
				error:function(err){

					console.log(err);
				}

			});

			
    
	}


	 function drawRegionsMap() {
			        var data = google.visualization.arrayToDataTable([
			          ['Country', 'Popularity'],
			          ['Germany', 200],
			          ['United States', 300],
			          ['Brazil', 400],
			          ['Canada', 500],
			          ['France', 600],
			          ['RU', 700]
			        ]);

			        var options = {};

			        var chart = new google.visualization.GeoChart(document.getElementById('mapStat'));
			        chart.draw(data, options);
			    }
			    

</script>