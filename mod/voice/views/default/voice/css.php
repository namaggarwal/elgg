<?php


?>	


a.voiceLink {
	color:white;
	text-decoration:none;
	padding:4px;
}

a.voiceLink:hover{
	background:#4690d6;
}

#remotesVideos{
	
}

#voice_window{
	position: fixed;
width: 50%;
height: 500px;
top: 0px;
bottom: 0px;
background: #EEE;
border: 1px solid #AAA;
margin: auto;
box-shadow: 2px 4px 2px 2px #AAA;
display:none;
}

#voice_calling{
	position: absolute;
	top: 0px;
	left: 0px;
	bottom: 0px;
	right: 0px;
	height: 100px;
	margin: auto;
	width: 20%;
	background: #EEE;
	border-radius: 4px;
	padding: 4px;
	text-align: center;
}

#btnVoice{
	margin-top:10px;
}

#btnVoice span{
	background: #0054a7;
	color: white;
	padding: 3px;
	margin: 4px;
	border-radius: 4px;
	cursor: pointer;
}

#voice_calling > div:first-child{
	
	margin-top:10%;
}

#vidCont{
	text-align: center;
	padding: 2%;
	position: relative;
}
#localVideo{
	position: absolute;
	height: 100px;
	top: 4%;
	left: 17%;
}
#voice_input_cont{	
	margin-top: 0%;
	padding: 5%;
	text-align: center;
}

#voice_myf{
	width: 50%;
	margin: auto;
	margin-top: 10px;
}
#voice_stop{
	display:none;
}

.font14{
	font-size:14px;
}

.font24{
	font-size:24px;
}

.colorRed{
	color:red;
}

.voice_f_name{
	background: #4690d6;
	display: inline-block;
	padding: 10px;
	margin-right: 8px;
	color: white;
	cursor: pointer;
	border-radius: 4px;
	font-size: 14px;
	margin-bottom: 10px;
}

.voice_f_name:hover{
	background:#23629e;
}