<!-- This Script is from www.phpfreecpde.com, Coded by: Kerixa Inc-->


<head>
<style type="text/css">
@import url('main.css');
</style>
</head>


<?php

	$host="localhost"; // Host name
	$username="root"; // Mysql username
	$password=""; // Mysql password
	
$link=mysql_connect($host, $username, $password);
if(!$link) die('
<p style="text-align: center;	font-size: 20pt;"><span style="color: #FF0000;">Failed to connect to the database! </span>
<br><span style="font-size: 12pt;">&gt;&gt;Please check the parameters and database server&lt;&lt;</span></p>
');

$db_name="myforum"; 
$result=mysql_select_db($db_name);
if(!$result){
forumsetup();
}
$tbl_name="forum_topics";
$sql="SELECT * FROM $tbl_name ORDER BY id DESC";
$result=mysql_query($sql,$link);

if (!isset($_GET['type'])) {
		echo "<table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"1\" bgcolor=\"#CCCCCC\"><tr><td width=\"6%\" align=\"center\" bgcolor=\"#E6E6E6\"><strong>#</strong></td><td width=\"53%\" align=\"center\" bgcolor=\"#E6E6E6\"><strong>Topic</strong></td><td width=\"15%\" align=\"center\" bgcolor=\"#E6E6E6\"><strong>Views</strong></td><td width=\"13%\" align=\"center\" bgcolor=\"#E6E6E6\"><strong>Replies</strong></td><td width=\"13%\" align=\"center\" bgcolor=\"#E6E6E6\"><strong>Date/Time</strong></td></tr>";
		$cn=1;
		while($rows=mysql_fetch_array($result)){ // Start looping table row 
			echo "<tr><td bgcolor=\"#FFFFFF\">".$rows['id']."</td><td bgcolor=\"#FFFFFF\"><a href=\"?type=view&id=".$rows['id']."\">".$rows['topic']."</a><BR></td><td align=\"center\" bgcolor=\"#FFFFFF\">".$rows['view']."</td><td align=\"center\" bgcolor=\"#FFFFFF\">".$rows['reply']."</td><td align=\"center\" bgcolor=\"#FFFFFF\">".$rows['datetime']."</td></tr>";
			$cn=$cn+1;
		}
		echo "<tr><td colspan=\"5\" align=\"right\" bgcolor=\"#E6E6E6\"><a href=\"?type=create&id=$cn\"><strong>Create New Topic</strong> </a></td></tr></table>";
}elseif (isset($_GET['type']) && $_GET['type']=='create'){
		echo('
		<table width="400" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC"><tr><form id="form1" name="form1" method="post" action="'.$_SERVER['PHP_SELF'].'?type=post"><td><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF"><tr><td colspan="3" bgcolor="#E6E6E6"><strong>Create New Topic</strong> </td></tr><tr><td width="14%">
					<strong>ID</strong></td><td width=":</td><td width="84%">
					:</td><td><input name="ID" type="text" size="50" value="'.$_GET['id'].'"/></td></tr><tr><td width="14%"><strong>Topic</strong></td><td width="2%">:</td><td width="84%"><input name="topic" type="text" id="topic" size="50" /></td></tr><tr><td valign="top"><strong>Detail</strong></td><td valign="top">:</td><td><textarea name="detail" cols="50" rows="3" id="detail"></textarea></td></tr><tr><td><strong>Name</strong></td><td>:</td><td><input name="name" type="text" id="name" size="50" /></td></tr><tr><td><strong>Email</strong></td><td>:</td><td><input name="email" type="text" id="email" size="50" /></td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td><input type="submit" name="Submit" value="Submit" /> <input type="reset" name="Submit2" value="Reset" /></td></tr></table></td></form></tr></table>
		');
}elseif (isset($_GET['type']) && $_GET['type'] == "post"){
		$id=$_POST['ID'];
		$topic=$_POST['topic'];
		$detail=$_POST['detail'];
		$name=$_POST['name'];
		$email=$_POST['email'];
		$datetime=date("d/m/y h:i:s"); //create date time
		$sql="INSERT INTO $tbl_name(id,topic, detail, name, email, datetime)VALUES('$id','$topic', '$detail', '$name', '$email', '$datetime')";
		$result=mysql_query($sql);
		if($result){
			echo '<p style="color: #008000;	text-align: center;	font-size: 15pt;"">Your Post is Added successfully!
					<br><a href='.$_SERVER["PHP_SELF"].'>Return to the Forum</a></p>';
		}else {
			echo "Error Posting.";
		}
}elseif (isset($_GET['type']) && $_GET['type'] == 'view') {
		// get value of id that sent from address bar
		$id=$_GET['id'];
		$sql="SELECT * FROM $tbl_name WHERE id='$id'";
		$result=mysql_query($sql);
		$rows=mysql_fetch_array($result);
		
		echo "<table width=\"400\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCCC\"><tr><td><table width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\" bordercolor=\"1\" bgcolor=\"#FFFFFF\"><tr><td bgcolor=\"#F8F7F1\"><strong>".$rows['topic']."</strong></td></tr><tr><td bgcolor=\"#F8F7F1\">".$rows['detail']."</td></tr><tr><td bgcolor=\"#F8F7F1\"><strong>By :</strong> ".$rows['name']." <strong>Email : </strong>".$rows['email']."</td></tr><tr><td bgcolor=\"#F8F7F1\"><strong>Date/time : </strong>".$rows['datetime']."</td></tr></table></td></tr></table><BR>";
		$tbl_name2="forum_replies"; // Switch to replies table
		$sql2="SELECT * FROM $tbl_name2 WHERE thread_id='$id'";
		$result2=mysql_query($sql2);
		while($rows=mysql_fetch_array($result2)){
			echo "<table width=\"400\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCCC\"><tr><td><table width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\" bgcolor=\"#FFFFFF\"><tr><td bgcolor=\"#F8F7F1\"><strong>ID</strong></td><td bgcolor=\"#F8F7F1\">:</td><td bgcolor=\"#F8F7F1\">".$rows['a_id']."</td></tr><tr><td width=\"18%\" bgcolor=\"#F8F7F1\"><strong>Name</strong></td><td width=\"5%\" bgcolor=\"#F8F7F1\">:</td><td width=\"77%\" bgcolor=\"#F8F7F1\">".$rows['a_name']."</td></tr><tr><td bgcolor=\"#F8F7F1\"><strong>Email</strong></td><td bgcolor=\"#F8F7F1\">:</td><td bgcolor=\"#F8F7F1\">".$rows['a_email']."</td></tr><tr><td bgcolor=\"#F8F7F1\"><strong>Answer</strong></td><td bgcolor=\"#F8F7F1\">:</td><td bgcolor=\"#F8F7F1\">".$rows['a_answer']."</td></tr><tr><td bgcolor=\"#F8F7F1\"><strong>Date/Time</strong></td><td bgcolor=\"#F8F7F1\">:</td><td bgcolor=\"#F8F7F1\">".$rows['a_datetime']."</td></tr></table></td></tr></table><br>";
		}
		$sql3="SELECT view FROM $tbl_name WHERE id='$id'";
		$result3=mysql_query($sql3);
		$rows=mysql_fetch_array($result3);
		$view=$rows['view'];
		// if have no counter value set counter = 1
		if(empty($view)){
			$view=1;
			$sql4="INSERT INTO $tbl_name(view) VALUES('$view') WHERE id='$id'";
			$result4=mysql_query($sql4);
		}
		// count more value
		$addview=$view+1;
		$sql5="update $tbl_name set view='$addview' WHERE id='$id'";
		$result5=mysql_query($sql5);
		echo "<BR><table width=\"400\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCCC\"><tr><form name=\"form1\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."?type=reply\"><td><table width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\" bgcolor=\"#FFFFFF\"><tr><td width=\"18%\"><strong>Name</strong></td><td width=\"3%\">:</td><td width=\"79%\"><input name=\"a_name\" type=\"text\" id=\"a_name\" size=\"45\"></td></tr><tr><td><strong>Email</strong></td><td>:</td><td><input name=\"a_email\" type=\"text\" id=\"a_email\" size=\"45\"></td></tr><tr><td valign=\"top\"><strong>Answer</strong></td><td valign=\"top\">:</td><td><textarea name=\"a_answer\" cols=\"45\" rows=\"3\" id=\"a_answer\"></textarea></td></tr><tr><td>&nbsp;</td><td><input name=\"id\" type=\"hidden\" value=\"".$id."\"></td><td><input type=\"submit\" name=\"Submit\" value=\"Submit\"> <input type=\"reset\" name=\"Submit2\" value=\"Reset\"></td></tr></table></td></form></tr></table>";

}elseif (isset($_GET['type']) && $_GET['type'] == "reply") {
		// Get value of id that sent from hidden field
		$id=$_POST['id'];
		// Find highest answer number.
		$sql="SELECT MAX(a_id) AS Maxa_id FROM forum_replies WHERE thread_id='$id'";
		$result=mysql_query($sql);
		$rows=mysql_fetch_array($result);
		// add + 1 to highest answer number and keep it in variable name "$Max_id". if there no answer yet set it = 1
		if ($rows) {
			$Max_id = $rows['Maxa_id']+1;
		}else {
			$Max_id = 1;
		}
		// get values that sent from form
		$a_name=$_POST['a_name'];
		$a_email=$_POST['a_email'];
		$a_answer=$_POST['a_answer'];
		$datetime=date("d/m/y H:i:s"); // create date and time
		// Insert answer
		$sql2="INSERT INTO forum_replies(thread_id, a_id, a_name, a_email, a_answer, a_datetime)VALUES('$id', '$Max_id', '$a_name', '$a_email', '$a_answer', '$datetime')";
		$result2=mysql_query($sql2);
		if($result2){
			echo '<p style="color: #008000;	text-align: center;	font-size: 15pt;"">Your Post is Added successfully!
					<br><a href='.$_SERVER["PHP_SELF"].'>Return to the Forum</a></p>';
			// If added new answer, add value +1 in reply column
			$tbl_name2="forum_topics";
			$sql3="UPDATE $tbl_name2 SET reply='$Max_id' WHERE id='$id'";
			$result3=mysql_query($sql3);
			$tbl_name2="forum_question";
			$sql3="UPDATE $tbl_name2 SET reply='$Max_id' WHERE id='$id'";
			$result3=mysql_query($sql3);

		}else {
			echo "ERROR";
		}

}



function forumsetup(){
echo('
<p style="color: #008000;	text-align: left;	font-size: 15pt;"">-Automatic setup is started...</p>
');
global $host,$username,$password,$link;
//$link=mysql_connect($host, $username, $password);
$sql= 'CREATE DATABASE myforum';
if (!mysql_query ($sql, $link)) die('
<p style="text-align: center;	font-size: 20pt;"><span style="color: #FF0000;">Failed to 
create database! </span><br><span style="font-size: 12pt;">&gt;&gt;Please check the parameters and database server&lt;&lt;</span></p>
');
$sql = "CREATE TABLE `myforum`.`forum_topics` (
`id` TEXT NOT NULL ,
`topic` TEXT NOT NULL ,
`detail` LONGTEXT NOT NULL ,
`name` TEXT NOT NULL ,
`email` TEXT NOT NULL ,
`datetime` TEXT NOT NULL ,
`view` TEXT NOT NULL ,
`reply` TEXT NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";

$sql2 = "CREATE TABLE `myforum`.`forum_replies` (
`thread_id` TEXT NOT NULL ,
`a_id` TEXT NOT NULL ,
`a_name` TEXT NOT NULL ,
`a_email` TEXT NOT NULL ,
`a_answer` LONGTEXT NOT NULL ,
`a_datetime` TEXT NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";
mysql_query($sql) or die('Setup Failed');
mysql_query($sql2)or die('Setup Failed');
echo('
<p style="color: #008000;	text-align: left;	font-size: 15pt;"">-Automatic setup completed successfully. Your forum is ready!</p>
');

}

?>
<body class="dark-theme">

<br>