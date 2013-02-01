<?php
  // function to write the current date and time, and a given string into a logfile
  function library_log($string) {
    $date = date("d.m.Y:");
    $time = date("H:i:s");

    // the actual date is written into the logfile
    $logInfo = "[$date$time] Cron: ";

    if ($string != "")
      $logInfo .= " - $string";

    // each month a new logfile is created
    $month = date("m");
    $year = date("Y");
    $filename = "Log/log_".$month."_".$year.".txt";

    // the logfile is always opened for append, which means that all the new logs are appended to the existing
    $fp = fopen($filename,"a");
    if ($fp) {
      fputs($fp,"$logInfo\n");
      fclose($fp);
    } // end if
    else
      echo "Logfile couldn't be opened to append!";
  } // end function library_log

  // start database connection for the superuser, with error handling
  $db = mysql_connect("localhost", "librarySuperuser", "superuser");
  if (!mysql_select_db ("stilibrary", $db)){
    die ("Connection to database failed - superuser");
  } // end if

  /*--------------------------------------------------------------------------------------
  ------------------- Look if a user shall be sent a reminding mail ----------------------
  --------------------------------------------------------------------------------------*/

  // select all the publications that are borrowed and for which a remindDate is defined
  // send select borrowing query to database
  $res = mysql_db_query("stilibrary", "SELECT returnDate, user, publication FROM borrowing WHERE returnDate != '0000-00-00';");
  if (mysql_errno() != 0) {
    // logging function call
    $string = "sqlSelectRem: " . mysql_errno() . ": " . mysql_error(). "\n";
    library_log($string);
    echo $string;
  } // end if

  // get number of results
  $num = mysql_num_rows($res);
  if ($num > 0) {
    for ($i=0; $i<$num; $i++) {
      // extract returnDate from borrowing results
      $returnDate = mysql_result($res, $i, "returnDate");

      // make a timestamp out of the returnDate, to be able to better work with it
      list($year, $month, $day) = explode("-", $returnDate);
      $returnDateTStamp = mktime(0, 0, 0, $month, $day, $year);

      // get a timestamp of today's date
      $actualDate = time();

      // if today is later or equal to the return date, the user must be reminded to return his publication
      if ($actualDate >= $returnDateTStamp){
        // extract user and publication from borrowing results
        $user = mysql_result($res, $i, "user");
        $publication = mysql_result($res, $i, "publication");

        // select the email address from the user which is to be reminded
        // send select user query to database
        $res2 = mysql_db_query("stilibrary", "SELECT email FROM user WHERE uid = $user;");
        if (mysql_errno() != 0) {
          // logging function call
          $string = "sqlSelectEmail: " . mysql_errno() . ": " . mysql_error(). "\n";
          library_log($string);
          echo $string;
        } // end if

        // extract email from user results
        $email = mysql_result($res2, 0, "email");

        // select the title from the publication which shall be returned
        // send select publication query to database
        $res3 = mysql_db_query("stilibrary", "SELECT title FROM publication WHERE pid = $publication;");
        if (mysql_errno() != 0) {
          // logging function call
          $string = "sqlSelectTitle: " . mysql_errno() . ": " . mysql_error(). "\n";
          library_log($string);
          echo $string;
        } // end if

        // extract title from publication results
        $title = mysql_result($res3, 0, "title");

        // send an email to the user which needs to be reminded, including the return date and the corresponding publication title
        mail($email, "STI-Innsbruck Library Reminder", "The object " . $title . " is due to be returned on " . $year . "-" . $month . "-" . $day . " to the library.", "From: Marek.Wieczorek@uibk.ac.at\r\nReply-To: Marek.Wieczorek@uibk.ac.at");

        // logging function call
        $string = "Cron job: sent mail to user with id " . $user . " concerning the return of publication with id " . $publication . "\n";
        library_log($string);
      } // end if
    } // end for
  } // end if

  /*--------------------------------------------------------------------------------------
  ------ Look if a publication's status has to be changed from 'new' to 'available' ------
  --------------------------------------------------------------------------------------*/

  // check after how many days an object's status shall be changed from 'new' to 'available'
  // send select organisation query to database
  $res = mysql_db_query("stilibrary", "SELECT newToAvailable FROM organisation;");
  if (mysql_errno() != 0) {
    // logging function call
    $string = "sqlSelectNewToAv: " . mysql_errno() . ": " . mysql_error(). "\n";
    library_log($string);
    echo $string;
  } // end if

  // extract newToAvailable from organisation results
  $newToAvailable = mysql_result($res, 0, "newToAvailable");

  // select all the publications whose status is 'new'
  // send select publication query to database
  $res = mysql_db_query("stilibrary", "SELECT pid, type, originDate FROM publication WHERE status='new';");
  if (mysql_errno() != 0) {
    // logging function call
    $string = "sqlSelectStatus: " . mysql_errno() . ": " . mysql_error(). "\n";
    library_log($string);
    echo $string;
  } // end if

  // get number of results
  $num = mysql_num_rows($res);
  if ($num > 0) {
    for ($i=0; $i<$num; $i++) {
      // extract publication results
      $pid = mysql_result($res, $i, "pid");
      $type = mysql_result($res, $i, "pid");
      $originDate = mysql_result($res, $i, "originDate");

      // make a timestamp out of the originDate, to be able to better work with it
      list($year, $month, $day) = explode("-", $originDate);
      $originDateTStamp = mktime(0, 0, 0, $month, $day, $year);

      // build the exact date on which the status shall be changed (86400 == 24*60*60)
      $changeStatusDate = $originDateTStamp +($newToAvailable * 86400);

      // get a timestamp of today's date
      $actualDate = time();

      // if today is later or equal to the date on which the status shall be changed, the status is changed
      // if the object's type = book, the status is changed to 'available'
      if (($actualDate >= $changeStatusDate) && ($type == "book")){
        // build sql update publication string
        $sqlUpdateObj = "UPDATE publication SET status = 'available' WHERE pid = '$pid';";

        // send query to database
        $res2 = mysql_db_query("stilibrary", $sqlUpdateObj);
        if (mysql_errno() != 0) {
          // logging function call
          $string = "sqlUpdateObj: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlUpdateObj . "\n";
          library_log($string);
          echo $string;
        } // end if

        $num2 = mysql_affected_rows();
        if ($num2 > 0) {
          // logging function call
          $string = "Cron job: status from publication with id " . $pid . " changed to available.\n";
          library_log($string);
        } // end if
        else {
          // logging function call
          $string = "Error, Cron job: status from publication with id " . $pid . " couldn't be changed to available.\n";
          library_log($string);
        }
      } // end if

      // if today is later or equal to the date on which the status shall be changed, the status is changed
      // if the object's type != book, the status is changed to 'not available'
      if (($actualDate >= $changeStatusDate) && ($type != "book")){
        // build sql update publication string
        $sqlUpdateObj = "UPDATE publication SET status = 'not available' WHERE pid = '$pid';";

        // send query to database
        $res2 = mysql_db_query("stilibrary", $sqlUpdateObj);
        if (mysql_errno() != 0) {
          // logging function call
          $string = "sqlUpdateObj: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlUpdateObj . "\n";
          library_log($string);
          echo $string;
        } // end if

        $num2 = mysql_affected_rows();
        if ($num2 > 0) {
          // logging function call
          $string = "Cron job: status from publication with id " . $pid . " changed to not available.\n";
          library_log($string);
        } // end if
        else {
          // logging function call
          $string = "Error, Cron job: status from publication with id " . $pid . " couldn't be changed to not available.\n";
          library_log($string);
        }
      } // end if
    } // end for
  } // end if

  // close database connection
  mysql_close($db);
?>

