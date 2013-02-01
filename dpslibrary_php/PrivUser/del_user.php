<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "priv_del_user";

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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="priv_func_overview.php">Privileged functions</a> &gt; <a class="crumbTrail" href="del_user_list.php">Delete user - Search & list</a> &gt; Delete user</span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Delete user</h2><br>

                <?php
                  // extract user id from GET
                  $uid=0;
                  if (isset($_GET["uid"]))
                    $uid = $_GET["uid"];

                  // start database connection for the superuser, with error handling
                  $db = mysql_connect("localhost", "librarySuperuser", "superuser");
                  if (!mysql_select_db ("stilibrary", $db)){
                    die ("Connection to database failed - superuser");
                  } // end if

                  // send select user query to database
                  $res = mysql_db_query("stilibrary", "SELECT firstName, lastName, username, email, reminder, superuser FROM user WHERE uid = '$uid';");
                  if (mysql_errno() != 0) {
                    // logging function call
                    $string = "Error: sqlSelectUser: " . mysql_errno() . ": " . mysql_error(). "\n";
                    library_log($string);
                    echo ("Database error! - Please see log file for detailed information.<br><br>");
                  } // end if

                  // extract user results
                  $first_name = mysql_result($res, 0, "firstName");
                  $last_name = mysql_result($res, 0, "lastName");
                  $user_name = mysql_result($res, 0, "username");
                  $email = mysql_result($res, 0, "email");
                  $reminder = mysql_result($res, 0, "reminder");
                  $superuser = mysql_result($res, 0, "superuser");

                  // check if the variable askAgain has been set
                  $askAgain=0;
                  if (isset ($_GET["askAgain"]))
                    $askAgain = $_GET["askAgain"];

                  // if the variable askAgain is set, the superuser has got to confirm his choice to delete this user
                  if ($askAgain == 1) {
                    echo "<strong>Do you really want to delete this user?</strong><br><br>";
                    echo "<table cellspacing='10'>";
                    echo "<form action = 'del_user_conf.php' method = 'post'>";
                  } // end if
                  else {
                    echo "<table cellspacing='10'>";
                    echo "<form action = 'del_user.php?askAgain=1&uid=$uid' method = 'post'>";
                  } // end else

                  echo "<tr> <td> <div align='right'><strong>first name</strong></div> </td>";
                  echo "<td> $first_name </td> </tr>";
                  echo "<tr> <td> <div align='right'><strong>last name</strong></div> </td>";
                  echo "<td> $last_name </td> </tr>";
                  echo "<tr> <td> <div align='right'><strong>username</strong></div> </td>";
                  echo "<td> $user_name </td> </tr>";
                  echo "<tr> <td> <div align='right'><strong>email</strong></div> </td>";
                  echo "<td> $email </td> </tr>";
                  if ($reminder == 1) {
                    echo "<tr> <td> <div align='right'><strong>reminder</strong></div> </td>";
                    echo "<td> yes </td> </tr>";
                  }
                  else {
                    echo "<tr> <td> <div align='right'><strong>reminder</strong></div> </td>";
                    echo "<td> no </td> </tr>";
                  }
                  if ($superuser == 1) {
                    echo "<tr> <td> <div align='right'><strong>superuser</strong></div> </td>";
                    echo "<td> yes </td> </tr>";
                  }
                  else {
                    echo "<tr> <td> <div align='right'><strong>superuser</strong></div> </td>";
                    echo "<td> no </td> </tr>";
                  }
                  echo "<input type='hidden' name='uid' value='$uid'>";
                  echo "<tr></tr><tr></tr><tr></tr>";

                  if ($askAgain == 1) {
                    echo "<tr> <td> <input type='submit' value='  Yes, delete user  '> </td>";
                    echo "</form>";

                    if ($_SESSION["act_del_user_page"] == "list") {
                      echo "<form action = 'del_user_list.php' method = 'GET'>";
                      echo "<td> <input type='submit' name='back' value='  No, get back to user list  '></td>";
                      echo "</tr></form>";
                    } // end if
                    else {
                      echo "<form action = 'del_user_search.php' method = 'GET'>";
                      echo "<td> <input type='submit' name='back' value='  No, get back to user list  '></td>";
                      echo "</tr></form>";
                    } // end else
                  } // end if
                  else {
                    echo "<tr> <td> <input type='submit' value='  Delete user  '> </td>";
                    echo "</form>";

                    if ($_SESSION["act_del_user_page"] == "list") {
                      echo "<form action = 'del_user_list.php' method = 'GET'>";
                      echo "<td> <input type='submit' name='back' value='  Get back to user list  '></td>";
                      echo "</tr></form>";
                    } // end if
                    else {
                      echo "<form action = 'del_user_search.php' method = 'GET'>";
                      echo "<td> <input type='submit' name='back' value='  Get back to user list  '></td>";
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

