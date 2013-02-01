<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "priv_change_user";

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

                  // check if an error variable is set
                  $error=0;
                  if (isset ($_GET["error"]))
                    $error = $_GET["error"];

                  // if an error variable is set, the values are filled in from saved session variables
                  if ($error) {
                    // check which error code is set
                    if ($error == 1)
                      echo "<strong>This username is already in use. Please choose another one!</strong><br><br>";
                    if ($error == 2)
                      echo "<strong>All fields are required!</strong><br><br>";
                    if ($error == 3)
                      echo "<strong>There exists already a user with this email address!</strong><br><br>";
                    if ($error == 4)
                      echo "<strong>The username is too long (max. 16 letters). Please choose another one!</strong><br><br>";

                    echo "<table cellpadding='0' cellspacing='5' border='0' width='70%'>";

                    echo "<form action = 'change_user_conf.php' method = 'post'>";

                    echo "<tr> <td> <div align='left'>first name</div> </td>";
                    echo "<td> <input type='text' name='firstName' value= '".$_SESSION["firstName"]."' size='30' maxlength='50'> </td> </tr>";

                    echo "<tr> <td> <div align='left'>last name</div> </td>";
                    echo "<td> <input type='text' name='lastName' value= '".$_SESSION["lastName"]."' size='30' maxlength='50'> </td> </tr>";

                    echo "<tr> <td> <div align='left'>username<span style='color: #9F9F9F'> (unique)</span></div> </td>";
                    echo "<td> <input type='text' name='username' value= '".$_SESSION["username"]."' size='30' maxlength='50'> </td> </tr>";

                    echo "<tr> <td> <div align='left'>password</div> </td>";
                    echo "<td> <input type='password' name='password' value= '".$_SESSION["password"]."' size='30' maxlength='50'> </td> </tr>";

                    echo "<tr> <td> <div align='left'>email<span style='color: #9F9F9F'> (unique)</span></div> </td>";
                    echo "<td> <input type='text' name ='email' value= '".$_SESSION["email"]."' size ='30' maxlength ='50'> </td> </tr>";

                    if ($_SESSION["reminder"] == 'yes'){
                      echo "<tr> <td> <div align='left'>reminder</div> </td>";
                      echo "<td> <input type='radio' name='reminder' value='yes' checked='checked'> Yes &#160;&#160;&#160;&#160;<input type='radio' name='reminder' value='no'> No </td> </tr>";
                    } // end if
                    else {
                      echo "<tr> <td> <div align='left'>reminder</div> </td>";
                      echo "<td> <input type='radio' name='reminder' value='yes'> Yes &#160;&#160;&#160;&#160;<input type='radio' name='reminder' value='no' checked='checked'> No </td> </tr>";
                    } // end else

                    if ($_SESSION["superuser"] == 'yes'){
                      echo "<tr> <td> <div align='left'>superuser</div> </td>";
                      echo "<td> <input type='radio' name='superuser' value='yes' checked='checked'> Yes &#160;&#160;&#160;&#160;<input type='radio' name='superuser' value='no'> No </td> </tr>";
                    } // end if
                    else {
                      echo "<tr> <td> <div align='left'>superuser</div> </td>";
                      echo "<td> <input type='radio' name='superuser' value='yes'> Yes &#160;&#160;&#160;&#160;<input type='radio' name='superuser' value='no' checked='checked'> No </td> </tr>";
                    } // end else

                    echo "<input type='hidden' name='uid' value='".$_SESSION["uid"]."'>";
                    echo "<tr></tr><tr></tr><tr></tr>";

                    echo "<tr> <td> <input type='submit' value='  Change user  '> </td>";
                    echo "<td> <input type='reset' value='  Reset to initial value  '> </td> </tr></form>";
                    echo "<tr><td></td></tr><tr><td></td></tr>";
                    if ($_SESSION["act_change_user_page"] == "list") {
                      echo "<form action = 'change_user_list.php' method = 'GET'>";
                      echo "<tr><td> <input type='submit' name='back' value='  Get back to user list  '></td>";
                      echo "</tr></form>";
                    } // end if
                    else {
                      echo "<form action = 'change_user_search.php' method = 'GET'>";
                      echo "<tr><td> <input type='submit' name='back' value='  Get back to user list  '></td>";
                      echo "</tr></form>";
                    } // end else
                    echo "</table>";
                  } // end if

                  // if no error variable is set, the values are taken out of the database for the user id sent via GET from the user list
                  else {
                    // extract the user id via GET
                    $uid=-1;
                    if (isset($_GET["uid"]))
                      $uid = $_GET["uid"];

                    // start database connection for the superuser, with error handling
                    $db = mysql_connect("localhost", "librarySuperuser", "superuser");
                    if (!mysql_select_db ("stilibrary", $db)){
                      die ("Connection to database failed - user: " . $user_username);
                    } // end if

                    // send select user query to database
                    $res = mysql_db_query("stilibrary", "SELECT * FROM user WHERE uid = '$uid';");
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
                    $password = mysql_result($res, 0, "password");
                    $email = mysql_result($res, 0, "email");
                    $reminder = mysql_result($res, 0, "reminder");
                    $superuser = mysql_result($res, 0, "superuser");

                    // write the old values into session variables
                    $_SESSION["old_firstName"] = $first_name;
                    $_SESSION["old_lastName"] = $last_name;
                    $_SESSION["old_username"] = $user_name;
                    $_SESSION["old_password"] = $password;
                    $_SESSION["old_email"] = $email;
                    $_SESSION["old_reminder"] = $reminder;
                    $_SESSION["old_superuser"] = $superuser;

                    echo "<table cellpadding='0' cellspacing='5' border='0' width='70%'>";
                    echo "<form action = 'change_user_conf.php' method = 'post'>";

                    echo "<tr> <td> <div align='left'>first name</div> </td>";
                    echo "<td> <input type='text' name='firstName' value='$first_name' size='30' maxlength='50'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>last name</div> </td>";
                    echo "<td> <input type='text' name='lastName' value='$last_name' size='30' maxlength='50'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>username<span style='color: #9F9F9F'> (unique)</span></div> </td>";
                    echo "<td> <input type='text' name='username' value='$user_name' size='30' maxlength='50'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>password</div> </td>";
                    echo "<td> <input type='password' name='password' value='$password' size='30' maxlength='50'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>email<span style='color: #9F9F9F'> (unique)</span></div> </td>";
                    echo "<td> <input type='text' name ='email' value='$email' size ='30' maxlength ='50'> </td> </tr>";
                    if ($reminder == 1) {
                      echo "<tr> <td> <div align='left'>reminder</div> </td>";
                      echo "<td> <input type='radio' name='reminder' value='yes' checked='checked'> Yes &#160;&#160;&#160;&#160;<input type='radio' name='reminder' value='no'> No </td> </tr>";
                    }
                    else {
                      echo "<tr> <td> <div align='left'>reminder</div> </td>";
                      echo "<td> <input type='radio' name='reminder' value='yes'> Yes &#160;&#160;&#160;&#160;<input type='radio' name='reminder' value='no' checked='checked'> No </td> </tr>";
                    }
                    if ($superuser == 1) {
                      echo "<tr> <td> <div align='left'>superuser</div> </td>";
                      echo "<td> <input type='radio' name='superuser' value='yes' checked='checked'> Yes &#160;&#160;&#160;&#160;<input type='radio' name='superuser' value='no'> No </td> </tr>";
                    }
                    else {
                      echo "<tr> <td> <div align='left'>superuser</div> </td>";
                      echo "<td> <input type='radio' name='superuser' value='yes'> Yes &#160;&#160;&#160;&#160;<input type='radio' name='superuser' value='no' checked='checked'> No </td> </tr>";
                    }

                    echo "<input type='hidden' name='uid' value='$uid'>";
                    echo "<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>";

                    echo "<tr> <td> <input type='submit' value='  Change user  '> </td>";
                    echo "<td> <input type='reset' value='  Reset to initial value  '> </td> </tr></form>";
                    echo "<tr><td></td></tr><tr><td></td></tr>";
                    if ($_SESSION["act_change_user_page"] == "list") {
                      echo "<form action = 'change_user_list.php' method = 'GET'>";
                      echo "<tr><td> <input type='submit' name='back' value='  Get back to user list  '></td>";
                      echo "</tr></form>";
                    } // end if
                    else {
                      echo "<form action = 'change_user_search.php' method = 'GET'>";
                      echo "<tr><td> <input type='submit' name='back' value='  Get back to user list  '></td>";
                      echo "</tr></form>";
                    } // end else
                    echo "</table>";

                    // close database connection
                    mysql_close($db);
                  } // end else

                  // delete session variables
                  unset($_SESSION["uid"]);
                  unset($_SESSION["firstName"]);
                  unset($_SESSION["lastName"]);
                  unset($_SESSION["username"]);
                  unset($_SESSION["password"]);
                  unset($_SESSION["email"]);
                  unset($_SESSION["reminder"]);
                  unset($_SESSION["superuser"]);
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

