<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "result";

  // checking if the user is already logged in
  $user_id = 0;
  if (isset ($_SESSION["user_id"]))
    $user_id = $_SESSION["user_id"];

  // checking if the logged-in user is a superuser
  $user_superuser = 0;
  if (isset($_SESSION["user_superuser"]))
    $user_superuser = $_SESSION["user_superuser"];
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

      <span class="crumbTrail"><a class="crumbTrail" href="sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="search.php">Search</a> &gt; <a class="crumbTrail" href="result_list.php?get_back=getBack">Search results</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Search results</h2><br>

                <?php
                  // the variable noSearch indicates whether a search has to be made
                  $noSearch=0;

                  // check whether all the objects from the database shall be shown
                  $search_all="";
                  if (isset($_GET["search_all"]))
                    $search_all = $_GET["search_all"];

                  // check if the user is getting back to this page from an object detail page
                  $get_back="";
                  if (isset($_GET["get_back"]))
                    $get_back = $_GET["get_back"];

                  // get the search string from the form, by POST
                  $string="";
                  if (isset($_POST["search"]))
                    $string = $_POST["search"];

                  // if the user gets back from an object detail page, the old sql select string is used from a session variable
                  if ($get_back != "") {
                    $sqlSelectObj = $_SESSION["search_string"];
                    if ($sqlSelectObj == "") {
                      $noSearch=1;
                      echo "<strong> No search words defined!</strong><br><br>";
                    } // end if
                  } // end if

                  // if this page is reached from the search page, we extract the new search string
                  else {
                    // if there is no search string, this is signaled to the user
                    if(($string == "") && ($search_all == "")) {
                      $noSearch=1;
                      echo "<strong> No search words defined!</strong><br><br>";
                    } // end if

                    // if the variable search_all is set, all the objects from the database are shown
                    if(($string == "") && ($search_all != "")) {
                      // build the database sql select string
                      $sqlSelectObj = "SELECT pid, author, title, year, signature, status FROM publication ORDER BY title";
                    } // end if

                    // the search string is split up, to see if there are more words to search for
                    if ($string != "") {
                      $arrayString = explode(" ", $string);
                      for ($i=0; $i<count($arrayString); $i++)
                        $arrayString[$i] = trim($arrayString[$i], " ");

                      // build the database sql select string
                      $sqlSelectObj = "SELECT pid, author, title, year, signature, status FROM publication WHERE author LIKE '%$arrayString[0]%' OR title LIKE '%$arrayString[0]%' OR subtitle LIKE '%$arrayString[0]%' OR keywords LIKE '%$arrayString[0]%'";

                      if (count($arrayString) > 1) {
                        for ($i=1; $i<count($arrayString); $i++) {
                          $sqlSelectObj .= " OR author LIKE '%$arrayString[$i]%' OR title LIKE '%$arrayString[$i]%' OR subtitle LIKE '%$arrayString[$i]%' OR keywords LIKE '%$arrayString[$i]%'";
                        } // end for
                      } // end if

                      // order results by title
                      $sqlSelectObj .= " ORDER BY title;";
                    } // end if $string != ""

                    // the new search string is saved in a session variable
                    $_SESSION["search_string"] = $sqlSelectObj;
                  } // end else, get_back = ""

                  // the query is only sent to the database, if there is a search
                  if (!$noSearch) {
                    // start database connection for the default user, with error handling
                    $db = mysql_connect("localhost", "libraryDefault", "default");
                    if (!mysql_select_db ("stilibrary", $db)){
                      die ("Connection to database failed - default user");
                    } // end if

                    // send query to the database
                    $res = mysql_db_query("stilibrary", $sqlSelectObj);
                    if (mysql_errno() != 0) {
                      // logging function call
                      $string = "Error: sqlSelectObj: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlSelectObj . "\n";
                      library_log($string);
                      echo ("Database error! - Please see log file for detailed information.<br><br>");
                    }

                    // get number of result rows
                    $num = mysql_num_rows($res);

                    if ($num > 0) {
                      echo "<table cellspacing='0' cellpadding='5' >";
                      echo "<tr>";
                      echo "<td> <h3>title</h3> </td>";
                      echo "<td> <h3>author</h3> </td>";
                      echo "<td> <h3>year</h3> </td>";
                      echo "<td> <h3>signature</h3> </td>";
                      echo "<td> <h3>status</h3> </td>";
                      echo "<td> <h3>borrowed by</h3> </td>";
                      echo "<td> <h3>return date</h3> </td>";
                      echo "</tr>";
                      $color=1;     // variable to indicate how to style a row
                      for ($i=0; $i<$num; $i++)
                      {
                        // extract results
                        $pid = mysql_result($res, $i, "pid");
                        $author = mysql_result($res, $i, "author");
                        if ($author == 'NULL')
                          $author = '';
                        $title = mysql_result($res, $i, "title");
                        $year = mysql_result($res, $i, "year");
                        if (($year == 'NULL') || ($year == '0000'))
                          $year = '';
                        $signature = mysql_result($res, $i, "signature");
                        $status = mysql_result($res, $i, "status");

                        // build sql select borrowing string
                        $sqlSelectOrdBor = "SELECT returnDate, user FROM borrowing WHERE publication = '$pid';";

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
                        echo "<td> <a href='obj_detail.php?pid=$pid'> $title	</a> </td>";
                        echo "<td> $author </td>";
                        echo "<td> $year </td>";
                        echo "<td> <a href='obj_detail.php?pid=$pid'> $signature </a ></td>";
                        echo "<td> $status </td>";
                        echo "<td> $username </td>";
                        echo "<td> $returnDate </td>";
                        echo "</tr>";
                      } // end for

                      echo "</table>";
                    } // end if
                    else
                      echo "<strong>No objects found!</strong>";

                    // close database connection
                    mysql_close($db);
                  } // end if (!noSearch)
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

