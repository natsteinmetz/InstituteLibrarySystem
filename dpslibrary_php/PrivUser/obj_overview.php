<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "priv_overview";

  // start session, check if the user is already logged in and if he is a superuser or not
  include ("../check_user.inc");
  include ("../library_functions.inc");

  // check if the logged-in is a superuser
  if (!$user_superuser && isset($_SESSION["user_id"])){
    header("Location: ../User/sti_library.php?error=1");
    exit;
  } // end if
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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="priv_func_overview.php">Privileged functions</a> &gt; <a class="crumbTrail" href="obj_overview.php">Object overview</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Object overview</h2><br>

                <?php

                  // extract order variable via POST
                  $order="title";
                  if (isset($_SESSION[order]))
                    $order = $_SESSION[order];
                  if (isset($_POST[order]))
                    $order = $_POST[order];

                  // save order variable in a session variable
                  $_SESSION["order"] = $order;

                  // radio buttons to select in which order the objects shall be shown
                  echo "<form action='obj_overview.php' method='POST'>";
                  echo "<input type='submit' value='Order by: '>";
                  if ($order == "author")
                    echo "   <input type='radio' name='order' value='author' checked='checked'>author";
                  else
                    echo "   <input type='radio' name='order' value='author'>author";
                  if ($order == "title")
                    echo "   <input type='radio' name='order' value='title' checked='checked'>title";
                  else
                    echo "   <input type='radio' name='order' value='title'>title";
                  if ($order == "year")
                    echo "   <input type='radio' name='order' value='year' checked='checked'>year";
                  else
                    echo "   <input type='radio' name='order' value='year'>year";
                  if ($order == "type")
                    echo "   <input type='radio' name='order' value='type' checked='checked'>type";
                  else
                    echo "   <input type='radio' name='order' value='type'>type";
                  if ($order == "status")
                    echo "   <input type='radio' name='order' value='status' checked='checked'>status";
                  else
                    echo "   <input type='radio' name='order' value='status'>status";
                  if ($order == "borrowDate")
                    echo "   <input type='radio' name='order' value='borrowDate' checked='checked'>borrowing date";
                  else
                    echo "   <input type='radio' name='order' value='borrowDate'>borrowing date";
                  if ($order == "returnDate")
                    echo "   <input type='radio' name='order' value='returnDate' checked='checked'>return date";
                  else
                    echo "   <input type='radio' name='order' value='returnDate'>return date";
                  if ($order == "user")
                    echo "   <input type='radio' name='order' value='user' checked='checked'>user";
                  else
                    echo "   <input type='radio' name='order' value='user'>user";
                  echo "</form><br><br>";

                  // start database connection for the superuser, with error handling
                  $db = mysql_connect("localhost", "librarySuperuser", "superuser");
                  if (!mysql_select_db ("stilibrary", $db)){
                    die ("Connection to database failed - superuser");
                  } // end if

                  // if the order-by item is one from the publication attributes
                  if ($order == "author" || $order == "title" || $order == "year" || $order == "type" || $order == "status") {
                    // build sql select publication string
                    $sqlSelectOrdPub = "SELECT pid, author, title, year, signature, type, status FROM publication ORDER BY '$order';";

                    // send query to database
                    $res = mysql_db_query("stilibrary", $sqlSelectOrdPub);
                    if (mysql_errno() != 0) {
                      // logging function call
                      $string = "Error: sqlSelectOrdPub: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlSelectOrdPub . "\n";
                      library_log($string);
                      echo ("Database error! - Please see log file for detailed information.<br><br>");
                    } // end if

                    // check if and how many results there are
                    $num = mysql_num_rows($res);
                    if ($num > 0) {
                      echo "<table cellspacing='0' cellpadding='5'>";
                      echo "<tr>";
                      echo "<td> <h3>title</h3> </td>";
                      echo "<td> <h3>author</h3> </td>";
                      echo "<td> <h3>year</h3> </td>";
                      echo "<td> <h3>type</h3> </td>";
                      echo "<td> <h3>status</h3> </td>";
                      echo "<td> <h3>borrowing date</h3> </td>";
                      echo "<td> <h3>return date</h3> </td>";
                      echo "<td> <h3>user</h3> </td>";
                      echo "</tr>";
                      $color=1;     // variable to indicate how to style a row
                      for ($i=0; $i<$num; $i++) {
                        // extract results from publication
                        $pid = mysql_result($res, $i, "pid");
                        $author = mysql_result($res, $i, "author");
                        if ($author == "NULL")
                          $author="";
                        $title = mysql_result($res, $i, "title");
                        $year = mysql_result($res, $i, "year");
                        if (($year == "NULL") || ($year == "0000"))
                          $year="";
                        $type = mysql_result($res, $i, "type");
                        $status = mysql_result($res, $i, "status");

                        // build sql select borrowing string
                        $sqlSelectOrdBor = "SELECT borrowDate, returnDate, user FROM borrowing WHERE publication = '$pid';";

                        // send query to database
                        $res2 = mysql_db_query("stilibrary", $sqlSelectOrdBor);
                        if (mysql_errno() != 0) {
                          // logging function call
                          $string = "Error: sqlSelectOrdBor: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlSelectOrdBor . "\n";
                          library_log($string);
                          echo ("Database error! - Please see log file for detailed information.<br><br>");
                        } // end if

                        // check if and how many results there are
                        $num2 = mysql_num_rows($res2);
                        if ($num2 > 0) {
                          // extract results from borrowing
                          $borrowDate = mysql_result($res2, 0, "borrowDate");
                          if ($borrowDate == "NULL" || $borrowDate == "0000-00-00")
                            $borrowDate="";
                          $returnDate = mysql_result($res2, 0, "returnDate");
                          if ($returnDate == "NULL" || $returnDate == "0000-00-00")
                            $returnDate="";
                          $user = mysql_result($res2, 0, "user");
                          if ($user == "NULL")
                            $user="";
                          // the username of the user wo borrowed the object is also needed
                          if ($user != ""){
                            // build sql select user string
                            $sqlSelectUser = "SELECT username FROM user WHERE uid = '$user'";

                            // send query to database
                            $res3 = mysql_db_query("stilibrary", $sqlSelectUser);
                            if (mysql_errno() != 0) {
                              // logging function call
                              $string = "Error: sqlSelectUser: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlSelectUser . "\n";
                              library_log($string);
                              echo ("Database error! - Please see log file for detailed information.<br><br>");
                            } // end if

                            // extract result from user
                            $username = mysql_result($res3, 0, "username");
                          } // end if
                        } // end if
                        else{
                          $username="";
                          $borrowDate="";
                          $returnDate="";
                        } // end else

                        // begin row and indicate color (class row)
                        if ($color) {
                          echo "<tr class='row'>";
                          $color=0;
                        } // end if
                        else {
                          echo "<tr>";
                          $color=1;
                        } // end else
                        echo "<td> <a href='obj_detail_overview.php?pid=$pid'> $title </a> </td>";
                        echo "<td> $author </td>";
                        echo "<td> $year </td>";
                        echo "<td> $type </td>";
                        echo "<td> $status </td>";
                        echo "<td> $borrowDate </td>";
                        echo "<td> $returnDate </td>";
                        echo "<td> $username </td>";
                        echo "</tr>";
                      } // end for
                      echo "</table>";
                    } // end if
                    else {
                      echo "<strong>No objects available!</strong><br><br>";
                    } // end else
                  } // end if

                  // if the order-by item is one from the borrowing attributes
                  else {
                    // build sql select borrowing string
                    $sqlSelectOrdBor = "SELECT borrowDate, returnDate, user, publication FROM borrowing ORDER by '$order';";

                    // send query to database
                    $res = mysql_db_query("stilibrary", $sqlSelectOrdBor);
                    if (mysql_errno() != 0) {
                      // logging function call
                      $string = "Error: sqlSelectOrdBor: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlSelectOrdBor . "\n";
                      library_log($string);
                      echo ("Database error! - Please see log file for detailed information.<br><br>");
                    } // end if

                    // check if and how many results there are
                    $num = mysql_num_rows($res);
                    if ($num > 0) {
                      echo "<table cellspacing='0' width=100%>";
                      echo "<tr>";
                      echo "<td> <h3>title</h3> </td>";
                      echo "<td> <h3>author</h3> </td>";
                      echo "<td> <h3>year</h3> </td>";
                      echo "<td> <h3>type</h3> </td>";
                      echo "<td> <h3>status</h3> </td>";
                      echo "<td> <h3>borrowing date</h3> </td>";
                      echo "<td> <h3>return date</h3> </td>";
                      echo "<td> <h3>user</h3> </td>";
                      echo "</tr>";

                      for ($i=0; $i<$num; $i++) {
                        // extract results from borrowing
                        $borrowDate = mysql_result($res, $i, "borrowDate");
                        $returnDate = mysql_result($res, $i, "returnDate");
                        if ($returnDate == "NULL" || $returnDate == "0000-00-00")
                          $returnDate="";
                        $user = mysql_result($res, $i, "user");
                        $publication = mysql_result($res, $i, "publication");

                        // build sql select user string
                        $sqlSelectUser = "SELECT username FROM user WHERE uid = '$user'";

                        // send query to database
                        $res3 = mysql_db_query("stilibrary", $sqlSelectUser);
                        if (mysql_errno() != 0) {
                          // logging function call
                          $string = "Error: sqlSelectUser: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlSelectUser . "\n";
                          library_log($string);
                          echo ("Database error! - Please see log file for detailed information.<br><br>");
                        } // end if

                        // extract result from user
                        $username = mysql_result($res3, 0, "username");

                        // build sql select publication string
                        $sqlSelectOrdPub = "SELECT pid, author, title, year, type, status FROM publication WHERE pid = '$publication';";

                        // send query to database
                        $res2 = mysql_db_query("stilibrary", $sqlSelectOrdPub);
                        if (mysql_errno() != 0) {
                          // logging function call
                          $string = "Error: sqlSelectOrdPub: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlSelectOrdPub . "\n";
                          library_log($string);
                          echo ("Database error! - Please see log file for detailed information.<br><br>");
                        } // end if

                        // extract results from publication
                        $pid = mysql_result($res2, 0, "pid");
                        $author = mysql_result($res2, 0, "author");
                        if ($author == "NULL")
                          $author="";
                        $title = mysql_result($res2, 0, "title");
                        $year = mysql_result($res2, 0, "year");
                        if (($year == "NULL") || ($year == "0000"))
                          $year="";
                        $type = mysql_result($res2, 0, "type");
                        $status = mysql_result($res2, 0, "status");

                        // begin row and indicate color (class row)
                        if ($color) {
                          echo "<tr class='row'>";
                          $color=0;
                        } // end if
                        else {
                          echo "<tr>";
                          $color=1;
                        } // end else
                        echo "<td> <a href='obj_detail_overview.php?pid=$pid'> $title </a> </td>";
                        echo "<td> $author </td>";
                        echo "<td> $year </td>";
                        echo "<td> $type </td>";
                        echo "<td> $status </td>";
                        echo "<td> $borrowDate </td>";
                        echo "<td> $returnDate </td>";
                        echo "<td> $username </td>";
                        echo "</tr>";
                      } // end for
                      echo "</table>";
                    } // end if
                    else {
                      echo "<strong>No objects available!</strong><br><br>";
                    } // end else
                  } // end else

                  // close database connection
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

