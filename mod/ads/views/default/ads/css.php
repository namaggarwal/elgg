<?php

?>



#adpreview{
	border: black 1px solid;
	padding-top: 5px;	
}



/*

CSS - MyFooter

*/

table.footContainer {
	width: 100%;
      border: none;
      height: 90px;
	font-family: Tahoma, "Lucida Console", Arial;
	font-size: 11px;
	color: #000000;
}

table.footContainer td.left {
	text-align:left; 
      vertical-align:middle; 
      padding-right:50px;
}

table.footContainer td.right {
	text-align:right; 
      vertical-align:middle; 
}

table.footerLinks {
	border: none;
	font-family: Tahoma, "Lucida Console", Arial;
	font-size: 11px;
	color: #000000;
}

table.footerLinks td {
	padding: 0px 8px 0px 8px;
}


table.footerLinks td a:link {
	color: #000000;
	text-decoration: none;
}

table.footerLinks td a:visited {
	color: #000000;
	text-decoration: none;
}

table.footerLinks td a:hover {
	color: #000000;
	text-decoration: underline;
}

table.footerLinks td a:visited:hover {
	color: #000000;
	text-decoration: underline;
}	


/* Form Button */

.formnext-btn, .preview-btn {
	-moz-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	-webkit-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #79bbff), color-stop(1, #378de5) );
	background:-moz-linear-gradient( center top, #79bbff 5%, #378de5 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#79bbff', endColorstr='#378de5');
	background-color:#79bbff;
	-webkit-border-top-left-radius:4px;
	-moz-border-radius-topleft:4px;
	border-top-left-radius:4px;
	-webkit-border-top-right-radius:4px;
	-moz-border-radius-topright:4px;
	border-top-right-radius:4px;
	-webkit-border-bottom-right-radius:4px;
	-moz-border-radius-bottomright:4px;
	border-bottom-right-radius:4px;
	-webkit-border-bottom-left-radius:4px;
	-moz-border-radius-bottomleft:4px;
	border-bottom-left-radius:4px;
	text-indent:-3px;
	border:1px solid #84bbf3;
	display:inline-block;
	color:#ffffff;
	font-family:Trebuchet MS;
	text-decoration: none;
	font-size:12px;
	font-weight:normal;
	font-style:normal;
	height:30px;
	line-height:30px;
	width:100px;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #528ecc;
	
}


.formnext-btn:hover, .preview-btn:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #378de5), color-stop(1, #79bbff) );
	background:-moz-linear-gradient( center top, #378de5 5%, #79bbff 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff');
	background-color:#378de5;
	text-decoration:none;
	color: white;
}

.formnext-btn:active, .preview-btn:active {
	position:relative;
	top:1px;
}