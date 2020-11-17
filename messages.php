<?php
require_once 'header.php';
$user = $_SESSION['user'];
$d_id = null;
$msg = "";
$msgreciever = ""; 

date_default_timezone_set("America/Vancouver");

// set messages page based on d_id
if(isset($_GET['d_id'])) 
{
	$d_id = $_GET['d_id'];
}
else 
{
	header("Location: timeline.php");
}

// send a message
if(isset($_POST['msgreciever']))
{
	$msgreciever = $_POST['msgreciever'];
	$msg = $_POST['msg'];
	$msg = cleanup($msg);
	if($msgreciever == "")
	{
		echo "The reciever box cannot be empty";
	}
	 else if ($msg == "")
	{
		 echo "The message box cannot be empty";
	}
	else
	{
		$checkuser = runthis("SELECT * FROM Owner_Has_Dog WHERE d_id='$msgreciever'");
		if($checkuser->num_rows != 0)
		{
			$today = date("Y-m-d");
			runthis("INSERT INTO Dog_Has_Personal_Note VALUES('$msgreciever', '$today', '$d_id' , '$msg', DEFAULT)");
			echo "Message sent!";
		}
		else
		{
			echo "Dog $msgreciever does not exist";
		}
	}
}

echo "<form method='post' action='messages.php?d_id=".$d_id."'>
To: <input type='text' name='msgreciever'><br>
Message: <input type='text' name='msg'><br>
<input type='submit' value='Send'>
</form>";
echo "<br>
 
<div class='wrapper'>
<div class='chatnames'></div>
<div class='chatcontainer'></div>
</div>";

	 // show dog's messages
	 echo "<table class='your_messages'>
 <tr>
	<th>From</th>
	<th>Message</th>
	<th>On</th>
 </tr>";

 	echo "Your Messages:<br><br></div>" ;
	$result = runthis("SELECT * FROM Dog_Has_Personal_Note WHERE d_id='$d_id'");

	while($row = $result->fetch_array(MYSQLI_ASSOC)) {
		echo "<tr>";
		$sender_id = $row["sender_id"];
		$message = $row["content"];
		$date = $row["since"];
		echo "<td>".$sender_id."</td>";
		echo "<td>".$message."</td>";
		echo "<td>".$date."</td>";
	}
	  
	  // show messages dog sent
	  echo "<table class='sent_messages'>
 <tr>
	<th>To</th>
	<th>Message</th>
	<th>On</th>
 </tr>";
      echo "<br>";
 	  echo "Sent Messages:<br><br></div>" ;

	  $result = runthis("SELECT * FROM Dog_Has_Personal_Note WHERE sender_id='$d_id'");

	  while($row = $result->fetch_array(MYSQLI_ASSOC)) 
	  {
		echo "<tr>";
		$d_id = $row["d_id"];
		$message = $row["content"];
		$date = $row["since"];
		echo "<td>".$d_id."</td>";
		echo "<td>".$message."</td>"; 
		echo "<td>".$date."</td>"; 
	  }
?>
<script>

$(document).ready(function() {
	$('.welcome-message').hide();
});
</script>
</body>
</html>