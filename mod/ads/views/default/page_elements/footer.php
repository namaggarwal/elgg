  <?php

  //Ad link retrieval code here

  // $ads = get_entities("object","ads");
  // $advert = array();
  //     if(is_array($news)){
  //       foreach ($news as $key => $value) {
  //         $advert[$value->guid] = array();
  //         $advert[$value->guid]["GUID"] =   $value->guid;
  //         $advert[$value->guid]["TITLE"]  =   $value->title;
  //         $advert[$value->guid]["DESC"] =   $value->description;
  //         $advert[$value->guid]["DATE"] =   $value->time_created;
  //         $advert[$value->guid]["TARGETLINK"] =   $value->targetlink;
  //         $advert[$value->guid]["LINK"] = $CONFIG->url.get_metadata_byname($value->guid,"permLink")->value;
  //       }

  //     $selectedLink = array_rand($advert);
  //     print($selectedLink["LINK"]);
    
  ?>


  <div class="clearfloat"></div>

  <!--ADVERTISEMENT CODE-->
  <iframe id="myIframe" style="border:0;" sandbox="allow-same-origin" src="http://matthewjamestaylor.com/responsive-ads/ad.html"  height="60" width="100%">
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
                                
                                <td class="link"><a href="#" target="_self">About</a></td>
                                <td class="link"><a href="#" target="_self">Terms</a></td>
                                <td class="link"><a href="#" target="_self">Privacy</a></td>
  							                <td class="link"><a href="#" target="_self">Contact</a></td>
                                <td class="link"><a href="#" target="_self">Sitemap</a></td>
                                
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
  </body>
  </html>