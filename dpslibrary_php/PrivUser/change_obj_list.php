<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "priv_change_obj_list";

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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="priv_func_overview.php">Privileged functions </a> &gt; <a class="crumbTrail" href="change_obj_search.php">Change object - Search & list</a> &gt; Object list</span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Change Object - Object list </h2><br>

                <?php
                  // start database connection for the superuser, with error handling
                  $db = mysql_connect("localhost", "librarySuperuser", "superuser");
                  if (!mysql_select_db ("stilibrary", $db)){
                    die ("Connection to database failed - superuser");
                  } // end if

                  // extract the search string from a session variable
                  $string = "";
                  if (isset($_SESSION["change_obj_string"]))
                    $string = $_SESSION["change_obj_string"];

                  // extract the variable back from GET
                  $back = "";
                  if (isset($_GET["back"]))
                    $back = $_GET["back"];

                  // if the user comes back to this list he gets his old search results from the saved session string
                  if ($back != "")
                    $sqlSelectObj = $string;

                  // the list is called from the search form
                  else {
                    // build sql select publication string
                    $sqlSelectObj = "SELECT pid, author, title, year, signature, status FROM publication WHERE ";
                    $sqlSelectObjControl = "SELECT pid, author, title, year, signature, status FROM publication WHERE ";
                    // check which attribute has been indicated and continue sql select string
                    if (($title = $_POST["title"]) != "")
                      $sqlSelectObj .= " title LIKE '%$title%'";
                    if (($signature = $_POST["signature"]) != ""){
                      if ($sqlSelectObj == $sqlSelectObjControl)
                        $sqlSelectObj .= " signature = '$signature'";
                      else
                        $sqlSelectObj .= " AND signature = '$signature'";
                    } // end if
                    if (($status = $_POST["status"]) != ""){
                      if ($sqlSelectObj == $sqlSelectObjControl)
                        $sqlSelectObj .= " status = '$status'";
                      else
                        $sqlSelectObj .= " AND status = '$status'";
                    } // end if

                    // check whether there are search words defined
                    $noSearch = 0;
                    if ($sqlSelectObj == $sqlSelectObjControl) {
                      $noSearch = 1;
                      echo "<br><br><strong>No search words defined</strong>";
                    } // end if
                    else
                      $sqlSelectObj .= " ORDER BY title;";
                  } // end else

                  if (!$noSearch) {
                    // send query to database
                    $res = mysql_db_query("stilibrary", $sqlSelectObj);
                    if (mysql_errno() != 0) {
                      // logging function call
                      $string = "Error: sqlSelectObj: " . mysql_errno() . ": " . mysql_error(). "\n";
                      library_log($string);
                      echo ("Database error! - Please see log file for detailed information.<br><br>");
                    } // end if

                    // write values to session variables
                    $_SESSION["act_change_obj_page"] = "list";
                    $_SESSION["change_obj_string"] = $sqlSelectObj;

                    // get number of results
                    $num = mysql_num_rows($res);
                    if ($num > 0){
                      echo "<table cellspacing='0' cellpadding='5'>";
                      echo "<tr>";
                      echo "<td> <h3>title</h3> </td>";
                      echo "<td> <h3>author</h3> </td>";
                      echo "<td> <h3>year</h3> </td>";
                      echo "<td> <h3>signature</h3> </td>";
                      echo "<td> <h3>status</h3> </td>";
                      echo "</tr>";
                      $color=1;     // variable to indicate how to style a row
                      for ($i=0; $i<$num; $i++)
                      {
                        $pid = mysql_result($res, $i, "pid");
                        $author = mysql_result($res, $i, "author");
                        if ($author == "NULL")
                          $author="";
                        $title = mysql_result($res, $i, "title");
                        $year = mysql_result($res, $i, "year");
                        if (($year == "NULL") || ($year == "0000"))
                          $year="";
                        $signature = mysql_result($res, $i, "signature");
                        $status = mysql_result($res, $i, "status");
                        // begin row and indicate color (class row)
                        if ($color) {
                          echo "<tr class='row'>";
                          $color=0;
                        } // end if
                        else {
                          echo "<tr>";
                          $color=1;
                        } // end else
                        echo "<td> <a href='change_obj.php?pid=$pid'> $title </a> </td>";
                        echo "<td> $author </td>";
                        echo "<td> $year </td>";
                        echo "<td> <a href='change_obj.php?pid=$pid'> $signature </a ></td>";
                        echo "<td> $status </td>";
                        echo "</tr>";
                      } // end for
                      echo "</table>";
                    } // end if
                    else
                      echo "<br><br> <strong>No object found </strong><br><br>";
                  } // end if

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

