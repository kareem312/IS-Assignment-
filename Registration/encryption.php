<?php
/*-------------------------------------------------------------
  The generateSalt function was gotten from http://code.activestate.com/recipes/576894-generate-a-salt/
  @author AfroSoft
-------------------------------------------------------------*/

function generateSalt($max = 64) {
	$characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
	$i = 0;
	$salt = "";
	while ($i < $max) {
	    $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
	    $i++;
	}
	return $salt;
}

/*-------------------------------------------------------------
 Form data
-------------------------------------------------------------*/
$username = mysql_escape_string($_POST['username']);
$password = $_POST['password'];

/*-------------------------------------------------------------
 Salting and Hashing
-------------------------------------------------------------*/

$user_salt = generateSalt(); // Generates a salt from the function above
$combo = $user_salt . $password; // Appending user password to the salt
$hashed_pwd = hash('sha512',$combo); // Using SHA512 to hash the salt+password combo string

/*-------------------------------------------------------------
 Database stuff starts from here,
 MySQL Server Info is gotten from the $_SERVER variable
 (assuming we have the path to the file containing the
 DB credentials in our .htaccess file)
-------------------------------------------------------------*/

$db_host = $_SERVER['DB_HOST'];
$db_user = $_SERVER['DB_LOGIN'];
$db_pass = $_SERVER['DB_PASSWD'];
$db_name = $_SERVER['DB_DB'];

/*-------------------------------------------------------------
 Checks the connection to the DB has been made.
 If successful selects the database to be used, else exits
-------------------------------------------------------------*/

$link = mysql_connect($db_host,$db_user,$db_pass);
if(!$link)
{
	die("Could Not Connect:".mysql_error());
}
mysql_select_db($db_name, $link) or die('Can\'t use db:'. mysql_error());

/*-------------------------------------------------------------
 Inserting Data
-------------------------------------------------------------*/
$insert="INSERT INTO login(username, salt, hashed_pwd) VALUES ('$username','$user_salt','$hashed_pwd')";
mysql_query($insert, $link) or die('Error while trying to insert data'.mysql_error());mysql_close(); //Closing the connection to the database

/*-------------------------------------------------------------
       Username and password gotten from the login form
   -------------------------------------------------------------*/

   $form_username = $_POST['username'];
   $form_password = $_POST['password'];

   /*-------------------------------------------------------------
      Database connection and selection of the database to be used
   -------------------------------------------------------------*/

   //MySQL Server Info
   $db_host = $_SERVER['DB_HOST'];
   $db_user = $_SERVER['DB_LOGIN'];
   $db_pass = $_SERVER['DB_PASSWD'];
   $db_name = $_SERVER['DB_DB'];

   //MySQL Server Connection
   $link = mysql_connect($db_host,$db_user,$db_pass);
   if(!$link)
   {
       die("Could Not Connect:".mysql_error());
   }
   mysql_select_db($db_name, $link) or die('Can\'t use db:'. mysql_error());

   /*-------------------------------------------------------------
 The query to the database and getting the value from it
   -------------------------------------------------------------*/

   $find_user = "SELECT salt,hashed_pwd,gender FROM login WHERE username='$form_username'";
   $result = mysql_query($find_user, $link) or die('Error while trying to find salt'.mysql_error());
   $row = mysql_fetch_assoc($result);

   /*-------------------------------------------------------------
     Getting the value from the database
     &
     salting,hashing of the password from the form
   ------------------------------------------------------------*/
   $stored_salt = $row['salt'];
   $stored_hash = $row['hashed_pwd'];
   $check_pass = $stored_salt . $form_password;
   $check_hash = hash('sha512',$check_pass);

   /*-------------------------------------------------------------
     Comparing the two hashed values
   -------------------------------------------------------------*/

   if($check_hash == $stored_hash){
       echo "User authenticated";
   }
   else{
       echo "Not authenticated";
   }    mysql_close(); //Close the connection to the DB
?>
