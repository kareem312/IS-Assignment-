<?php include("server.php");

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

<head>
  <title>Students details</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <form action="Lecturer.php" method="post">

              username: <input type="text" name="user_username" required><br><br>

              Grade:<input type="text" name="grade" required><br><br>

              <input type="submit" name="update" value="Update Data">

  </form>

  <table width="600" border="1" cellpadding="0" cellspacing="0" >

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
</body>
</html>
