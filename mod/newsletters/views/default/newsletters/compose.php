<?php
	if(!isadminloggedin()){
		forward("pg/newsletters/list");
	}

?>

<div class="composeform">
<div id="newsloading" style="text-align:center;display:none;">Loading</div>
<form id="nlcompose">
	<div class="composelabel">Title</div>
	<input class = "form_input" type="text" id="news_title" required><br><br>
	<div class="composelabel">Dispatch Date and Time</div>
	<input class = "form_input" type="datetime" id="news_date" placeholder="DD/MM/YYYY HH:MM:SS"><br><br>
	<div class="composelabel">Body</div><br>
	<textarea rows=10 cols=50 type="text" id="news_body"></textarea><br>
	<div class="composelabel">Newsletter Type</div>
        <input type="radio" id="news_type" name="news_type" value="Once" checked="checked">Once
	    <input type="radio" id="news_type" name="news_type" value="Weekly">Weekly  
        <input type="radio" id="news_type" name="news_type" value="Monthy">Monthly
        <input type="radio" id="news_type" name="news_type" value="Yearly">Yearly<br><br>

	<input type="button" value="Send" class="nlsave"/> <div class="errorString"></div>
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

        var newstitle = $('#news_title').val();
        var newsdate = $('#news_date').val();
        var newsbody = $('#news_body').val();
        var newstype = $('input[name=news_type]:checked' ).val();


        if(newstitle=="" || newsdate=="" || newsbody=="" || newstype==""){
                $('.errorString').text("All fields are compulsary");
                return false;
        }
        datetimeregex = new RegExp (/^(0?[1-9]|[12][0-9]|3[01])[\/\-\.](0?[1-9]|1[012])[\/\-\.](\d{4})\s([0-9]|[0-1][0-9]|[2][0-3]):([0-5][0-9]):([0-5][0-9])$/);
        if (newsdate.match(datetimeregex)==null){
            $('.errorString').text("Invalid date time format. Should be DD-MM-YYYY HH:MM:SS");
            return false;
        }


        $("#nlcompose").hide();
        $("#newsloading").show();
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