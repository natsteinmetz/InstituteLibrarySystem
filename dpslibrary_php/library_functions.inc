<?php
  // function to write the current date and time, and a given string into a logfile
  function library_log($string) {

    $date = date("d.m.Y:");
    $time = date("H:i:s");
    $ip = getenv("REMOTE_ADDR");
    $site = $_SERVER["REQUEST_URI"];

    // the actual date, the user ip address and the requested site are written into the logfile
    $logInfo = "[$date$time] - $ip - \"GET /$site\"";

    // the username from the currently logged-in user and the parameter string are written into the logfile
    $username = "";
    if (isset($_SESSION["user_id"])) {
      $username = $_SESSION["user_username"];
      $logInfo .= "\nUser: $username";
    } // end if

    if ($string != "")
      $logInfo .= " - $string";

    // each month a new logfile is created
    $month = date("m");
    $year = date("Y");
    $filename = "../Log/log_".$month."_".$year.".txt";

    // the logfile is always opened for append, which means that all the new logs are appended to the existing
    $fp = fopen($filename,"a");
    if ($fp) {
      fputs($fp,"$logInfo\n");
      fclose($fp);
    } // end if
    else
      echo "Logfile couldn't be opened to append!";
  } // end function library_log
?>
