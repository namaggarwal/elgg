<?php


?>

a.announcerss{
	background:url("<?php echo $vars['url']; ?>mod/announce/graphics/feed-icon.png") no-repeat;
	padding: 0 0 4px 16px;
	margin: 0 15px 0 0px;	
}

a.rssbig{
	padding-bottom:10px;
	margin-top:4px;
	margin-left:4px;
}

a.announceLink {
	color:white;
	text-decoration:none;
	padding:4px;
}

a.announceLink:hover{
	background:#4690d6;
}

#content_area_user_title{
	text-align:center;
	margin-top:2px;
}

#ann-create{
	background:#CCC;
	border-radius:4px;
	border:1px solid #CCC;
	padding:4px;
	cursor:pointer;
	text-decoration:none;
	margin-left:4px;
}

#ann-list-cont{	
	width:60%;
	margin:auto;
	margin-top:2%;
}

#ann-list-cont .ann-list{	
	background:#CCC;
	display:block;
	border-radius:4px;
	border:1px solid #CCC;
	padding:4px;
	margin-bottom:4px;
	cursor:pointer;
	text-decoration:none;
}

#ann-list-cont .ann-list:hover,#ann-create:hover{
	color:#4690d6;
	background:#BBB;
}

#ann-list-cont .annDesc,#ann-list-cont .annDate{
	color:black;
	font-size:10px;	
}

#ann-list-cont div.no-ann{
	cursor:default;
	text-align:center;
}

#ann-show-cont{
	width:96%;
	margin:auto;
}

#ann-show-cont .date{
	
	margin-top:2px;
}

#ann-show-cont .content{
	
	margin-top:2%;
}

#ann-show-cont .title{
	text-align:center;
	font-size:12px;
	margin-top:2px;
	color:#0054A7;
}

#ann-show-cont .subtitle{
	text-align:center;
	margin-top:2px;
	color:black;
	font-size:11px;
}

#ann-form-cont{
	width:90%;
	margin:auto;
	margin-top:4%;
}

#ann-form-cont .inpCont{
	margin-bottom:2px;
}

#ann-form-cont #ann-title{
	width:40%;
}

#ann-form-cont #ann-desc{
	width:60%;
}

#ann-form-cont #ann-content{
	width:80%;
	resize:none;
	height:100px;
}



