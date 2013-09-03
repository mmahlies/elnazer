<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home</title>
<link type="text/css" rel="stylesheet" media="all" href="http://wathba.dx.am/CI/application/views/website/styles/styles.css" />
<script src="http://wathba.dx.am/CI/application/views/website/js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="http://wathba.dx.am/CI/application/views/website/js/lavalamp.js" type="text/javascript"></script>
<script type = "text/javascript">
function pravo(uID)
{
$.getJSON("http://wathba.dx.am/CI/index.php/father/pravo/"+uID,function(result){});
alert('Pravo Sent To your kid.....'); 
window.location='http://wathba.dx.am/CI/index.php/father/viewSon/54';
}
</script>
<style type="text/css">
<!--

#prfoile_pic{
border:2px solid ;
width:700px;
background-color:#EFFBF8;
font-size:28px;
height : 800px;
text-align:center;
}


body {
	background-color: #D7E2DF;
	margin: 0;
	padding: 0;
	color: #000;
.jpg);
	background-attachment: fixed;
	font-family: "Comic Sans MS", cursive;
	font-size: 100%;
	line-height: 1.4;
}

/* ~~ Element/tag selectors ~~ */
ul, ol, dl { /* Due to variations between browsers, it's best practices to zero padding and margin on lists. For consistency, you can either specify the amounts you want here, or on the list items (LI, DT, DD) they contain. Remember that what you do here will cascade to the .nav list unless you write a more specific selector. */
	padding: 0;
	margin: 0;
}
h1, h2, h3, h4, h5, h6, p {
	margin-top: 0;	 /* removing the top margin gets around an issue where margins can escape from their containing div. The remaining bottom margin will hold it away from any elements that follow. */
	padding-right: 15px;
	padding-left: 15px; /* adding the padding to the sides of the elements within the divs, instead of the divs themselves, gets rid of any box model math. A nested div with side padding can also be used as an alternate method. */
}
a img { /* this selector removes the default blue border displayed in some browsers around an image when it is surrounded by a link */
	border: none;
}
/* ~~ Styling for your site's links must remain in this order - including the group of selectors that create the hover effect. ~~ */
a:link {
	color: #42413C;
	text-decoration: underline; /* unless you style your links to look extremely unique, it's best to provide underlines for quick visual identification */
}
a:visited {
	color: #6E6C64;
	text-decoration: underline;
}
a:hover, a:active, a:focus { /* this group of selectors will give a keyboard navigator the same hover experience as the person using a mouse. */
	text-decoration: none;
}

/* ~~ this fixed width container surrounds the other divs ~~ */
.container {
	width: 1000px;
	background: #FFF;
	margin: 0 auto; /* the auto value on the sides, coupled with the width, centers the layout */
}

/* ~~ the header is not given a width. It will extend the full width of your layout. It contains an image placeholder that should be replaced with your own linked logo ~~ */
.header {
	background: #ADB96E;
}

/* ~~ This is the layout information. ~~ 

1) Padding is only placed on the top and/or bottom of the div. The elements within this div have padding on their sides. This saves you from any "box model math". Keep in mind, if you add any side padding or border to the div itself, it will be added to the width you define to create the *total* width. You may also choose to remove the padding on the element in the div and place a second div within it with no width and the padding necessary for your design.

*/

.content {
	padding: 10px 0;
	color: #D10686;
	background-color: #F1DBA1;
}
.input{
	padding: 40px 15px;
}
/* ~~ The footer ~~ */
.footer {
	background-color: #CCC49F;
	height: 120px;
	width: 1000px;
	padding-top: 10px;
	padding-right: 0;
	padding-bottom: 10px;
	padding-left: 0;
}

/* ~~ miscellaneous float/clear classes ~~ */
.fltrt {  /* this class can be used to float an element right in your page. The floated element must precede the element it should be next to on the page. */
	float: right;
	margin-left: 8px;
}
.fltlft { /* this class can be used to float an element left in your page. The floated element must precede the element it should be next to on the page. */
	float: left;
	margin-right: 8px;
}
.clearfloat { /* this class can be placed on a <br /> or empty div as the final element following the last floated div (within the #container) if the #footer is removed or taken out of the #container */
	clear:both;
	height:0;
	font-size: 1px;
	line-height: 0px;

}

.footerphoto{
	width:150px;
	height:150px;
	margin-top: -25px;
	margin-right: 0px;
	margin-bottom: 20px;
	margin-left: 420px;
}
.follow{
	font-family: "Comic Sans MS", cursive;
	color: #570244;
	margin-left: 410px;
}
.all{
	font-family: "Comic Sans MS", cursive;
	color: #570244;
	margin-top: -140px;
	margin-left: 360px;
}
.search{
	margin-top: 40px;
	margin-left: 750px;
}


-->
</style>

<link href="http://wathba.dx.am/CI/application/views/website/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="http://wathba.dx.am/CI/application/views/website/css/thickbox.css" rel="stylesheet" type="text/css" />
</head>

<body>
<center>
<div id="prfoile_pic">
<pre>
<a href="http://wathba.dx.am/CI/index.php/elnazer/editProfilePicture">
<?php
if(file_exists("./profile_pictures/$uID.jpg"))
echo "<img src ='http://wathba.dx.am/CI/profile_pictures/$uID.jpg' width='100px' height='200px' alt='change'>";
else
echo "<img src ='http://wathba.dx.am/CI/profile_pictures/default_male.jpg' width='100px' height='200px' alt='change'>";	
?>
</a>
Student : <?php echo $name;?>
<hr/>
Knowledge : <?echo $account['knowledge'];?>
<br/><br/>
Balance  : <?echo $account['balance'];?>
<br/><br/>
Health   : <?echo $account['health'];?> 
<br/>
Satisfication : <?echo $account['satisfication'];?>
<br/><br/><br/>
<input type="submit" name="pravo" value="Pravo Dear" onclick="pravo(54)" style="background-color:#9BA3A0;width:200px;height:50px;">
</pre>
</div>
  
</center>  


</body>
</html>