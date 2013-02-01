<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "return_conf";

  // start session, check if the user is already logged in and if he is a superuser or not
  include ("../check_user.inc");
  include ("../library_functions.inc");
?>

<!doctype html public "-//W3C//DTD HTML 4.01//EN">

<html>

  <head>

    <title>STI-Innsbruck Library</title>

    <meta http-equiv="keywords" content="STI-Innsbruck - Library" />
	<meta http-equiv="generator" content="PHP Designer 2005" />
	<meta http-equiv="author" content="Nathalie Steinmetz" />
    <meta http-equiv="Content-Style-Type" content="text/css">

    <link rel="stylesheet" href="../format.css" type="text/css" />

  </head>

  <body>

  <?php
    // including vertical menue
    include("menue1.inc");
  ?>

      <span class="crumbTrail"><a class="crumbTrail" href="sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="return_obj_list.php">Return book list</a> &gt; Return book </span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Return book</h2><br>

                <?php

                  // start database connection for the normal user, with error handling
                  $db = mysql_connect("localhost", "libraryUser", "user");
                  if (!mysql_select_db ("stilibrary", $db)){
                    die ("Connection to database failed - normal user");
                  } // end if

                  // the user id is taken from a session variable
                  $uid = 0;
                  if (isset($_SESSION["user_id"]))
                    $uid = $_SESSION["user_id"];

                  // the id of the publication to be returned is got via POST
                  $pid=0;
                  if (isset($_POST["pid"]))
                    $pid = $_POST["pid"];

                  // if this variable is set, all the objects shall be returned
                  $return_all="";
                  if (isset ($_GET["return_all"]))
                    $return_all = $_GET["return_all"];

                  // only one book shall be returned
                  if ($return_all == ""){
                    if ($pid != 0) {

                      // build sql delete borrowing string
                      $sqlReturnObj = "DELETE FROM borrowing WHERE publication = '$pid';";

                      // send query to database
                      mysql_db_query("stilibrary", $sqlReturnObj);
                      if (mysql_errno() != 0) {
                        // logging function call
                        $string = "Error: sqlReturnObj: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlReturnObj . "\n";
                        library_log($string);
                        echo ("Database error! - Please see log file for detailed information.<br><br>");
                      } // end if

                      // check if the delete was successfull
                      $num = mysql_affected_rows();
                      if ($num > 0) {

                        // logging function call
                        $string = "Deleted book from 'borrowing' with publication id " . $pid . "\n";
                        library_log($string);

                        // build sql update publication to available string
                        $sqlUpdateObj = "UPDATE publication SET status = 'available' WHERE pid = '$pid'";

                        // send query to database
                        mysql_db_query("stilibrary", $sqlUpdateObj);
                        if (mysql_errno() != 0) {
                          // logging function call
                          $string = "Error: sqlUpdateObj: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlUpdateObj . "\n";
                          library_log($string);
                          echo ("Database error! - Please see log file for detailed information.<br><br>");
                        } // end if

                        // if the update was successfull
                        $num2 = mysql_affected_rows();
                        if ($num2 > 0) {

                          // logging function call
                          $string = "Updated publication status from publication id " . $pid . " to available\n";
                          library_log($string);

                          // send select query to database
                          $res = mysql_db_query("stilibrary", "SELECT * FROM publication WHERE pid = '$pid';");
                          if (mysql_errno() != 0) {
                            // logging function call
                            $string = "Error: sqlSelectObj: " . mysql_errno() . ": " . mysql_error(). "\n";
                            library_log($string);
                            echo ("Database error! - Please see log file for detailed information.<br><br>");
                          } // end if

                          // extract results
                          $author = mysql_result($res, 0, "author");
                          $title = mysql_result($res, 0, "title");
                          $subtitle = mysql_result($res, 0, "subtitle");
                          $year = mysql_result($res, 0, "year");
                          $publisher = mysql_result($res, 0, "publisher");
                          $location = mysql_result($res, 0, "location");
                          $isbn = mysql_result($res, 0, "isbn");
                          $keywords = mysql_result($res, 0, "keywords");
                          $comment = mysql_result($res, 0, "comment");
                          $signature = mysql_result($res, 0, "signature");
                          $proc_time = mysql_result($res, 0, "procTime");
                          $conf_loc = mysql_result($res, 0, "confLoc");
                          $supervisor = mysql_result($res, 0, "supervisor");
                          $school = mysql_result($res, 0, "school");
                          $type = mysql_result($res, 0, "type");
                          $classification = mysql_result($res, 0, "classification");
                          $status = mysql_result($res, 0, "status");

                          echo "<strong>You've successfully returned this book</strong><br><br>";
                          echo "<table cellspacing='10'>";

                          if(( $author != 'NULL') && ($author != '')) {
                            echo "<tr> <td> <div align='right'><strong> author(s) </strong></div> </td>";
                            echo "<td>", $author, "</td> </tr>"; }
                          echo "<tr> <td> <div align='right'><strong> title </strong></div> </td>";
                          echo "<td>", $title, "</td> </tr>";
                          if(($subtitle != 'NULL') && ($subtitle != '')) {
                            echo "<tr> <td> <div align='right'><strong> subtitle </strong></div> </td>";
                            echo "<td>", $subtitle, "</td> </tr>";}
                          if(($year != 'NULL') && ($year != '') && ($year != '0000')) {
                            echo "<tr> <td> <div align='right'><strong> year </strong></div> </td>";
                            echo "<td>", $year, "</td> </tr>";}
                          if(($publisher != 'NULL') && ($publisher != '')) {
                            echo "<tr> <td> <div align='right'><strong> publisher </strong></div> </td>";
                            echo "<td>", $publisher, "</td> </tr>";}
                          if(($location != 'NULL') && ($location != '')) {
                            echo "<tr> <td> <div align='right'><strong> location </strong></div> </td>";
                            echo "<td>", $location, "</td> </tr>";}
                          if(($isbn != 'NULL') && ($isbn != '')) {
                            echo "<tr> <td> <div align='right'><strong> ISBN / ISSN </strong></div> </td>";
                            echo "<td>", $isbn, "</td> </tr>";}
                          if(($keywords != 'NULL') && ($keywords != '')) {
                            echo "<tr> <td> <div align='right'><strong> keywords </strong></div> </td>";
                            echo "<td>", $keywords, "</td> </tr>";}
                          if(($comment != 'NULL') && ($comment != '')) {
                            echo "<tr> <td> <div align='right'><strong> comment </strong></div> </td>";
                            echo "<td>", $comment, "</td> </tr>";}
                          echo "<tr> <td> <div align='right'><strong> signature </strong></div> </td>";
                          echo "<td>", $signature, "</td> </tr>";
                          if(($proc_time != 'NULL') && ($proc_time != '0000-00-00') && ($proc_time != '')) {
                            echo "<tr> <td> <div align='right'><strong> proceeding time </strong></div> </td>";
                            echo "<td>", $proc_time, "</td> </tr>";}
                          if(($conf_loc != 'NULL') && ($conf_loc != '')) {
                            echo "<tr> <td> <div align='right'><strong> conference location </strong></div> </td>";
                            echo "<td>", $conf_loc, "</td> </tr>";}
                          if(($supervisor != 'NULL') && ($supervisor != '')) {
                            echo "<tr> <td> <div align='right'><strong> supervisor </strong></div> </td>";
                            echo "<td>", $supervisor, "</td> </tr>";}
                          if(($school != 'NULL') && ($school != '')) {
                            echo "<tr> <td> <div align='right'><strong> school </strong></div> </td>";
                            echo "<td>", $school, "</td> </tr>";}
                          echo "<tr> <td> <div align='right'><strong> type </strong></div> </td>";
                          echo "<td>", $type, "</td> </tr>";
                          echo "<tr> <td> <div align='right'><strong> classification </strong></div> </td>";
                          echo "<td>", $classification, "</td> </tr>";
                          echo "<tr> <td> <div align='right'><strong> status </strong></div> </td>";
                          echo "<td>", $status, "</td> </tr>";
                          echo "<form action = 'return_obj_list.php' method = 'GET'>";
                          echo "<td> <input type='submit' name='get_back' value='  Get back to object list  '></td>";
                          echo "</tr></form>";
                          echo "</table>";
                        } // end if
                        else {
                          // logging function call
                          $string = "Error: Status from publication with id " . $pid . " couldn't be updated to available\n";
                          library_log($string);
                          echo "<strong>Error: The book's status couldn't be updated to available!</strong>";
                        } // end else
                      } // end if
                      else {
                        // logging function call
                        $string = "Error: Publication with id " . $pid . " couldn't be returned\n";
                        library_log($string);
                        echo "<strong>Error: The book couldn't be returned!</strong>";
                      } // end else
                    } // end if
                    else
                      echo "<strong>Error: No book defined to be returned!</strong>";
                  } // end if

                  // all the books shall be returned
                  else {
                    // build sql select string
                    $sqlSelectObj = "SELECT publication FROM borrowing WHERE user = '$uid';";

                    // send query to database
                    $res = mysql_db_query("stilibrary", $sqlSelectObj);
                    if (mysql_errno() != 0) {
                      // logging function call
                      $string = "Error: sqlSelectObj: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlSelectObj . "\n";
                      library_log($string);
                      echo ("Database error! - Please see log file for detailed information.<br><br>");
                    } // end if

                    // get number of selected publications
                    $num = mysql_num_rows($res);
                    if ($num > 0) {
                      for ($i=0; $i<$num; $i++) {
                        // extract publication id
                        $pid = mysql_result($res, $i, "publication");

                        // build update publication status to available string
                        $sqlUpdateObj = "UPDATE publication SET status = 'available' WHERE pid = '$pid'";

                        // send query to database
                        mysql_db_query("stilibrary", $sqlUpdateObj);
                        if (mysql_errno() != 0) {
                          // logging function call
                          $string = "Error: sqlUpdateObj: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlUpdateObj . "\n";
                          library_log($string);
                          echo ("Database error! - Please see log file for detailed information.<br><br>");
                        } // end if
                        // if the update was successfull
                        $num2 = mysql_affected_rows();
                        if ($num2 > 0) {
                          // logging function call
                          $string = "Successfully updated the status to 'available' from the object with id: " . $pid . "\n";
                          library_log($string);
                        } // end if
                        else {
                          // logging function call
                          $string = "Error: Couldn't update the status to 'available' from the object with id: " . $pid . "\n";
                          library_log($string);
                          echo "<strong>Error: The book's status couldn't be updated!</strong>";
                        }
                      } // end for
                    } // end if

                    // build sql delete borrowing string
                    $sqlReturnAll = "DELETE FROM borrowing WHERE user = '$uid';";

                    // send query to database
                    mysql_db_query("stilibrary", $sqlReturnAll);
                    if (mysql_errno() != 0) {
                      // logging function call
                      $string = "Error: sqlReturnAll: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlReturnAll . "\n";
                      library_log($string);
                      echo ("Database error! - Please see log file for detailed information.<br><br>");
                    } // end if

                    // check if the delete was successfull
                    $num = mysql_affected_rows();
                    if ($num > 0) {
                      // logging function call
                      $string = "Returned all books\n";
                      library_log($string);
                      echo "<strong>You've successfully returned all books</strong><br><br>";
                    } // end if
                    else {
                      // logging function call
                      $string = "Error: The books couldn't be returned\n";
                      library_log($string);
                      echo "<strong>Error: The books couldn't be returned!</strong>";
                    } // end else
                  } // end else

                  // close the database connection
                  mysql_close($db);
                ?>

              </td>
            </tr>
          </table>

        </td>
      </tr>
    </table>

    <?php
      // including vertical menue
      include("menue3.inc");
    ?>

  </body>

</html>

