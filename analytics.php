<?php
require_once 'header.php';
$user_id = $_SESSION['user_id'];
?>
<script src='js/jquery.min.js'></script>
<script type="text/javascript">
	$(document).ready(function() {
	$('.welcome-message').hide();
});
</script>
<div style='margin-left:40px'>
<form method='post' action='analytics.php' enctype='multipart/form-data'>

<label>Display all dogs that I adopted</label>
    <select name='ba'>
  <option value="before or on" <?php if(isset($_POST['ba']) &&
                             $_POST['ba'] == 'before or on') {
                                echo 'selected="selected"';
                            }
                             ?>>before or on</option>
  <option value="after" <?php if(isset($_POST['ba']) &&
                             $_POST['ba'] == 'after') {
                                echo 'selected="selected"';
                            }
                             ?>>after</option>
</select>
<input class='text_field' type='date' name='selection_date' <?php if(isset($_POST['selection_date']) &&
                             $_POST['selection_date'] != '') {
                                echo 'value="'.$_POST['selection_date'].'"';
                            }
                             ?>>
<input class='text_field' type='hidden' name='selection'>
<input class='submitbutton' type='submit' value='Execute'>
</form>
<?php

// Selection statement executed
if(isset($_POST['selection']))
{
    echo "<table class='dog_profiles'>
<tr>
  <th>Adopted since</th>
   <th>Dog's user name</th>
    <th>Name</th>
    <th>Gender</th>
    <th>Breed</th>
    <th>Date of birth</th>
    <th>Profile</th>
</tr>";
    $date = $_POST['selection_date'];
    $ba = $_POST['ba'];
    $selection_query = "SELECT * FROM Owner_Has_Dog WHERE user_id='$user_id' AND since <= '$date'";
    if ($ba == "after") {
        $selection_query = "SELECT * FROM Owner_Has_Dog WHERE user_id='$user_id' AND since > '$date'";
    }
    $selection_results = runthis($selection_query);
    while($row = $selection_results->fetch_array(MYSQLI_ASSOC)) {
        echo "<tr>";
        $since = $row["since"];
        $d_id= $row["d_id"];
        $name = $row["name"];
        $gender = $row["gender"];
        $breed = $row["breed"];
        $dob = $row["DOB"];
        echo "<td>".$since."</td>";
        echo "<td>".$d_id."</td>";
        echo "<td>".$name."</td>";
        echo "<td>".$gender."</td>";
        echo "<td>".$breed."</td>";
        echo "<td>".$dob."</td>";
        echo "<td><a class='submitbutton' href='profile.php?d_id=".$d_id."'>Profile Page</a></td>";
        echo "</tr>";
    }
echo "</table>";
}
?>
<br>
<br>
<form method='post' action='analytics.php' enctype='multipart/form-data'>

<label>Display all groups participated by my dogs who are</label>
    <select name='age_ba'>
  <option value="older or equal" <?php if(isset($_POST['age_ba']) &&
                             $_POST['age_ba'] == 'older or equal') {
                                echo 'selected="selected"';
                            }
                             ?>>older than or equal to</option>
  <option value="younger" <?php if(isset($_POST['age_ba']) &&
                             $_POST['age_ba'] == 'younger') {
                                echo 'selected="selected"';
                            }
                             ?>>younger than</option>
</select>
<input type='number' name='join_age' min='0' max='100'<?php if(isset($_POST['join_age']) &&
                             $_POST['join_age'] != '') {
                                echo 'value="'.$_POST['join_age'].'"';
                            }
                             ?>>
<input class='text_field' type='hidden' name='join'>
<input class='submitbutton' type='submit' value='Execute'>
</form>

<?php 
// Join statement executed
if(isset($_POST['join']))
{ 
    echo "
<table class='dog_profiles'>
<tr>
    <th>Group Name</th>
    <th>Group Description</th>
    <th>Group Type</th>
    <th>Dog's user name</th>
    <th>Age</th>
    <th>Profile</th>
</tr>";
    $age = $_POST['join_age'];
    $age_ba = $_POST['age_ba'];
    
    // Date calculation equation suggested by: Bryan Denny - https://stackoverflow.com/questions/2533890/how-to-get-an-age-from-a-d-o-b-field-in-mysql
    $view_query = "CREATE OR REPLACE VIEW age_view AS SELECT  DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(d.DOB, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(d.DOB, '00-%m-%d')) AS age, d.d_id, d.user_id FROM Owner_Has_Dog d";
    runthis($view_query);
    
    $join_query = "SELECT g.group_name, g.group_description, gt.group_type, d.d_id, d.age 
    FROM age_view d 
    INNER JOIN Dog_Joins_Group dg 
        ON dg.d_id = d.d_id
    INNER JOIN  Owner_Manages_Group g
        ON g.group_id = dg.group_id
    Inner JOIN Group_Types gt
        ON g.group_type_id = gt.group_type_id
    WHERE d.user_id='$user_id' AND d.age >= '$age'";
    
    if ($age_ba == "younger") {
        $join_query = "SELECT g.group_name, g.group_description, gt.group_type, d.d_id, d.age 
        FROM age_view d 
        INNER JOIN Dog_Joins_Group dg 
            ON dg.d_id = d.d_id
        INNER JOIN  Owner_Manages_Group g
            ON g.group_id = dg.group_id
        Inner JOIN Group_Types gt
            ON g.group_type_id = gt.group_type_id
        WHERE d.user_id='$user_id' AND d.age < '$age'";
    }
    $join_results = runthis($join_query);
    while($row = $join_results->fetch_array(MYSQLI_ASSOC)) {
        echo "<tr>";
        $group_name = $row["group_name"];
        $group_description = $row["group_description"];
        $group_type = $row["group_type"];
        $d_id = $row["d_id"];
        $age = $row["age"];
        echo "<td>".$group_name."</td>";
        echo "<td>".$group_description."</td>";
        echo "<td>".$group_type."</td>";
        echo "<td>".$d_id."</td>";
        echo "<td>".$age."</td>";
        echo "<td><a class='submitbutton' href='profile.php?d_id=".$d_id."'>Profile Page</a></td>";
        echo "</tr>";
    }
echo "</table>";
} 
?>
<br>
<br>
<form method='post' action='analytics.php' enctype='multipart/form-data'>

<label>Display the dogs who made distinct comments that contain the word</label>
<input type='text' name='group_by_text' <?php if(isset($_POST['group_by_text']) &&
                             $_POST['group_by_text'] != '') {
                                echo 'value="'.$_POST['group_by_text'].'"';
                            }
                             ?>>
<input class='text_field' type='hidden' name='group_by'>
<input class='submitbutton' type='submit' value='Execute'>
</form>

<?php
    // Group by statement executed
    if(isset($_POST['group_by']))
    { 
        echo "
<table class='dog_profiles'>
<tr>
    <th>Dog's user name</th>
    <th>Number of comments made</th>
    <th>Profile</th>
</tr>";
        $word = $_POST['group_by_text'];
        $group_by_query = "SELECT poster_id, COUNT(distinct text) as numComments FROM Post_Contains_Comment WHERE text LIKE '%$word%' GROUP BY poster_id ORDER BY numComments DESC";
        $group_by_results = runthis($group_by_query);
        while($row = $group_by_results->fetch_array(MYSQLI_ASSOC)) {
        echo "<tr>";
        $d_id = $row["poster_id"];
        $num_comments = $row["numComments"];
        echo "<td>".$d_id."</td>";
        echo "<td>".$num_comments."</td>";
        echo "<td><a class='submitbutton' href='profile.php?d_id=".$d_id."'>Profile Page</a></td>";
        echo "</tr>";
    }
echo "</table>";
}

?>
<br>
<br>
<form method='post' action='analytics.php' enctype='multipart/form-data'>

<label>Display the owners who created
 <select name='having_ba'>
  <option value="more or equal" <?php if(isset($_POST['having_ba']) &&
                             $_POST['having_ba'] == 'more or equal') {
                                echo 'selected="selected"';
                            }
                             ?>>more than or as many as</option>
  <option value="less" <?php if(isset($_POST['having_ba']) &&
                             $_POST['having_ba'] == 'less') {
                                echo 'selected="selected"';
                            }
                             ?>>less than</option>
</select>
<input type='number' name='having_num_dogs' min='0' max='100'<?php if(isset($_POST['having_num_dogs']) &&
                             $_POST['having_num_dogs'] != '') {
                                echo 'value="'.$_POST['having_num_dogs'].'"';
                            }
                             ?>> dog profile(s) </label>
<input class='text_field' type='hidden' name='having'>
<input class='submitbutton' type='submit' value='Execute'>
</form>

<?php
    // Having statement executed
    if(isset($_POST['having']))
    { 
        echo "
<table class='dog_profiles'>
<tr>
    <th>Owner's user name</th>
    <th>Number of dog profiles</th>
</tr>";
        $numFrwends= $_POST['having_num_dogs'];
        $having_ba= $_POST['having_ba'];
        $having_query = "SELECT o.user_name, COUNT(*) as numDogs FROM Owner_Has_Dog od, Owner o WHERE o.user_id = od.user_id GROUP BY o.user_name HAVING numDogs >= '$numFrwends' ORDER BY numDogs";
        if ($having_ba == "less") {
             $having_query = "SELECT o.user_name, COUNT(*) as numDogs FROM Owner_Has_Dog od, Owner o WHERE o.user_id = od.user_id GROUP BY o.user_name HAVING numDogs < '$numFrwends' ORDER BY numDogs";
        }
        $having_results = runthis($having_query);
        while($row = $having_results->fetch_array(MYSQLI_ASSOC)) {
        echo "<tr>";
        $user_name = $row["user_name"];
        $num_dogs = $row["numDogs"];
        echo "<td>".$user_name."</td>";
        echo "<td>".$num_dogs."</td>";
        echo "</tr>";
    }
echo "</table>";
}
?>
<br>
<br>
<form method='post' action='analytics.php' enctype='multipart/form-data'>

    <label>Display the dogs who commented</label>
 <select name='nested_ba'>
  <option value="max" <?php if(isset($_POST['nested_ba']) &&
                             $_POST['nested_ba'] == 'max') {
                                echo 'selected="selected"';
                            }
                             ?>>the most</option>
  <option value="min" <?php if(isset($_POST['nested_ba']) &&
                             $_POST['nested_ba'] == 'min') {
                                echo 'selected="selected"';
                            }
                             ?>>the least</option>
</select>
<input class='text_field' type='hidden' name='nested'>
<input class='submitbutton' type='submit' value='Execute'>
</form>
<?php
    // nested statement executed
    if(isset($_POST['nested']))
    { 
        echo "
<table class='dog_profiles'>
<tr>
    <th>Dog's user name</th>
    <th>Number of comments</th>
    <th>Profile</th>
</tr>";
        $nested_ba= $_POST['nested_ba'];
        $temp_table_query = "
        CREATE TEMPORARY TABLE IF NOT EXISTS temp AS (
            SELECT pc.poster_id, COUNT(*) as numComments
            FROM Post_Contains_Comment pc
            GROUP BY pc.poster_id
        )";
        runthis($temp_table_query);
        // Need to create two temp tables since MySQL does not allow reopen a temporary table
        // Work around suggested by: Kevin Kalitowski - https://stackoverflow.com/questions/343402/getting-around-mysql-cant-reopen-table-error
        $temp_table_query = "
        CREATE TEMPORARY TABLE IF NOT EXISTS temp2 AS (
            SELECT pc.poster_id, COUNT(*) as numComments
            FROM Post_Contains_Comment pc
            GROUP BY pc.poster_id
        )";
        runthis($temp_table_query);
        $nested_query = "
        SELECT temp.poster_id, temp.numComments
        FROM temp
        WHERE temp.numComments = (SELECT MAX(temp2.numComments) FROM temp2)";
        if ($nested_ba == "min") {
            $nested_query = "
            SELECT temp.poster_id, temp.numComments
            FROM temp
            WHERE temp.numComments = (SELECT MIN(temp2.numComments) FROM temp2)";
        }
        $nested_results = runthis($nested_query);
        while($row = $nested_results->fetch_array(MYSQLI_ASSOC)) {
        echo "<tr>";
        $d_id = $row["poster_id"];
        $num_comments = $row["numComments"];
        echo "<td>".$d_id."</td>";
        echo "<td>".$num_comments."</td>";
        echo "<td><a class='submitbutton' href='profile.php?d_id=".$d_id."'>Profile Page</a></td>";
        echo "</tr>";
    }
        
echo "</table>";
}
?>
<br>
<br>
<form method='post' action='analytics.php' enctype='multipart/form-data'>

    <label>Display the dogs who commented on all posts</label>
<input class='text_field' type='hidden' name='division'>
<input class='submitbutton' type='submit' value='Execute'>
</form>

<?php
    // divison statement executed
    if(isset($_POST['division']))
    { 
        echo "<table class='dog_profiles'>
<tr>
    <th>Dog's user name</th>
    <th>Number of comments</th>
    <th>Profile</th>
</tr>";
        $div_query ="SELECT poster_id, COUNT(*) as numComments FROM (SELECT pc.poster_id FROM Post_Contains_Comment pc
        WHERE NOT EXISTS(SELECT p.post_id FROM Profile_Page_Contains_Post p
        WHERE NOT EXISTS(SELECT pc2.post_id FROM Post_Contains_Comment pc2
        WHERE pc2.post_id = p.post_id 
        AND pc2.poster_id = pc.poster_id))) AS tempDiv GROUP BY poster_id";
        $div_results = runthis($div_query);
        while($row = $div_results->fetch_array(MYSQLI_ASSOC)) {
        echo "<tr>";
        $d_id = $row["poster_id"];
        $numComments = $row["numComments"];
        echo "<td>".$d_id."</td>";
        echo "<td>".$numComments."</td>";
        echo "<td><a class='submitbutton' href='profile.php?d_id=".$d_id."'>Profile Page</a></td>";
        echo "</tr>";
    }   
echo "</table>";
}
?>
</div>
</body>
</html>