<script src="<?php print $CONFIG->url ?>mod/tagging/views/default/object/jquery.lightbox_me.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="<?php print $CONFIG->url ?>mod/tagging/views/default/object/styles.css" type="text/css" media="screen" title="no title" charset="utf-8">


<?php


	global $CONFIG;
	
	$file = $vars['entity'];
	
	$file_guid = $file->getGUID();
	$tags = $file->tags;
	$title = $file->title;
	$desc = $file->description;
	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = friendly_time($vars['entity']->time_created);
	$visitor_id=get_loggedin_user()->getGUID();
	$owner_id=$vars['entity']->getOwnerEntity()->getGUID();
	
	$mime = $file->mimetype;
	
	if (get_context() == "search") { 	// Start search listing version 
		
		if (get_input('search_viewtype') == "gallery") {
			echo "<div class=\"filerepo_gallery_item\">";
			if ($vars['entity']->smallthumb) {
				echo "<p class=\"filerepo_title\">" . $file->title . "</p>";
				echo "<p><a href=\"{$file->getURL()}\"><img src=\"{$vars['url']}mod/file/thumbnail.php?size=small&file_guid={$vars['entity']->getGUID()}\" border=\"0\" /></a></p>";
				echo "<p class=\"filerepo_timestamp\"><small><a href=\"{$vars['url']}pg/file/{$owner->username}\">{$owner->username}</a> {$friendlytime}</small></p>";

				//get the number of comments
				$numcomments = elgg_count_comments($vars['entity']);
				if ($numcomments)
					echo "<p class=\"filerepo_comments\"><a href=\"{$file->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a></p>";

				
				//if the user can edit, display edit and delete links
				if ($file->canEdit()) {
					echo "<div class=\"filerepo_controls\"><p>";
					echo "<a href=\"{$vars['url']}mod/file/edit.php?file_guid={$file->getGUID()}\">" . elgg_echo('edit') . "</a>&nbsp;";
					echo elgg_view('output/confirmlink',array(
						
							'href' => $vars['url'] . "action/file/delete?file=" . $file->getGUID(),
							'text' => elgg_echo("delete"),
							'confirm' => elgg_echo("file:delete:confirm"),
						
						));
					echo "</p></div>";
				}
					
			
			} else {
				echo "<p class=\"filerepo_title\">{$title}</p>";
				echo "<a href=\"{$file->getURL()}\">" . elgg_view("file/icon", array("mimetype" => $mime, 'thumbnail' => $file->thumbnail, 'file_guid' => $file_guid, 'size' => 'large')) . "</a>";
				echo "<p class=\"filerepo_timestamp\"><small><a href=\"{$vars['url']}pg/file/{$owner->username}\">{$owner->name}</a> {$friendlytime}</small></p>";
				//get the number of comments
				$numcomments = elgg_count_comments($file);
				if ($numcomments)
					echo "<p class=\"filerepo_comments\"><a href=\"{$file->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a></p>";


			}
			echo "</div>";
			// echo elgg_view("search/gallery",array('info' => $info, 'icon' => $icon));
			
		} else {
		
			$info = "<p> <a href=\"{$file->getURL()}\">{$title}</a></p>";
			$info .= "<p class=\"owner_timestamp\"><a href=\"{$vars['url']}pg/file/{$owner->username}\">{$owner->name}</a> {$friendlytime}";
			$numcomments = elgg_count_comments($file);
			if ($numcomments)
				$info .= ", <a href=\"{$file->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a>";
			$info .= "</p>";
			
			// $icon = elgg_view("profile/icon",array('entity' => $owner, 'size' => 'small'));
			$icon = "<a href=\"{$file->getURL()}\">" . elgg_view("file/icon", array("mimetype" => $mime, 'thumbnail' => $file->thumbnail, 'file_guid' => $file_guid, 'size' => 'small')) . "</a>";
			
			echo elgg_view_listing($icon, $info);
		
		}
		
	} else {							// Start main version
	
?>
	<div class="filerepo_file">
		<div class="filerepo_icon">
					<a href="<?php echo $vars['url']; ?>action/file/download?file_guid=<?php echo $file_guid; ?>"><?php 
						
						echo elgg_view("file/icon", array("mimetype" => $mime, 'thumbnail' => $file->thumbnail, 'file_guid' => $file_guid)); 
						
					?></a>					
		</div>
		
		<div class="filerepo_title_owner_wrapper">
		<?php
			//get the user and a link to their gallery
			$user_gallery = $vars['url'] . "mod/file/search.php?md_type=simpletype&subtype=file&tag=image&owner_guid=" . $owner->guid . "&search_viewtype=gallery";
		?>
		<div class="filerepo_user_gallery_link"><a href="<?php echo $user_gallery; ?>"><?php echo sprintf(elgg_echo("file:user:gallery"),''); ?></a></div>
		<div class="filerepo_title"><h2><a href="<?php echo $file->getURL(); ?>"><?php echo $title; ?></a></h2></div>
		<div class="filerepo_owner">
				<?php

					echo elgg_view("profile/icon",array('entity' => $owner, 'size' => 'tiny'));
				
				?>
				<p class="filerepo_owner_details"><b><a href="<?php echo $vars['url']; ?>pg/file/<?php echo $owner->username; ?>"><?php echo $owner->name; ?></a></b><br />
				<small><?php echo $friendlytime; ?></small></p>
		</div>
		</div>

		
		<div class="filerepo_maincontent">
		
				<div class="filerepo_description"><?php echo elgg_view('output/longtext', array('value' => $desc)); ?></div>
				<div class="filerepo_tags">
<?php

		if (!empty($tags)) {

?>
		<div class="object_tag_string"><?php

					echo elgg_view('output/tags',array('value' => $tags));
				
				?></div>
<?php
		}

		$categories = elgg_view('categories/view',$vars);
		if (!empty($categories)) {
?>
		<div class="filerepo_categories">
			<?php

				echo $categories;
			
			?>
		</div>
<?php
		}

?>
				</div>
		<?php 
			if (elgg_view_exists('file/specialcontent/' . $mime)) {
				echo "<div class=\"filerepo_specialcontent\">".elgg_view('file/specialcontent/' . $mime, $vars)."</div>";
			} else if (elgg_view_exists("file/specialcontent/" . substr($mime,0,strpos($mime,'/')) . "/default")) {
				echo "<div class=\"filerepo_specialcontent\">".elgg_view("file/specialcontent/" . substr($mime,0,strpos($mime,'/')) . "/default", $vars)."</div>";
			}
		
		?>
		
		<div class="filerepo_download"><p><a href="<?php echo $vars['url']; ?>action/file/download?file_guid=<?php echo $file_guid; ?>"><?php echo elgg_echo("file:download"); ?></a></p></div>
		<?php if($visitor_id== $owner_id){ ?>
		<div class="filerepo_download"><a href="#" id="try-1">Tag my friends</a></div>
		<?php } ?>
		<div id="sign_up" class="Tag_friends" style="display:none">
			   <h2>Select your friends to be Tagged</h2>
				<form id="tag_form" name="tag_form" action="/elgg/action/file/tag" method="POST">
		
      
            <option value=""></option>
            
           <?php 
           $friends = get_entities_from_relationship('friend', $owner->getGUID(), false, 'user', '', 0, 'time_created desc', 1000);
			$arr=$file->friendtags;
			if($arr)
				$arr = explode(",",$arr);
			else
				$arr = array();
			
			if ($friends && is_array($arr)) {
				foreach($friends as $friend) {
					if(!(in_array($friend->guid,$arr))){
						print "<input type ='checkbox' name='gids[]' value='".$friend->guid."'/>".$friend->name."<br/>";
					}else{
						print "<input type ='checkbox' name='gids[]' value='".$friend->guid."' checked/>".$friend->name."<br/>";
					}
			}
			}
			
			?>
		  
		  <input type='hidden' name="fid" value="<?php echo $file->getGUID();?>"/>
		  <input type="submit" value="Tag Friends" /> 
      </form>
     </div>
  
 <br/> <div class="filerepo_controls"><h3>Friends Tagged :</h3> <br/>
		            <?php
		            $frnds=$file->friendtags;
					
					if(isset($frnds)){
						$frnds = explode(",",$frnds);
						foreach($frnds as $key => $val){
							$usr=get_user($val);
							print "<a href='".$vars['url']."pg/profile/".$usr->username."'><img src='".$usr->getIcon('small')."'/> ".$usr->name."</a>&nbsp;&nbsp;&nbsp;";
						}
					}else{
						print "The file owner hasn't tagged yet !!!";
					}
		         print "</div>";   
	if ($file->canEdit()) {
?>

	<div class="filerepo_controls">
				<p>
					<a href="<?php echo $vars['url']; ?>mod/file/edit.php?file_guid=<?php echo $file->getGUID(); ?>"><?php echo elgg_echo('edit'); ?></a>&nbsp; 
					<?php 
						echo elgg_view('output/confirmlink',array(
						
							'href' => $vars['url'] . "action/file/delete?file=" . $file->getGUID(),
							'text' => elgg_echo("delete"),
							'confirm' => elgg_echo("file:delete:confirm"),
						
						));  
					?>
				</p>
	</div>

<?php		
	}

?>
	</div>
</div>

<?php
	
	if(!($visitor_id== $owner_id)){
		if ($vars['full']) {
			if(in_array($visitor_id,$frnds))
				echo elgg_view_comments($file);
				
		}
	}else{
		echo elgg_view_comments($file);
	}

?>

<?php

	}

?>

<script type="text/javascript" charset="utf-8">
        $(function() {
            function launch() {
                 $('.Tag_friends').lightbox_me({centered: true, onLoad: function() { $('#sign_up').find('input:first').focus()}});
            }
            
            $('#try-1').click(function(e) {
                $(".Tag_friends").lightbox_me({centered: true, preventScroll: true, onLoad: function() {
					$('.Tag_friends').show();
					$(".Tag_friends").find("input:first").focus();
				}});
				
                e.preventDefault();
            });
            
            
            $('table tr:nth-child(even)').addClass('stripe');
        });
</script>