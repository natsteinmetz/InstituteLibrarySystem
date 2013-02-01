<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "return_list";

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

      <span class="crumbTrail"><a class="crumbTrail" href="sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="return_obj_list.php">Return book list</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Return book list</h2><br>

                <?php

                  // start database connection for the normal user, with error handling
                  $db = mysql_connect("localhost", "libraryUser", "user");
                  if (!mysql_select_db ("stilibrary", $db)){
                    die ("Connection to database failed - normal user");
                  } // end if

                  // extracting the user id from a session variable
                  $uid = 0;
                  if (isset($_SESSION["user_id"]))
                    $uid = $_SESSION["user_id"];

                  // this variable is set if the user chooses to return all his books
                  $return_all="";
                  if (isset ($_GET["return_all"]))
                    $return_all = $_GET["return_all"];

                  // check whether this user has got books to be returned and build sql select borrowing string
                  $sqlSelectBor = "SELECT borrowDate, returnDate, publication FROM borrowing WHERE user = '$uid' ORDER BY borrowDate;";
                  // send query to database
                  $res = mysql_db_query("stilibrary", $sqlSelectBor);
                  if (mysql_errno() != 0) {
                    // logging function call
                    $string = "Error: sqlSelectBor: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlSelectBor . "\n";
                    library_log($string);
                    echo ("Database error! - Please see log file for detailed information.<br><br>");
                  }

                  // get number of results
                  $num = mysql_num_rows($res);

                  // we only continue here, if the user has books to be returned
                  if ($num > 0) {
                    // all the books of this user are shown and he can choose to return one book or to return all his books
                    // if the user has chosen to return all his books, he has got to confirm this choice
                    if ($return_all != "")
                      echo "<strong>Do you really want to return all books?</strong><br><br>";

                    echo "<table cellspacing='0' cellpadding='5'>";
                    echo "<tr>";
                    echo "<td> <h3>title</h3> </td>";
                    echo "<td> <h3>author</h3> </td>";
                    echo "<td> <h3>year</h3> </td>";
                    echo "<td> <h3>signature</h3> </td>";
                    echo "<td> <h3>borrow date</h3> </td>";
                    echo "<td> <h3>return date</h3> </td>";
                    echo "</tr>";
                    $color=1;     // variable to indicate how to style a row
                    for ($i=0; $i<$num; $i++) {
                      // extract results
                      $borrowDate = mysql_result($res, $i, "borrowDate");
                      $returnDate = mysql_result($res, $i, "returnDate");
                      if ($returnDate == "0000-00-00")
                        $returnDate = "";
                      $pid = mysql_result($res, $i, "publication");

                      // build sql select publication string
                      $sqlSelectObj = "SELECT author, title, year, signature FROM publication WHERE pid = '$pid';";

                      // send query to database
                      $res2 = mysql_db_query("stilibrary", $sqlSelectObj);
                      if (mysql_errno() != 0) {
                        // logging function call
                        $string = "Error: sqlSelectObj: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlSelectObj . "\n";
                        library_log($string);
                        echo ("Database error! - Please see log file for detailed information.<br><br>");
                      }

                      // extract results
                      $author = mysql_result($res2, 0, "author");
                      $title = mysql_result($res2, 0, "title");
                      $year = mysql_result($res2, 0, "year");
                      $signature = mysql_result($res2, 0, "signature");

                      // begin row and indicate color (class row)
                        if ($color) {
                          echo "<tr class='row'>";
                          $color=0;
                        } // end if
                        else {
                          echo "<tr>";
                          $color=1;
                        } // end else
                      echo "<td> <a href='return_obj.php?pid=$pid'> $title </a> </td>";
                      echo "<td> $author </td>";
                      echo "<td> $year </td>";
                      echo "<td> <a href='return_obj.php?pid=$pid'> $signature </a ></td>";
                      echo "<td> $borrowDate </td>";
                      echo "<td> $returnDate </td>";
                      echo "</tr>";
                    } // end for

                    echo "</table>";
                    echo "<br><br>";
                    echo "<table cellspacing='10'>";
                    echo "<tr>";
                    if ($return_all != "") {
                      echo "<form action = 'return_obj_conf.php' method = 'GET'>";
                      echo "<td><input type='submit' name='return_all' value='Yes, return all books'></td>";
                      echo "</form>";
                      echo "<form action = 'return_obj_list.php' method = 'GET'>";
                      echo "<td><input type='submit' name='get_back' value='No, back to book list'></td>";
                      echo "</form>";
                    } // end if
                    else {
                      echo "<form action = 'return_obj_list.php' method = 'GET'>";
                      echo "<td><input type='submit' name='return_all' value='Return all books'></td>";
                      echo "</form>";
                    } // end else
                    echo "</tr>";
                    echo "</table>";
                  } // end if
                  else
                    echo "<strong>You have no books to return to the library!</strong>";

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

