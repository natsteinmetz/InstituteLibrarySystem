<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "priv_change_user_search";

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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="priv_func_overview.php">Privileged functions</a> &gt; <a class="crumbTrail" href="change_user_search.php">Change user - Search & list</a> </span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Change user - Search user</h2><br>

                <!-- form to search for a user -->

                <table cellpadding="0" cellspacing="5" border="0" width="70%">

                  <form action = "change_user_list.php" method = "post">
                    <tr>
                      <td> <div align="left">first name</div> </td>
                      <td> <input type="text" name="firstName" value="" size="30" maxlength="50"></td>
                    </tr>
                    <tr>
                      <td> <div align="left">last name</div> </td>
                      <td> <input type="text" name="lastName" value="" size="30" maxlength="50"> </td>
                    </tr>
                    <tr>
                      <td> <div align="left">username</div> </td>
                      <td> <input type="text" name="username" value="" size="30" maxlength="50"> </td>
                    </tr>
                    <tr>
                      <td> <div align="left">email</div> </td>
                      <td> <input type="text" name="email" value="" size="30" maxlength="50"> </td>
                    </tr>
                    <tr>
                      <td> <div align="left">reminder</div> </td>
                      <td> <input type="radio" name="reminder" value="yes" > Yes &#160;&#160;&#160;&#160;<input type="radio" name="reminder" value="no"> No </td>
                    </tr>

                    <tr>
                      <td> <div align="left">superuser</div> </td>
                      <td> <input type="radio" name="superuser" value="yes"> Yes &#160;&#160;&#160;&#160;<input type="radio" name="superuser" value="no"> No </td>
                    </tr>
                    <tr></tr><tr></tr>

                    <tr>
                      <td> <input type="submit" value="  Search  "> </td>
                      <td> <input type="reset" value="  Reset form  "> </td>
                    </tr>
                  </form>
                </table>

                <br><br>

                <h2>Change user - User list</h2><br>

                <?php

                  // start database connection for the superuser, with error handling
                  $db = mysql_connect("localhost", "librarySuperuser", "superuser");
                  if (!mysql_select_db ("stilibrary", $db)){
                    die ("Connection to database failed - superuser");
                  } // end if

                  // write values to session variables
                  $_SESSION["act_change_user_page"] = "search";

                  // send select user query to database
                  $res = mysql_db_query("stilibrary", "SELECT uid, firstName, lastName, username, email FROM user ORDER BY lastName;");
                  if (mysql_errno() != 0) {
                    // logging function call
                    $string = mysql_errno() . ": " . mysql_error(). "\n";
                    library_log($string);
                    echo ("Database error! - Please see log file for detailed information.<br><br>");
                  } // end if

                  // get number of results
                  $num = mysql_num_rows($res);
                  if ($num > 0) {
                    echo "<table cellspacing='0' cellpadding='5'>";
                    echo "<tr>";
                    echo "<td> <h3>first name</h3> </td>";
                    echo "<td> <h3>last name</h3> </td>";
                    echo "<td> <h3>username</h3> </td>";
                    echo "<td> <h3>email</h3> </td>";
                    echo "</tr>";
                    $color=1;     // variable to indicate how to style a row
                    for ($i=0; $i<$num; $i++)
                    {
                      // extract user results
                      $uid = mysql_result($res, $i, "uid");
                      $first_name = mysql_result($res, $i, "firstName");
                      $last_name = mysql_result($res, $i, "lastName");
                      $user_name = mysql_result($res, $i, "username");
                      $email = mysql_result($res, $i, "email");
                      // begin row and indicate color (class row)
                        if ($color) {
                          echo "<tr class='row'>";
                          $color=0;
                        } // end if
                        else {
                          echo "<tr>";
                          $color=1;
                        } // end else
                      echo "<td> $first_name </td>";
                      echo "<td> $last_name </a> </td>";
                      echo "<td> <a href='change_user.php?uid=$uid'> $user_name </td>";
                      echo "<td> $email </td> </tr>";
                    } // end for

                    echo "</table>";
                  } // end if
                  else
                      echo "<br><br><strong> No user found </strong><br><br>";

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

