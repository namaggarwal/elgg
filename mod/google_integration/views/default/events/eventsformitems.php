<?php


gatekeeper();

if(isset($_GET['code']))
	header('Location: http://'. $_SERVER['HTTP_HOST'].'/elgg/mod/google_integration/actions/add.php?code='.$_GET['code']);
else if(isset($_GET['url'])){
	//header('Location: '.$_GET['authUrl'].'&redirect_uri='.$_GET['redirect_uri'].'&client_id='.$_GET['client_id'].'&scope='.$_GET['scope'].'&access_type='.$_GET['access_type'].'&approval_prompt='.$_GET['approval_prompt']);
	header('Location: '. base64_decode($_GET['url']));
}
?>
<div class="contentWrapper notitle">
<p><label>
	<?php echo elgg_echo('Add an Event'); ?>
</label></p>	
	
	<form action="/elgg/action/google_integration/add" id="idForm" method="POST">
		<table border=0>
		<tr><td>Event Name<font color=red>*</font>    :</td><td> <input type="text" name="ename" required="true"/></td></tr>
		<tr><td>Event Start Date<font color=red>*</font>       : </td><td><input type="date" name="esdate" required="true"/></td></tr>
		<tr><td>Event End Date<font color=red>*</font>       : </td><td><input type="date" name="eedate" required="true"/></td></tr>
		<tr><td>Event Start Time<font color=red>*</font>        : </td><td><input type="time" name="estime" required="true"/></td></tr>
		<tr><td>Event end Time<font color=red>*</font>        : </td><td><input type="time" name="eetime" required="true"/></td></tr>
		<tr><td>Event Location<font color=red>*</font>    : </td><td><input type="text" name="eloc" required="true"/></td></tr>
		<tr><td>Event Description<font color=red>*</font> : </td><td><textarea  name="etext" required="true"></textarea></td></tr>
		<tr><td>Add to Google Calendar? :</td><td><input type="checkbox" name="ck" /></td></tr>
	</table>
</br>
	<p><i><font color=red>*</font> All fields are mandatory</i></br><p>
	<button type="submit" class="submit_button" value="Add Event"/>Add Event</button>
	</form>

	
</div>

<div class="contentWrapper notitle">
<p><label>
	<?php echo elgg_echo('View your Events'); //To write code to display the events submitted
	?>
	
</label></p>
<ul>
	<?php $ann = get_entities("object","googleevents");
					if(is_array($ann)){
						foreach ($ann as $key => $value) {
							print '<li>Event Name: '.$value->ename.'<br/>';
							print 'Event Location: '.$value->eloc.'<br/>';
							print 'Event Date: '.$value->esdate.' ('.$value->estime.') - '.$value->eedate.' ('.$value->eetime.')<br/>';
							print '<form method="POST" action="/elgg/action/google_integration/delete"><input type="hidden" value="'.$value->guid.'" name="guid"><input type="submit" class="submit_button" value="Delete this Event"/></form>';
						}	
					}
	?>
</ul>


</div>
