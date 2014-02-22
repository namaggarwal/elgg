<?php

?>


.newsletterslink{	
	color:white;
	text-decoration:none;
	padding:4px;
}

.newsletterslink:hover{
	background: #4690d6;
	text-decoration:none;
	color: white;
}


.listentry {
	width: 75%;
	align : center;
	padding : 4px;
	margin-left: 20%;
}

.listentry h3 {
	padding: 7px 15px 15px 15px;
	margin-left: 65px; 
	font: bold 120%/100% Georgia,"Nimbus Roman No9 L",serif;
	border: none;
	cursor: pointer;
}

.listentry h3:hover {
	background-color: #e3e2e2;
}

.accordion h3.active {
	background-position: right 5px;
}


.listentry p {
	background: #f7f7f7;
	margin-left: 65px;
	padding: 10px 15px 20px;
	text-align:justify;
    font-family:Georgia,"Nimbus Roman No9 L",serif;
}

.no-news{
	text-align: center;
	color: blue;
	font-size : 2em;
}

/* Creating CSS button for CREATE NEWSLETTERS on list page */

.createnlbutton,.nlsave {
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
	font-size:14px;
	font-weight:normal;
	font-style:normal;
	height:40px;
	line-height:40px;
	width:156px;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #528ecc;
	margin-left: 2%;
}

.createnlbutton:hover, .nlsave:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #378de5), color-stop(1, #79bbff) );
	background:-moz-linear-gradient( center top, #378de5 5%, #79bbff 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff');
	background-color:#378de5;
	text-decoration:none;
	color: white;
}

.createnlbutton:active, .nlsave:active {
	position:relative;
	top:1px;
}


/* CSS for Create Newsletters form */

input,.composelabel{
	display : inline-block;
}


form {
	margin-left: 15px;	
}

.shownl{
	display: table;
	form-size: 100%;
	margin-left: 5%;
	padding-top: 5%;
}

.errorString{
	color: red;
	display: inline-block;
	padding-left: 10px;
	font-style: italic;
}