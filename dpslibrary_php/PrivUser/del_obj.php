<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "priv_del_obj";

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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="priv_func_overview.php">Privileged functions</a> &gt; <a class="crumbTrail" href="del_obj_search.php">Delete object - Search & list</a> &gt; Delete object</span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Delete object</h2><br>

                <?php

                  $pid=0;
                  if (isset($_GET["pid"]))
                    $pid = $_GET["pid"];

                  // start database connection for the superuser, with error handling
                  $db = mysql_connect("localhost", "librarySuperuser", "superuser");
                  if (!mysql_select_db ("stilibrary", $db)){
                    die ("Connection to database failed - superuser");
                  } // end if

                  // send select publication query to database
                  $res = mysql_db_query("stilibrary", "SELECT * FROM publication WHERE pid = '$pid';");
                  if (mysql_errno() != 0) {
                    // logging function call
                    $string = "Error: sqlSelectObj: " . mysql_errno() . ": " . mysql_error(). "\n";
                    library_log($string);
                    echo ("Database error! - Please see log file for detailed information.<br><br>");
                  } // end if

                  // extract publication results
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

                  // check if the variable askAgain has been set
                  $askAgain=0;
                  if (isset ($_GET["askAgain"]))
                    $askAgain = $_GET["askAgain"];

                  // if the variable askAgain is set, the superuser has got to confirm his choice to delete this object
                  if ($askAgain == 1) {
                    echo "<strong>Do you really want to delete this object?</strong><br><br>";
                    echo "<table cellspacing='10'>";
                    echo "<form action = 'del_obj_conf.php' method = 'post'>";
                  } // end if
                  else {
                    echo "<table cellspacing='10'>";
                    echo "<form action = 'del_obj.php?askAgain=1&pid=$pid' method = 'post'>";
                  } // end else

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

                  echo "<input type='hidden' name='pid' value='$pid'>";
                  echo "<tr></tr><tr></tr><tr></tr>";

                  if ($askAgain == 1) {
                    echo "<tr> <td> <input type='submit' value='  Yes, delete object  '> </td>";
                    echo "</form>";

                    if ($_SESSION["act_del_obj_page"] == "list") {
                      echo "<form action = 'del_obj_list.php' method = 'GET'>";
                      echo "<td> <input type='submit' name='back' value='  No, get back to object list  '></td>";
                      echo "</tr></form>";
                    } // end if
                    else {
                      echo "<form action = 'del_obj_search.php' method = 'GET'>";
                      echo "<td> <input type='submit' name='back' value='  No, get back to object list  '></td>";
                      echo "</tr></form>";
                    } // end else
                  } // end if
                  else {
                    echo "<tr> <td> <input type='submit' value='  Delete object  '> </td>";
                    echo "</form>";

                    if ($_SESSION["act_del_obj_page"] == "list") {
                      echo "<form action = 'del_obj_list.php' method = 'GET'>";
                      echo "<td> <input type='submit' name='back' value='  Get back to object list  '></td>";
                      echo "</tr></form>";
                    } // end if
                    else {
                      echo "<form action = 'del_obj_search.php' method = 'GET'>";
                      echo "<td> <input type='submit' name='back' value='  Get back to object list  '></td>";
                      echo "</tr></form>";
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
      // including links
      include("menue3.inc");
    ?>

  </body>

</html>

