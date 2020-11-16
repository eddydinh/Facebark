<?php
require_once 'header.php';
$user = $_SESSION['user'];
$d_id = null;
$msg = "";
$msgreciever = ""; 

// set messages page based on d_id
if(isset($_GET['d_id']))
{
	$d_id = $_GET['d_id'];
}
else
{
	//header("Location: timeline.php");
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
		echo "    dog $d_id";
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
?>

 <form method='post' action='messages.php'>
To: <input type='text' name='msgreciever'><br>
Message: <input type='text' name='msg'><br>
<input type='submit' value='Send'>
</form>
<br>
 
<div class='wrapper'>
<div class='chatnames'></div>
<div class='chatcontainer'></div>
</div>
<?php

	 // show dog's messages
	 echo "Your Messages:<br><br></div>" ;
	  $result = runthis("SELECT * FROM Dog_Has_Personal_Note WHERE d_id='$d_id'");

      $n = $result->num_rows;
      for($j = 0; $j < $n; $j = $j + 1)
      {
		$row = $result->fetch_array(MYSQLI_ASSOC);
      	echo "<div class='msg'>" . "From: " . $row['sender_id'] . "<br>" . " Message: " . $row['content'] . "<br><br></div>";
	  }
	  
	  // show messages dog sent
	  echo "Sent Messages:<br><br></div>" ;

	  $result = runthis("SELECT * FROM Dog_Has_Personal_Note WHERE sender_id='$d_id'");

      $n = $result->num_rows;
      for($j = 0; $j < $n; $j = $j + 1)
      {
      	$row = $result->fetch_array(MYSQLI_ASSOC);	 
		echo "<div class='msg'>" . "To: " . $row['d_id'] . "<br>" . " Message: " . $row['content'] . "<br><br></div>";
	  }

?>

</body>
</html>