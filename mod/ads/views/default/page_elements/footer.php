    <?php

    //Ad link retrieval code here

    $ads = get_entities("object","advertisement");
      if(is_array($ads)){
          foreach ($ads as $key => $value) {
            $advert[$value->guid] = array();
            $advert[$value->guid]["GUID"] =   $value->guid;
            $advert[$value->guid]["TITLE"]  =   $value->title;
            $advert[$value->guid]["DESC"] =   $value->description;
            $advert[$value->guid]["DATE"] =   $value->date;
            $advert[$value->guid]["LINK"] = get_metadata_byname($value->guid,"link")->value;
          }
        }

      $selectedLink = "http://matthewjamestaylor.com/responsive-ads/ad.html";
      $newlink = $advert[array_rand($advert)]["LINK"];
      if(!empty($newlink)){
        $selectedLink = $newlink;
      }

    ?>


    <div class="clearfloat"></div>

    <!--ADVERTISEMENT CODE-->
      <iframe id="myIframe" style="border:0;" sandbox="allow-same-origin allow-scripts allow-popups" src=<?php echo $selectedLink ?> height="60" width="100%">
      </iframe>
    <!--END ADVERTISEMENT CODE-->
  <br><br>
    <div id="layout_footer" style="padding-right:50px;">
    <table align="center" cellpadding="0" cellspacing="0" class="footContainer">
    	<tr>
          	<!--Site name and/or copy right statement-->
    		<td class="left"><b>&#169; THE NORMANTON NETWORK PVT. LTD.</b></td>
                
          	<!--End Site name and/or copy right statement-->
                
    		<td class="right">
                
                	 <table align="right" cellpadding="0" cellspacing="0" class="footerLinks" style="border:none;">
                      <tr>
                            
                    <!--Footer Links // Modify these links as you need-->
                          
                                <td class="alink"><a class="link" name="about" href="#" target="_self">About</a></td>
                                <td class="alink"><a class="link" name="terms" href="#" target="_self">Terms</a></td>
                                <td class="alink"><a class="link" name="privacy" href="#" target="_self">Privacy</a></td>
                                <td class="alink"><a class="link" name="contact" href="#" target="_self">Contact</a></td>
                                <td class="alink"><a class="link" name="sitemap" href="#" target="_self">Sitemap</a></td>
                                
                    <!--End Footer Links-->
                            
                </tr>
                    </table>
                      
                </td>
    	</tr>
    </table>
    </div><!-- /#layout_footer -->

    <div class="clearfloat"></div>

    </div><!-- /#page_wrapper -->
    </div><!-- /#page_container -->
  <!--   <!-- insert an analytics view to be extended -->
    <?php
    	echo elgg_view('footer/analytics');
    ?> -->
    <script type="text/javascript">

  $('.link').click(function(){
  var file = $(this).attr("name");
    window.open("http://localhost/elgg/mod/ads/views/default/showlinks.php?file="+file+".html","_self","toolbar=yes, scrollbars=yes, resizable=yes, top=200, left=200, width=400, height=400");
  });
    
  </script>
  </body>

</html>