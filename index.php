<!DOCTYPE html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ikl";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "CREATE TABLE donorlist ( 
 name VARCHAR(30) NOT NULL,
 bloodgrp VARCHAR(5) NOT NULL,
 mobile VARCHAR(10) NOT NULL PRIMARY KEY,
 email VARCHAR(50)
 )";

if ($conn->query($sql) === TRUE) {
    echo "Table Donor List created successfully";
} else {
  //  echo "Error creating table: " . $conn->error;
}

$conn->close();
?>

<?php

if(isset($_POST["regbtn"]))
{
// checking empty values

if (empty($_POST["mname"]) && (empty($_POST["mblood"])) && (empty($_POST["mmobile"])) && (empty($_POST["mmail"])))
{
 echo " Please Enter All the Fields";
}
else
{
// if value is set for each field 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ikl";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// insert into donorlist table
$sql = "INSERT INTO donorlist VALUES ('$_POST[mname]', '$_POST[mblood]', '$_POST[mmobile]', '$_POST[mmail]')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: Mobile Number already Registered <br>" . $conn->error;
}

$conn->close();

}
}

?>

<?php

if(isset($_POST["genJSON"]))
{
	
    //Create Database connection
    $db = mysql_connect("localhost","root","");
    if (!$db) {
        die('Could not connect to db: ' . mysql_error());
    }
 
    //Select the Database
    mysql_select_db("ikl",$db);
    
    //Replace * in the query with the column names.
    $result = mysql_query("select * from donorlist", $db);  
    
    //Create an array
    $json_response = array();
    
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
      
        $row_array['name'] = $row['name'];
        $row_array['bloodgrp'] = $row['bloodgrp'];
        $row_array['mobile'] = $row['mobile'];
        $row_array['email'] = $row['email'];
       
        
        //push the values in the array
        array_push($json_response,$row_array);
    }
	
	// creates a JSON file with time
    $fName = date("Y-m-d");
	
    $fp = fopen('results'. time() .'.json', 'w+');
	fwrite($fp, json_encode($json_response));
	fclose($fp);
	
	
    //Close the database connection
    mysql_close($db);
	echo " JSON FIle Generated";
 }
 
?>

<html>
    <head>
        <meta charset="utf-8" />
        <meta name="format-detection" content="telephone=no" />
        <meta name="msapplication-tap-highlight" content="no" />        
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height" /> <script type="text/javascript" src="js/jquery-2.1.3.min.js"></script>
        <script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery.mobile-1.4.5.min.css">        
        <title>Inaindhakaiggal JSON Generator</title>
    </head>
    <body>
        <section data-role="page" id="reg-page">
        <header data-role="header" data-theme="b" data-position="fixed">
        <h1>Register Donor</h1>
        </header>
        <article data-role="content">
            <form id="reg-form" action="index.php" method="post">
            <label for="mname">Name:</label>
            <input type="text" id="mname" name="mname"/>
            <label for="mblood">Blood Group:</label>
            <select id="mblood" name="mblood">
            <!-- <option value="op">O+</option>
            <option value="on">O-</option>
            <option value="ap">A+</option>
            <option value="an">A-</option>
            <option value="bp">B+</option>
            <option value="bn">B-</option>
            <option value="abp">AB+</option>
            <option value="abn">AB-</option> -->
                    <option value="ap">A+</option>
                    <option value="aop">A1+</option>
                    <option value="atp">A2+</option>
                    <option value="bp">B+</option>
                    <option value="aobp">A1B+</option>
                    <option value="atbp">A2B+</option>
                    <option value="abp">AB+</option>
                    <option value="op">O+</option>
                    <option value="an">A-</option>
                    <option value="aon">A1-</option>
                    <option value="atn">A2-</option>
                    <option value="bn">B-</option>
                    <option value="aobn">A1B-</option>
                    <option value="atbn">A2B-</option>
                    <option value="abn">AB-</option>
                    <option value="on">O-</option>
                    <option value="hh">Bombay Blood Group</option>
            </select>
            <label for="mmobile">Mobile:</label>
            <input type="tel" id="mmobile" name="mmobile"/>
            <label for="mmail">Email:</label>
            <input type="email" id="mmail" name="mmail"/>
            <input type="submit" id="regbtn" name="regbtn" value="Register" />
	    <input type="submit" name="genJSON" id="genJSON" value="Generate JSON" />
            <input type="reset" id="resbtn" value="Reset" /> 
            </form>
        </article>
        </section>
                
    </body>
</html>
