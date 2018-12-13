<?php include("server.php");

$username =  $_SESSION['username'];

 $stdquery = "SELECT * FROM users WHERE user_username= '".$username."' AND type='Student' ";
 $std_run = mysqli_query($db, $stdquery);

?>
<html>

<head>
  <title>My details</title>
</head>

<body>
  <table width="600" border="1" cellpadding="0" cellspacing="0">

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
        // echo "<td>".$student['Subject']."</td>";
        echo "<td>".$student['Grade']."</td>";
        echo "</tr>";
      }
    ?>

  </table>
</body>
</html>
