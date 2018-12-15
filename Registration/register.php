<?php  error_reporting(E_ERROR | E_PARSE);
include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<style>
body {
  font-size: 120%;
  background: #F8F8FF;
}

.header {
  width: 60%;
  margin: 50px auto 0px;
  color: white;
  background: #ffd500;
  text-align: center;
  border: 1px solid #ffd500;
  border-bottom: none;
  border-radius: 10px 10px 0px 0px;
  padding: 20px;
}
h2{
  color: #632a7b;
  font-weight: bold;
}
form, .content {
  width: 60%;
  margin: 0px auto;
  padding: 20px;
  border: 1px solid #B0C4DE;
  background: white;
  border-radius: 0px 0px 10px 10px;
}
.input-group {
  margin: 10px 0px 10px 0px;
}
.input-group label {
  display: block;
  text-align: left;
  margin: 3px;
}
.input-group input {
  width: 90%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}
.input-group input:focus{
  background-color: #ddd;
  outline: none;
}
.btn {
  background-color: #ffd500;
  color: #632a7b;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
  font-weight: bold;
}
</style>
<body>
  <div class="header">
  	<h2>Register</h2>
  </div>

  <form method="post" action="register.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label><b>Username</b></label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
  	<div class="input-group">
  	  <label><b>Email</b></label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label><b>Password</b></label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label><b>Confirm password</b></label>
  	  <input type="password" name="password_2">
  	</div>
    <select class="mdb-select md-form colorful-select dropdown-primary" name="select">
      <option value="">Open this select menu</option>
      <option value="Lecturer">Lecturer</option>
      <option value="TA">TA</option>
      <option value="Student">Student</option>
    </select>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a member? <a href="login.php">Sign in</a>
  	</p>
  </form>
</body>
</html>
