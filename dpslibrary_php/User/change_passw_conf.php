<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "passw_conf";

  // check if the user is already logged in and if he is a superuser or not
  include ("../check_user.inc");
  include ("../library_functions.inc");

  // start database connection for the normal user, with error handling
  $db = mysql_connect("localhost", "libraryUser", "user");
  if (!mysql_select_db ("stilibrary", $db)){
    die ("Connection to database failed - normal user");
  } // end if

  // extract password variables via POST
  $old_passw = $_POST["old_passw"];
  $new_passw = $_POST["new_passw"];
  $new_passw2 = $_POST["new_passw2"];

  // extract user id variable from a session variable
  $user_id = $_SESSION["user_id"];

  // check if the two entries of the new password are identical
  if ($new_passw != $new_passw2){
    header("Location: change_passw.php?error=1");
    exit;
  } // end if

  // if the entries are identical
  else {

    // check if the password contains a single quote " ' "
    if(strpos($old_passw, "'") != 0) {
      $old_passw = str_replace("'","\'", $old_passw);
    }

    // send query to database
    $res = mysql_db_query("stilibrary", "SELECT username FROM user WHERE uid = '$user_id' AND password = md5('$old_passw');");
    if (mysql_errno() != 0) {
      // logging function call
      $string = "Error: sqlSelectUser: " . mysql_errno() . ": " . mysql_error(). "\n";
      library_log($string);
      echo ("Database error! - Please see log file for detailed information.<br><br>");
    } // end if

    // check if the old password was correct. If not, an error code is set.
    $num = mysql_num_rows($res);
    if ($num <= 0) {
      header("Location: change_passw.php?error=2");
      exit;
    } // end if

    if ($num > 0) {
      // if the new password is identical with the old, no change is necessary
      if ($old_passw == $new_passw){
        header("Location: change_passw.php?error=3");
        exit;
      } // end if
    } // end if
  } // end else
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

      <span class="crumbTrail"><a class="crumbTrail" href="sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="change_passw.php">Change password</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Change password</h2><br>

                <?php

                  // if the old password was correct
                  if ($num > 0) {

                    // check if the password contains a single quote " ' "
                    if(strpos($new_passw, "'") != 0) {
                      $new_passw = str_replace("'","\'", $new_passw);
                    }

                    // build sql update password string
                    $sqlUpdatePassw = "UPDATE user SET password = md5('$new_passw') WHERE uid = '$user_id'";

                    // send query to database
                    mysql_db_query("stilibrary", $sqlUpdatePassw);
                    if (mysql_errno() != 0) {
                      // logging function call
                      $string = "Error: sqlSelectUser: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlUpdatePassw . "\n";
                      library_log($string);
                      echo ("Database error! - Please see log file for detailed information.<br><br>");
                    } // end if

                    // if password change was successfull
                    $num = mysql_affected_rows();
                    if ($num > 0) {
                      // logging function call
                      $string = "Successfully changed password\n";
                      library_log($string);
                      echo "<strong> You've successfully changed your password!</strong>";
                    } // end if
                  }// end if
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

