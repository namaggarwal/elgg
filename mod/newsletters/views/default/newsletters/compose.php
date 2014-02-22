<?php
	if(!isadminloggedin()){
		forward("pg/newsletters/list");
	}

?>

<div class="composeform">
<div id="newsloading" style="text-align:center;display:none;">Loading</div>
<form id="nlcompose">
	<div class="composelabel">Title</div>
	<input class = "form_input" type="text" id="news_title"><br><br>
	<div class="composelabel">Dispatch Date and Time</div>
	<input class = "form_input" type="datetime" id="news_date" placeholder="DD/MM/YYYY HH:MM:SS"><br><br>
	<div class="composelabel">Body</div><br>
	<textarea rows=10 cols=50 type="text" id="news_body"></textarea><br>
	<div class="composelabel">Newsletter Type</div>
        <input type="radio" id="news_type" name="news_type" value="Once" checked="checked">Once
	<input type="radio" id="news_type" name="news_type" value="Weekly">Weekly
        <input type="radio" id="news_type" name="news_type" value="Monthy">Monthly
        <input type="radio" id="news_type" name="news_type" value="Yearly">Yearly<br><br>

	<input type="button" value="Send" class="nlsave"/>
</form>
</div>


<script type="text/javascript">

//Dummy AJAX call on form submit to trigger real time notifications
//Set action in success and submit the form

$(document).ready(function(){


        $('.nlsave').on("click",onNewsLetterSubmit);

});
 function onNewsLetterSubmit(event) {
        //Get form data

        $("#nlcompose").hide();
        $("#newsloading").show();
        var newstitle = $('#news_title').val();
        var newsdate = $('#news_date').val();
        var newsbody = $('#news_body').val();
        var newstype = $('input[name=news_type]:checked' ).val();
	var urlpath= "<?php echo $vars['url']; ?>action/newsletters/dispatch";
                $.ajax({
                	url: urlpath,
                	type: "POST",
                	data: {"news_title":newstitle,"news_date":newsdate,"news_body":newsbody,"news_type":newstype},
                        success: function (data) {
                          window.location.replace("<?php print $CONFIG->url ?>"+"pg/newsletters");
                        },
                        error: function(xhr,code,data){
                        	console.log(xhr.msg, data);
                        }
                });
}

 </script>