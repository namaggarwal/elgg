<?php
	
	gatekeeper();	
?>
<div id="ann-form-cont">
	<form action="<?php echo $vars['url']; ?>action/announce/send" method="post"  name="announceForm">
		<div class="inpCont">
			<div class="inptext">Title</div>
			<div class="inpval">
				<input type="text" id="ann-title" name="ann_title" value="<?php echo $_SERVER["ann_title"]; ?>">
			</div>
		</div>
		<div class="inpCont">
			<div class="inptext">Description</div>
			<div class="inpval">
				<input type="text" id="ann-desc" name="ann_desc">
			</div>
		</div>
		<div class="inpCont">
			<div class="inptext">Content</div>
			<div class="inpval">
				<textarea id="ann-content" name="ann_content"></textarea>
			</div>
		</div>
		<input type="submit" value="Announce"></input>
	</form>
</div>