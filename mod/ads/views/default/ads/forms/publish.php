<?php

	//gatekeeper();
?>



<div id="advertisementform">
	<form action="<?php echo $vars['url']; ?>action/ads/publishad" method="post"  name="adform">
		<div class="inpCont" id="ad-title">
			<div class="inptext">Title</div>
			<div class="inpval">
				<input type="text" class="ad-title" name="ad_title">
			</div>
		</div>
		<div class="inpCont" id="ad-description">
			<div class="inptext">Description</div>
			<div class="inpval">
				<input type="text" class="ad-description" name="ad_description">
			</div>
		</div>
		<div class="inpCont" id="ad-content">
			<div class="inptext">Content</div>
			<div class="inpval">
				<input type="text" class="ad-content" name="ad_content">
			</div>
		</div>
		<div class="inpCont" id="ad-budget">
			<div class="inptext">Your budget</div>
			<div class="inpval">
				<input type="text" class="ad-budget" name="ad_budget">&nbsp;<em>Your ad is charged $1 for 7 days</em>
			</div>
		</div>
		<div class="inpCont" id="ad-link" style="display:none">
			<div class="inptext">Link</div>
			<div class="inpval">
				<input type="text" class="ad-link" name="ad_link">
			</div>
		</div>
		<br>
		<a href="#" style="display:none" class="preview-btn">Preview </a>
		<br>
		<a href="#" class="formnext-btn">Next </a>
		<br>
		<input class="submit-btn" type="submit" style="display:none" value="Confirm and Publish"></input>
	</form>

</div>
<br><br><br>
	<div style="display:none" class="adpreviewtext">ADVERTISEMENT PREVIEW</div>
 	<iframe style="display:none" style="border:0;" id="ad-iframe" sandbox="allow-same-origin allow-scripts" seamless src="#"  height="60" width="100%">
 </iframe>

<script type="text/javascript">


	$('.ad-title').on("keyup", function(){
		$('.titlepreview').text($('.ad-title').val());
	});

	$('.ad-content').on("keyup", function(){
		$('.bodypreview').text($('.ad-content').val());
	});
	

	$('.ad-link').on("keyup", function(){
		$('.linkpreview').text($('.ad-link').val());
	});
	

	$('.formnext-btn').on('click', function(){
		$('#ad-link').show();
		$('#ad-title').hide();
		$('#ad-content').hide();
		$('#ad-budget').hide();
		$('#ad-description').hide();
		$('.preview-btn').show();
		$('.formnext-btn').hide();
	});


	$('.preview-btn').on("click",function(){
		var urlregex = /^(?:([A-Za-z]+):)?(\/{0,3})([0-9.\-A-Za-z]+)(?::(\d+))?(?:\/([^?#]*))?(?:\?([^#]*))?(?:#(.*))?$/;
		
		$('.adpreviewtext').show();
		$('#ad-iframe').show();
		$('.submit-btn').show();
		$('#ad-iframe').attr("src",$(".ad-link").val());
	});

</script>
