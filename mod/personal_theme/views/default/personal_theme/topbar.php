<?php	
		gatekeeper();
?>
	<ul class="topbardropdownmenu">
    <li class="drop"><a href="#" class="menuitemtools"><?php echo(elgg_echo('Themes')); ?></a>
	  <ul>
      <?php
  // theme name cannot have any spaces or special characters
  foreach ($CONFIG->themelist as $theme)
  {
    $theme_name = ucfirst(strtolower($theme));
    echo "<li><a href='#theme=${theme_name}' class='themes' data-value='${theme_name}'>${theme_name}</a></li>";  
  }
  ?>	
      </ul>
    </li>
</ul>

<!--Ajax call to the change_them action so that page does not reload-->

<script type="text/javascript">
  $(function() {

    //Script to display the theme selected by the user
    $(document).ready(function() {
      var loc=location.href.split("#theme=")[1];

      if(loc!=undefined){
      $('#overlay').html("Your theme has changed successfully to "+loc);
      $('#overlay').fadeIn('fast').delay(1000).fadeOut('fast');
      
    }
    },false);

    $('ul.topbardropdownmenu').elgg_topbardropdownmenu();
    $('.themes').click(changeTheme);
  });


  function changeTheme(){
    $.ajax({
      url:'/elgg/pg/personal_theme/change/'+$(this).attr("data-value"),
      type:'POST',
      success:function(data){
        $("head link[data-css=external]").remove();
         var cssLink = '<link href="'+data+'" data-css="external" type="text/css" rel="stylesheet" />';
         $('head').append(cssLink);
      },
      error:function(err,code,data){

        console.log(err,code,data);
      }
    });

  }
  window.addEventListener("hashchange", function (event){
      var loc=location.href.split("#theme=")[1];
      
      if(loc!=undefined){
      $('#overlay').html("Your theme has changed successfully to "+loc);
      $('#overlay').fadeIn('fast').delay(2000).fadeOut('fast');
      
    }
    },false);
</script>


<div id="overlay" style="display:none;position: absolute;background: white;color: black;margin-top: 4%;left: 70%;padding: 10px;border: 1px solid black;box-shadow:5px 5px 5px black;">

</div>	 

