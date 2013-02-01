<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "priv_change_user_conf";

  // start session, check if the user is already logged in and if he is a superuser or not
  include ("../check_user.inc");
  include ("../library_functions.inc");

  // check if the logged-in is a superuser
  if (!$user_superuser && isset($_SESSION["user_id"])){
    header("Location: ../User/sti_library.php?error=1");
    exit;
  } // end if

  // extract values from POST
  $uid=0;
  if (isset($_POST["uid"]))
    $uid = $_POST["uid"];
  $first_name="";
  if (isset($_POST["firstName"]))
    $first_name = $_POST["firstName"];
  $last_name="";
  if (isset($_POST["lastName"]))
    $last_name = $_POST["lastName"];
  $user_name="";
  if (isset($_POST["username"]))
    $user_name = $_POST["username"];
  $password="";
  if (isset($_POST["password"]))
    $password = $_POST["password"];
  $email="";
  if (isset($_POST["email"]))
    $email = $_POST["email"];
  $reminder=1;
  if (isset($_POST["reminder"]))
    $reminder = $_POST["reminder"];
  $superuser=0;
  if (isset($_POST["superuser"]))
    $superuser = $_POST["superuser"];

  // write values to session variables
  $_SESSION["uid"] = $uid;
  $_SESSION["firstName"] = $first_name;
  $_SESSION["lastName"] = $last_name;
  $_SESSION["username"] = $user_name;
  $_SESSION["password"] = $password;
  $_SESSION["email"] = $email;
  $_SESSION["reminder"] = $reminder;
  $_SESSION["superuser"] = $superuser;

  // all the fields have to be filled out
  if (($first_name == "") || ($last_name == "") || ($user_name == "") || ($password == "") || ($email == "")){
    header("Location: change_user.php?error=2");
    exit;
  } // end if

  // the username mustn't be longer than 16 letters
  if (strlen($user_name) > 16){
    header("Location: change_user.php?error=4");
    exit;
  } // end if

  // start database connection for the superuser, with error handling
  $db = mysql_connect("localhost", "librarySuperuser", "superuser");
  if (!mysql_select_db ("stilibrary", $db)){
    die ("Connection to database failed - superuser");
  } // end if

  // extract the old username from a session variable
  $old_username="";
  if (isset($_SESSION["old_username"]))
    $old_username = $_SESSION["old_username"];

  // send select query to database
  $res = mysql_db_query("stilibrary", "SELECT username FROM user WHERE username = '$user_name';");
  if (mysql_errno() != 0) {
    // logging function call
    $string = "sqlSelectUsername: " . mysql_errno() . ": " . mysql_error(). "\n";
    library_log($string);
    echo ("Database error! - Please see log file for detailed information.<br><br>");
  } // end if

  // an error code is set, if the chosen username exists already. The user is sent back to the previous page.
  $num = mysql_num_rows($res);
  if (($num > 0) && (mysql_result($res, 0, "username") != $old_username)){
    // close database connection
    mysql_close($db);

    header("Location: change_user.php?error=1");
    exit;
  } // end if

  // extract the old email from a session variable
  $old_email="";
  if (isset($_SESSION["old_email"]))
    $old_email = $_SESSION["old_email"];

  // send select query to database
  $res2 = mysql_db_query("stilibrary", "SELECT email FROM user WHERE email = '$email';");
  if (mysql_errno() != 0) {
    // logging function call
    $string = mysql_errno() . ": " . mysql_error(). "\n";
    library_log($string);
    echo ("Database error! - Please see log file for detailed information.<br><br>");
  }

  // an error code is set, if the chosen email exists already. The user is sent back to the previous page.
  $num2 = mysql_num_rows($res2);
  if (($num2 > 0) && (mysql_result($res2, 0, "email") != $old_email)){
    // close database connection
    mysql_close($db);

    header("Location: change_user.php?error=3");
    exit;
  } // end if

  // close database connection
  mysql_close($db);
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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="priv_func_overview.php">Privileged functions</a> &gt; <a class="crumbTrail" href="change_user_search.php">Change user - Search & list</a> &gt; Change user information</span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Change user information</h2><br>

                <?php
                  if ($reminder == "yes")
                    $reminder = 1;
                  else
                    $reminder = 0;

                  if ($superuser == "yes")
                    $superuser = 1;
                  else
                    $superuser = 0;

                  // extract the old values from session variables
                  $old_firstName="";
                  if (isset($_SESSION["old_firstName"]))
                    $old_firstName = $_SESSION["old_firstName"];
                  $old_lastName="";
                  if (isset($_SESSION["old_lastName"]))
                    $old_lastName = $_SESSION["old_lastName"];
                  $old_password="";
                  if (isset($_SESSION["old_password"]))
                    $old_password = $_SESSION["old_password"];
                  $old_reminder="";
                  if (isset($_SESSION["old_reminder"]))
                    $old_reminder = $_SESSION["old_reminder"];
                  $old_superuser="";
                  if (isset($_SESSION["old_superuser"]))
                    $old_superuser = $_SESSION["old_superuser"];

                  // check if one of the user values has been changed
                  if (($old_firstName == $first_name) && ($old_lastName == $last_name) && ($old_username == $user_name) && ($old_password == $password) && ($old_email == $email) && ($old_reminder == $reminder) && ($old_superuser == $superuser)) {
                    echo "<strong> User values haven't been changed!</strong><br><br>";
                  } // end if

                  else {
                    // start database connection for the superuser, with error handling
                    $db = mysql_connect("localhost", "librarySuperuser", "superuser");
                    if (!mysql_select_db ("stilibrary", $db)){
                      die ("Connection to database failed - superuser");
                    } // end if

                    // check if the first_name contains a single quote " ' "
                    if(strpos($first_name, "'") != 0) {
                      $first_name = str_replace("'","\'", $first_name);
                    }
                    // check if the last_name contains a single quote " ' "
                    if(strpos($last_name, "'") != 0) {
                      $last_name = str_replace("'","\'", $last_name);
                    }
                    // check if the user_name contains a single quote " ' "
                    if(strpos($user_name, "'") != 0) {
                      $user_name = str_replace("'","\'", $user_name);
                    }
                    // check if the password contains a single quote " ' "
                    if(strpos($password, "'") != 0) {
                      $password = str_replace("'","\'", $password);
                    }
                    // check if the email contains a single quote " ' "
                    if(strpos($email, "'") != 0) {
                      $email = str_replace("'","\'", $email);
                    }

                    // build sql update user string if password has not been changed
                    // this is necessary to not encrypt passwords more than once!
                    if ($old_password == $password) {
                      $sqlUpdateUser = "UPDATE user SET firstName = '$first_name', lastName = '$last_name', userName = '$user_name', password = '$password', email = '$email', reminder = '$reminder', superuser = '$superuser' WHERE uid = '$uid';";
                    }
                    else {
                      // build sql update user string if password has been changed
                      $sqlUpdateUser = "UPDATE user SET firstName = '$first_name', lastName = '$last_name', userName = '$user_name', password = md5('$password'), email = '$email', reminder = '$reminder', superuser = '$superuser' WHERE uid = '$uid';";
                    }
                    // send query to database
                    mysql_db_query("stilibrary", $sqlUpdateUser);
                    if (mysql_errno() != 0) {
                      // logging function call
                      $string = "sqlUpdateUser: " . mysql_errno() . ": " . mysql_error(). "\nsqlUpdateUser: " . $sqlUpdateUser . "\n";
                      library_log($string);
                      echo ("Database error! - Please see log file for detailed information.<br><br>");
                    } // end if

                    // check if update was successfull
                    $num = mysql_affected_rows();
                    if ($num>0) {
                      // logging function call
                      $string = "Successfully changed the user " . $user_name . "'s information\n";
                      library_log($string);

                      // build sql select user string and send query to database
                      $res = mysql_db_query("stilibrary", "SELECT firstName, lastName, username, email, reminder, superuser FROM user WHERE uid = '$uid';");
                      if (mysql_errno() != 0) {
                        // logging function call
                        $string = "sqlSelectUser: " . mysql_errno() . ": " . mysql_error(). "\n";
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

                      echo "<strong> You've succesfully changed this user's information in the database. </strong>";
                      echo "<br><br>";
                      echo "<table cellspacing='10'>";
                      echo "<tr> <td> <div align='right'><strong> first name </strong></div> </td>";
                      echo "<td>", $first_name, "</td> </tr>";
                      echo "<tr> <td> <div align='right'><strong> last name </strong></div> </td>";
                      echo "<td>", $last_name, "</td> </tr>";
                      echo "<tr> <td> <div align='right'><strong> username </strong></div> </td>";
                      echo "<td>", $user_name, "</td> </tr>";
                      echo "<tr> <td> <div align='right'><strong> email </strong></div> </td>";
                      echo "<td>", $email, "</td> </tr>";
                      echo "<tr> <td> <div align='right'><strong> reminder </strong></div> </td>";
                      if ($reminder == 1)
                        echo "<td> yes </td> </tr>";
                      else
                        echo "<td> no </td> </tr>";
                      echo "<tr> <td> <div align='right'><strong> superuser </strong></div> </td>";
                      if ($superuser == 1)
                        echo "<td> yes </td> </tr>";
                      else
                        echo "<td> no </td> </tr>";
                      echo "</table> <br><br>";
                    } // end if
                    else {
                      // logging function call
                      $string = "Couldn't change the user " . $user_name . "'s information\n";
                      library_log($string);
                      echo "<br><strong> The user's information hasn't been changed. </strong>";
                    }

                    // close database connection
                    mysql_close($db);

                  } // end else

                  echo "<br><br><br>";
                  echo "<table><tr>";
                  echo "<form action='change_user_search.php' method = 'GET'>";
                  echo "<td><input type='submit' name='change_button' value='  Change user search  '></td></form>";
                  if ($_SESSION["act_change_user_page"] == "list") {
                    echo "<form action = 'change_user_list.php' method = 'GET'>";
                    echo "<td> <input type='submit' name='back' value='  Get back to user list  '></td></form>";
                  } // end if
                  else {
                    echo "<form action = 'change_user_search.php' method = 'GET'>";
                    echo "<td> <input type='submit' name='back' value='  Get back to user list  '></td></form>";
                  } // end else
                  echo "<form action='priv_func_overview.php' method = 'GET'>";
                  echo "<td><input type='submit' name='priv_func_button' value= 'Privileged functions overview'></td></form>";
                  echo "</tr></table>";

                  // delete session variables
                  unset($_SESSION["old_firstName"]);
                  unset($_SESSION["old_lastName"]);
                  unset($_SESSION["old_username"]);
                  unset($_SESSION["old_password"]);
                  unset($_SESSION["old_email"]);
                  unset($_SESSION["old_reminder"]);
                  unset($_SESSION["old_superuser"]);
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

