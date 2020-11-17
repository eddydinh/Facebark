<?php

require_once "header.php";
$d_id = null;
$profile_result = "";
$introduction = "";
$since = "";
$profile_id = null;

// Set profile page based on d_id
if(isset($_GET['d_id'])) 
{
	$d_id = $_GET['d_id'];
	$profile_result = runthis("SELECT * FROM Dog_Has_Profile_Page WHERE d_id='$d_id'");
    if($profile_result->num_rows == 0)
    {
        header("Location: timeline.php");
    }
    else
    {
            $row = $profile_result->fetch_array(MYSQLI_ASSOC);
            $introduction = $row['introduction'];
            $since = $row['since'];
            $profile_id = $row['profile_id'];
    }
	
}
else
{
	header("Location: timeline.php");
}

// Set Profile picture
if(isset($_FILES['profilepic']['name']) && $_FILES['profilepic']['name'] != "")
{
	$detectedType = exif_imagetype($_FILES['profilepic']['tmp_name']);
	$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
	if(in_array($detectedType, $allowedTypes))
	{
		move_uploaded_file($_FILES['profilepic']['tmp_name'], "./profilepic/$d_id.jpg");
	}
} else {
    if(isset($_POST['deleteprofilepic']) && $_POST['deleteprofilepic'] == 'doit') {
        if(file_exists("./profilepic/$d_id.jpg"))
        {  
            unlink("./profilepic/$d_id.jpg");
        }
    }
    
}

// Set posts
if(isset($_FILES['gallerypic']['name']) && $_FILES['gallerypic']['tmp_name'] != '')
{
	$detectedType = exif_imagetype($_FILES['gallerypic']['tmp_name']);
	$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
	if(in_array($detectedType, $allowedTypes))
	{
        $text = '';
        if(isset($_POST['caption'])) {
            $text = $_POST['caption'];
        }
        runthis("INSERT INTO Profile_Page_Contains_Post  VALUES(null,
        null,
        '$text', 
        0,
        '$profile_id')");
        $post_id = mysqli_insert_id($connection);
        $saveto = "pics/" . $post_id.".jpg";
		move_uploaded_file($_FILES['gallerypic']['tmp_name'], $saveto);

	}

}

// Delete posts
 if(isset($_POST['post_id_delete']) && $_POST['post_id_delete'] != '') {
    $post_id = $_POST['post_id_delete'];
    if(file_exists("./pics/$post_id.jpg"))
    {  
        unlink("./pics/$post_id.jpg");
    }
     runthis("DELETE FROM Profile_Page_Contains_Post WHERE post_id ='$post_id'");
}

// Edit posts

if(isset($_POST['post_id_edit']) && $_POST['post_id_edit'] != '') {
    $post_id = $_POST['post_id_edit'];
    $text = $_POST['post_edit_text'];
    runthis("UPDATE Profile_Page_Contains_Post SET text ='$text' WHERE post_id ='$post_id'");
}

// Insert comments

if(isset($_POST['add_comment_post_id']) && $_POST['add_comment_post_id'] != '') {
    $post_id = $_POST['add_comment_post_id'];
    $poster_id = $_POST['add_comment_poster_id'];
    $text = $_POST['add_comment_text'];
    $comment_date = date("Y-m-d H:i:s");
    runthis("INSERT INTO Post_Contains_Comment VALUES(
        '$comment_date',
        '$poster_id',
        '$text',
        0,
        '$comment_date',
        '$post_id'
    )");
}

//setup messaging button
echo "<td><a class='submitbutton' id='messagebutton' href='messages.php?d_id=".$d_id."'>Messages</a></td>";


echo "<div class='profilecontainer'>";
$date = new DateTime();
if(file_exists("./profilepic/$d_id.jpg"))
{   
	echo "<img class='profilepic' src='./profilepic/$d_id.jpg?".$date->getTimestamp()."'><br>";
} else {
    echo "<img class='profilepic' src='./profilepic/default.jpg'><br>";
}
echo "<form method='post' action='profile.php?d_id=".$d_id."' enctype='multipart/form-data'>
    <img id='changepicbutton' class='profilepicbutton' src='./img/camera.png'>
    <img id='droppicbutton' class='profilepicbutton' src='./img/x.png'>
    
    <input id='deleteprofilepic' type='hidden' name='deleteprofilepic' value=''>
    <input id='inputprofilepic' type='file' name='profilepic' style='display:none;'>
	<input id='submitprofilepic' type='submit' style='display:none;' value='Save'>
</form>";
echo $introduction;
echo " <hr><br>
 <br>
 <div id='postdiv'>
<form method='post' action='profile.php?d_id=".$d_id."' enctype='multipart/form-data'>
	Add a picture: <input type='file' name='gallerypic' size='14'>
    <br>
    <br>
    <input class='text_field' type='text' name='caption' placeholder='Write your caption here...'><br><br>
	<input class ='submitbutton' type='submit' value='POST'>
</form></div>";
echo "<br>";
echo "<br>";
echo "<div style='width: 400px; margin: 0px auto; text-align: left;'>My posts: </div>";

// Display posts
$posts_result = runthis("SELECT * FROM Profile_Page_Contains_Post WHERE profile_id='$profile_id'");
if($posts_result->num_rows == 0)
{
    echo"<div style='color:gray;'>Your profile has no post. Add some!</div>";
}
while($row = $posts_result->fetch_array(MYSQLI_ASSOC)) {
    $date = new DateTime();
    echo "<div class='post'>";
    $post_id= $row["post_id"];
    $caption = $row["text"];
    $num_likes = $row["num_likes"];
    if(file_exists("./pics/$post_id.jpg"))
    {   
        echo "<img class='postpic' src='./pics/$post_id.jpg?".$date->getTimestamp()."'>";
    } else {
        echo "<img class='postpic' src='./pics/defaultpost.jpg'>";
    }
    
    echo "<div class='underpostsection'>";
    echo "<form method='post' style='visibility:hidden; position:absolute;' action='profile.php?d_id=".$d_id."' enctype='multipart/form-data'>
         <input type='hidden' name='post_id_delete' value='".$post_id."'>
         <input id ='delete_post_submit_".$post_id."' type='submit'>
    </form>";
    echo "<div class='post_util'>";
    echo "<img onclick='editThis(".$post_id.")' src='./img/edit.png' width='30px'/>";
    echo "<img onclick='deleteThis(".$post_id.")' src='./img/garbage.png' width='30px'/>";
    echo "</div>";
    echo "<div id='caption".$post_id."'>Caption: ".$caption."</div>";
    echo "<form method='post' style='display:none;' id='form-caption".$post_id."' action='profile.php?d_id=".$d_id."' enctype='multipart/form-data'> 
            <input type='text' class ='text_field' name='post_edit_text' value='$caption'>
            <input type='hidden' name='post_id_edit' value='".$post_id."'>
            <input class ='submitbutton' type='submit' value='Save New Caption'>
            <button class ='submitbutton' onclick ='return closeThisEdit(".$post_id.")'>Close</button>
    </form>";
    echo "<br>";
    echo "<form method='post' action='profile.php?d_id=".$d_id."' enctype='multipart/form-data'> 
            <input class ='text_field' type='text' name='add_comment_text' placeholder='Enter comment here...'>
            <input type='hidden' name='add_comment_post_id' value='".$post_id."'>
            <input type='hidden' name='add_comment_poster_id' value='".$d_id."'>
            <input class ='submitbutton' type='submit' value='Post Comment'>
    </form>";
    echo "<br>";
    $comments = runthis("SELECT poster_id, text FROM Post_Contains_Comment WHERE post_id='$post_id' ORDER BY time_stamp");
    while($comment_row = $comments->fetch_array(MYSQLI_ASSOC)) {
        echo "<div><b>".$comment_row['poster_id']."</b>   ".$comment_row['text']."</div>";
    }
    echo "</div>";
    echo "</div>";
}
echo "</div><br><br>";
echo "<div style='position:relative; height:100%;'><div id='footer'>Profile created since ".$since."</div></div>";
?>
</body>
<script>
$(document).ready(function() {
	$('.welcome-message').hide();
});
$("#changepicbutton").click(function () {
    $("#inputprofilepic").click();
});
    
$("#droppicbutton").click(function () {
    $("#deleteprofilepic").val("doit");
    $("#submitprofilepic").click();
});
    
function deleteThis(post_id) {
    $("#delete_post_submit_"+post_id).click();
}
    
function editThis(post_id) {
    $("#caption"+post_id).hide();
     $("#form-caption"+post_id).show();
}
    
function closeThisEdit(post_id) {
     $("#form-caption"+post_id).hide();
    $("#caption"+post_id).show();
    
    return false;
}
    
    
$('#inputprofilepic').on("change", function(){  $("#submitprofilepic").click(); });


</script>
</html>
