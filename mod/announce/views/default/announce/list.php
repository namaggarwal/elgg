<?php
$html = "";
$html .= '<div id="ann-cont">';
if (isadminloggedin()){

	$html .='<a id="ann-create" href="'.$CONFIG->url.'pg/announce/create">Make an announcement</a>';	
}
$html .= '<div id="ann-list-cont">';
if(is_array($vars['ann']) && count($vars['ann'])!=0){	
	foreach ($vars['ann'] as $guid => $det) {

		$html .= '<a href="'.$det["LINK"].'" class="ann-list">';
		$html .= '<div>'.$det["TITLE"].'<span class="annDesc"> - '.$det["DESC"].'</span></div>';
		$html .= '<div class="annDate">Posted on '.date("D, d M Y h:i:s a",$det["DATE"]).'</div>';
		$html .= '</a>';

	}
}else{

	
	$html .= '<div class="ann-list no-ann">No announcement found</div>';
	


}
$html .= '</div>';
$html .= '</div>';
print $html;

?>