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
    echo "<li><a href='#' class='themes' data-value='${theme_name}'>${theme_name}</a></li>";  
  }
  ?>	
      </ul>
    </li>
</ul>

<!--Ajax call to the change_them action so that page does not reload-->

<script type="text/javascript">
  $(function() {
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

</script>


	 

