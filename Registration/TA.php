<?php include("server.php");

$username =  $_SESSION['username'];

 $taquery = "SELECT * FROM users WHERE type='Student' ";
 $ta_run = mysqli_query($db, $taquery);

?>

<html>

<head>
  <title>Students details</title>
</head>

<body>
  <table width="600" border="1" cellpadding="0" cellspacing="0" >

    <tr>
      <th>ID</th>
      <th>Student</th>
      <th>Email</th>
      <th>Grade</th>
    </tr>
    <?php
      while($student=mysqli_fetch_assoc($ta_run)){

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
