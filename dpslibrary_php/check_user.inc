<?php
  $user_id = 0;
  // if the user isn't yet logged in
  if (!isset ($_SESSION["user_id"])){
    header ("Location: ../User/login.php");
    exit;
  } // end if
  // if the user is already logged in his id and his user/superuser state are saved
  else {
    $user_id = $_SESSION["user_id"];
      
    $user_superuser = 0;
    if (isset($_SESSION["user_superuser"]))
      $user_superuser = $_SESSION["user_superuser"];
  } // end else
?>

