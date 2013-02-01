<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "priv_change_obj_search";

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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="priv_func_overview.php">Privileged functions</a> &gt; <a class="crumbTrail" href="change_obj_search.php">Change object - Search & list</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Change object - Object search</h2><br>

                <table cellpadding="0" cellspacing="5" border="0" width="70%">

                  <form action = "change_obj_list.php" method = "post">
                    <tr>
                      <td> <div align="left">signature</div> </td>
                      <td> <input type="text" name="signature" value="" size="30" maxlength="15"></td>
                    </tr>
                    <tr>
                      <td> <div align="left">title</div> </td>
                      <td> <input type="text" name="title" value="" size="30" maxlength="250"> </td>
                    </tr>
                    <tr>
                      <td> <div align="left">status</div> </td>
                      <td>
                        <select name ="status" size="1">
                          <option selected></option>
                          <option> new </option>
                          <option> available </option>
                          <option> not available </option>
                          <option> checked out </option>
                          <option> missing </option>
                        </select>
                      </td>
                    </tr>
                    <tr></tr><tr></tr>
                    <tr>
                      <td> <input type="submit" value="  Search  "> </td>
                      <td> <input type="reset" value="  Reset form  "> </td>
                    </tr>
                  </form>
                </table>
                <br><br>

                <h2>Change object - Object list</h2><br>

                <?php
                  // start database connection for the superuser, with error handling
                  $db = mysql_connect("localhost", "librarySuperuser", "superuser");
                  if (!mysql_select_db ("stilibrary", $db)){
                    die ("Connection to database failed - superuser");
                  } // end if

                  // write values to session variables
                  $_SESSION["act_change_obj_page"] = "search";

                  // send query to database
                  $res = mysql_db_query("stilibrary", "SELECT pid, author, title, year, signature, status FROM publication ORDER BY title;");
                  if (mysql_errno() != 0) {
                    // logging function call
                    $string = "Error: sqlSelectObj: " . mysql_errno() . ": " . mysql_error(). "\n";
                    library_log($string);
                    echo ("Database error! - Please see log file for detailed information.<br><br>");
                  }

                  // get the number of results
                  $num = mysql_num_rows($res);
                  if ($num > 0) {
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
                      // extract publication results
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
                    echo "<strong> No objects found! </strong><br>";

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

