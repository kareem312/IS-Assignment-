<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'Grading System');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE user_username='$username' OR user_email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    if ($user['user_username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }
  // generate salt function
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
  $user_salt = generateSalt(); // Generates a salt from the function above
  $combo = $user_salt . $password_1; // Appending user password to the salt
  $hashed_pwd = hash('sha512',$combo); // Using SHA512 to hash the salt+password combo string

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	// $password = md5($password_1);//encrypt the password before saving in the database

// Now insert it (with login or whatever) into your database, use mysqli or pdo!
  	$query = "INSERT INTO users (user_username, salt, user_password, user_email)
  			  VALUES('$username', '$user_salt', '$hashed_pwd', '$email')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}
// LOGIN USER
if (isset($_POST['login'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	// $password = md5($password);

  	$query = "SELECT salt,user_password FROM users WHERE user_username='$username'";
  	$results = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($results);
    // fetching values from Database
    $stored_salt = $row['salt'];
    $stored_hash = $row['user_password'];
    $check_pass = $stored_salt . $password;
    $check_hash = hash('sha512',$check_pass);
    // echo $check_hash, "bbbbbbbbbbb", $stored_hash;

  	if ($check_hash == $stored_hash) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('Location: index.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}

?>
