<!DOCTYPE html>
<html>

<?php 

require_once 'functions.php';
/*****DROP ALL CURRENT TABLES, PLEASE DO NOT DELETE********/
$result = runthis('SELECT CONCAT("DROP TABLE IF EXISTS `", table_schema, "`.`", table_name, "`cascade;")
  FROM   information_schema.tables
  WHERE  table_schema = "'.$dbname.'"');
while($row = $result->fetch_array(MYSQLI_NUM)) {
    runthis($row[0]);
}

echo 'tables dropped<br>';
/***END OF DROP TABLES***/
    
/****ADDING TABLES TO DATABASE, FEEL FREE TO CHANGE EXISTING AND INSERT MORE******/
runthis('CREATE TABLE Owner (
  user_id INT PRIMARY KEY, 
  username VARCHAR(20) NOT NULL UNIQUE, 
  password VARCHAR(32) NOT NULL)');


runthis('CREATE TABLE Owner_Has_Dog (
  since DATE, d_id INT PRIMARY KEY, 
  name VARCHAR(20) NOT NULL, 
  interests VARCHAR(32), 
  breed VARCHAR(11) NOT NULL, 
  DOB DATE NOT NULL, 
  gender VARCHAR(11) NOT NULL, 
  user_id INT NOT NULL,
  FOREIGN KEY(user_id) REFERENCES Owner
      ON DELETE CASCADE)');
  
  runthis('CREATE TABLE Dog_Has_Profile_Page (
    since DATE,
    introduction TINYTEXT,
    profile_pics BLOB,
    profile_id INT PRIMARY KEY,
    d_id INT NOT NULL,
    FOREIGN KEY(d_id) REFERENCES Owner_Has_Dog
        ON DELETE CASCADE)');

  runthis('CREATE TABLE Dog_Has_Personal_Note (
    d_id INT NOT NULL,
    since DATE NOT NULL,
    sender_id INT NOT NULL,
    note_id INT PRIMARY KEY,
    FOREIGN KEY(d_id, sender_id) REFERENCES Owner_Has_Dog
        ON DELETE CASCADE)');
  
  runthis('CREATE TABLE Matches (
    d1_id INT,
    d2_id INT,
    start_date DATE,
    PRIMARY KEY (d1_id, d2_id),
    FOREIGN KEY (d1_id, d2_id) REFERENCES Owner_Has_Dog
        ON DELETE CASCADE)');
  
  runthis('CREATE TABLE Profile_Page_Contains_Post (
    post_id INT PRIMARY KEY,
    image BLOB,
    text TINYTEXT,
    num_likes INT,
    profile_id INT NOT NULL,
    FOREIGN KEY(profile_id) REFERENCES Dog_Has_Profile_Page
        ON DELETE CASCADE)');
  
  runthis('CREATE TABLE Post_Contains_Comment (
    time_stamp TIMESTAMP,
    poster_id INT,
    text TINYTEXT NOT NULL,
    num_likes INT,
    since DATE,
    post_id INT NOT NULL,
    PRIMARY KEY(time_stamp, poster_id, post_id),
    FOREIGN KEY(post_id) REFERENCES Profile_Page_Contains_Post
        ON DELETE CASCADE,
    FOREIGN KEY(poster_id) REFERENCES Owner_Has_Dog 
        ON DELETE CASCADE)');
  
  runthis('CREATE TABLE Owner_Manages_Group (
    since DATE,
    group_id INT PRIMARY KEY,
    group_name VARCHAR(30) NOT NULL,
    group_description TINYTEXT,
    num_members INT,
    user_id INT NOT NULL,
    group_type_id INT NOT NULL,
    PRIMARY KEY (group_id),
    FOREIGN KEY (group_type_id) REFERENCES Group_Types
        ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Owner
        ON DELETE CASCADE)');

  runthis('CREATE TABLE Group_Types (
    group_type_id INT PRIMARY KEY,
    group_type VARCHAR(20) NOT NULL)');

  runthis('CREATE TABLE Premium_User (
    user_id INT PRIMARY KEY,
    payment_info INT NOT NULL,
    FOREIGN KEY(user_id) REFERENCES Owner)');

  runthis('CREATE TABLE Dog_Joins_Group (
    d_id INT PRIMARY KEY,
    group_id INT PRIMARY KEY,
    since DATE,
    FOREIGN KEY(group_id) REFERENCES Owner_Manages_Group
        ON DELETE CASCADE,
    FOREIGN KEY (d_id) REFERENCES Owner_Has_Dog
        ON DELETE CASCACADE)');
  
  runthis('CREATE TABLE Dog_Has_Highlights (
    highlight_id INT PRIMARY KEY,
    image BLOB NOT NULL,
    start_time TIMESTAMP NOT NULL,
    numViews INT,
    d_id INT NOT NULL,
    FOREIGN KEY(d_id) REFERENCES Owner_Has_Dog
        ON DELETE CASCADE)');
  
  runthis('CREATE TABLE Premium_Profile_Page (
    profile_id INT PRIMARY KEY,
    premium_swag_id INT,
    FOREIGN KEY(profile_id) REFERENCES Dog_Has_Profile_Page
        ON DELETE CASCADE,
    FOREIGN KEY(premium_swag_id) REFERENCES Premium_Swags
        ON DELETE CASCADE)');
  
  runthis('CREATE TABLE Premium_Swags (
    premium_swag_id INT PRIMARY KEY,
    premium_swag_type VARCHAR(20),
    premium_swag_content BLOB)');

  /****INSERT MORE BELOW******/

    
    
/****DO NOT INSERT AFTER THIS******/    
echo 'tables created';
?>