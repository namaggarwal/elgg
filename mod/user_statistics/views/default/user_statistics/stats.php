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
			$button = elgg_view("input/submit", array("internalname"=>"submitButton", "value"=>elgg_echo("Reset statistics"), "js" => "OnClick='return confirm(\"" . elgg_echo("user_statistics:stats:confirm") . "\");'"));
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
	    <div id="mapStat" style="height:300px;width:600px">
	    	<img src="#" id="mapimage"/>
	    	
	    </div>
	  	</td></tr></table>
	</div>


<div class="contentWrapper user_settings">
    <h3><?php echo elgg_echo("Your top 3 most visited blog posts"); ?></h3>
    <table><tr><td style='vertical-align:middle;' width=100%>
    	<ul>
    <?php $blogs = get_entities("object","blog",get_loggedin_user()->getGUID());
    	$comments=array();
    	$loop=0;
    	foreach ($blogs as $value) {
			
			$comments[$loop]=array();
			$comments[$loop]['Title']=$value->title;
			$comments[$loop]['Description']=$value->description;
			$comments[$loop++]['Count']=$bcount=elgg_count_comments($value);;
			
		}
		function compareOrder($a, $b)
		{
		  return $a['Count'] - $b['Count'];
		}

		usort($comments, 'compareOrder');
	$cnt=count($comments);
	if($cnt>0){
		$break=0;
		for($i=$cnt-1;$i>=0;$i--){
			if($break==3)
				break;
			print "<li>Title : \"<b>".$comments[$i]['Title']."</b>\"";
			print "<br/>Number of Comments : ".$comments[$i]['Count']."</li><br/>";
			$break++;
		}
	}else{
		print "Insufficient Information. You need to write blogs to get the statistics.";
	}
   
    ?>
</ul>
  </td><td style='vertical-align:middle;'>
	
	</td></tr></table>
</div>

<div class="contentWrapper user_settings">
    <h3><?php echo elgg_echo("Your message statistics"); ?></h3>
    <table><tr><td style='vertical-align:middle;' width="100%">
    	
    	
    	<div id="msgmap"></div>
    	
  </td><td style='vertical-align:middle;'>
	
	</td></tr></table>
</div>
<script type='text/javascript' src='https://www.google.com/jsapi'></script>
<script type="text/javascript">
	
	$(document).ready(function(){
	

		createGraphs();

	});	

	var cntryData;

	function createGraphs(){


			$.ajax({

				url:"<?php print $CONFIG->url?>/pg/user_statistics/getstat",
				type:"GET",
				success:function(data){
					
					data = $.parseJSON(data);
					cntryData = data["COUNTRY"];
					$('div#view_count').html("Your profile has been viewed :<b> " +(data['VIEWS']==null?0:data['VIEWS'])+" </b>time(s)<br/><br/>");
					
					var profData= data['PROFILE'];
					
					var xCat = [];
					var yData = [];
					for(var i in profData){

						xCat.push(profData[i]["DATE"]);
						yData.push(profData[i]["COUNT"]);

					}
					var xVal = JSON.parse("[" + data['INBOX'] + "]");
					var yVal = JSON.parse("[" + data['OUTBOX'] + "]");
					$('#viewsStat').highcharts({
		            chart: {
		                type: 'column'
		            },
		            title: {
		                text: 'Profile Views - Last 5 days'
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

					  $('#msgmap').highcharts({
			            title: {
			                text: 'Your Message Statistics',
			                x: -20 //center
			            },
			            subtitle: {
			                text: 'Inbox vs Outbox',
			                x: -20
			            },
			            xAxis: {
			                categories: ['This Month','Last Week','This Week','Today']
			            },
			            yAxis: {
			                title: {
			                    text: 'Messages Count'
			                },
			                plotLines: [{
			                    value: 0,
			                    width: 1,
			                    color: '#808080'
			                }]
			            },
			            legend: {
			                layout: 'vertical',
			                align: 'right',
			                verticalAlign: 'middle',
			                borderWidth: 0
			            },
			            series: [{
			                name: 'Sent Items',
			                data: yVal
			            }, {
			                name: 'Received Items',
			                data: xVal
			            }]
			        });


					//Map
				 setTimeout(function(){ 
				        google.load("visualization", "1",{'packages':['geochart'],"callback" : drawRegionsMap });   
				  }, 1); 
			     //google.setOnLoadCallback(drawRegionsMap);

			     
				},
				error:function(err){

					console.log(err);
				}

			});

			
    
	}


	 function drawRegionsMap() {

	 	//cntryData;

	 	var mydata = [];
	 	mydata.push(['Country','Views']);
	 	for(var i in cntryData){
	 		mydata.push([i,cntryData[i]]);
	 	}
        var data = google.visualization.arrayToDataTable(mydata);

        var options = {};

        var chart = new google.visualization.GeoChart(document.getElementById('mapStat'));
        chart.draw(data, options);
	}
			    

</script>