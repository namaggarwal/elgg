<?php
	global $CONFIG;
	header('Content-Type: application/rss+xml; charset=ISO-8859-1');
	//header('Content-type: text/xml');	

	$html .= '<?xml version="1.0" encoding="utf-8"?>';
	$html .= '<rss version="2.0">';
	$html .= '<channel>';
	$html .= '<title>NUSocial</title>';
	$html .= '<link>'.$CONFIG->url.'</link>';
	$html .= '<description>Connecting students.</description>';

	
	if(is_array($vars['ann']) && count($vars['ann'])!=0){	
		foreach ($vars['ann'] as $guid => $det) {
			
			$html .= "<item>";
			$html .= "<title>".$det["TITLE"]."</title>";
			$html .= "<link>".$det["LINK"]."</link>";
			$html .= "<guid>".$det["LINK"]."</guid>";
			$html .= "<pubDate>".date("D, d M Y H:i:s \G\M\T",$det["DATE"])."</pubDate>";
			$html .= "<description>".$base_url.$det["DESC"]."</description>";
			$html .= "</item>";

		}
	}

	$html .= '</channel>';
	$html .= '</rss>';
	
	echo $html;	

