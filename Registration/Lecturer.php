<?php
      error_reporting(E_ERROR | E_PARSE);
      include("server.php");
      include("index.php");

if($_SESSION['AC'] != "Lecturer"){
  echo "Access Denied";
  exit();
}
$username =  $_SESSION['username'];

 $stdquery = "SELECT * FROM users WHERE type='Student' ";
 $std_run = mysqli_query($db, $stdquery);

?>
<?php
if(isset($_POST['update']))
{
   // get values form input text and number

   $grade = $_POST['grade'];
   $user_username=$_POST['user_username'];

   // mysql query to Update data
   $query = "UPDATE users SET grade= '".$grade."' WHERE user_username = '".$user_username."'";

   $result = mysqli_query($db, $query);

   if($result)
   {
       echo 'Data Updated';
   }else{
       echo 'Data Not Updated';
   }
   mysqli_close($db);
}
?>
<html>
<style>
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>
<head>
  <title>Students details</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
  <div class= "container">
    <h1>Enter student grades</h1>
  <form action="Lecturer.php" method="post">

              username: <input type="text" name="user_username" required><br><br>

              Grade:<input type="text" name="grade" required><br><br>

              <input type="submit" name="update" value="Update Data">

  </form>

  <table width="600" border="1" cellpadding="0" cellspacing="0" class="table table-bordered">

    <tr>
      <th>ID</th>
      <th>Student</th>
      <th>Email</th>
      <th>Grade</th>
    </tr>
    <?php
      while($student=mysqli_fetch_assoc($std_run)){

        echo "<tr>";
        echo "<td>".$student['user_id']."</td>";
        echo "<td>".$student['user_username']."</td>";
        echo "<td>".$student['user_email']."</td>";
        echo "<td>".$student['Grade']."</td>";
        echo "</tr>";
      }
    ?>

  </table>
</div>
</body>
</html>
