<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "priv_organisation";

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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="organisation.php">Organisation</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Organisation</h2><br>

                <?php

                  // start database connection for the superuser, with error handling
                  $db = mysql_connect("localhost", "librarySuperuser", "superuser");
                  if (!mysql_select_db ("stilibrary", $db)){
                    die ("Connection to database failed - superuser");
                  } // end if

                  // extract userReminder and newToAvailable via POST
                  $userReminder = -1;
                  if (isset($_POST["userReminder"]))
                    $userReminder = $_POST["userReminder"];
                  $newToAvailable = -1;
                  if (isset($_POST["newToAvailable"]))
                    $newToAvailable = $_POST["newToAvailable"];

                  // check if the two variables have been changed via POST
                  if (($userReminder != -1) || ($newToAvailable != -1)) {
                    // build sql update organisation string
                    $sqlUpdateOrg = "UPDATE organisation SET userReminder = '$userReminder', newToAvailable = '$newToAvailable';";

                    // send query to database
                    mysql_db_query("stilibrary", $sqlUpdateOrg);
                    if (mysql_errno() != 0) {
                      // logging function call
                      $string = "Error: sqlUpdateOrg: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlUpdateOrg . "\n";
                      library_log($string);
                      echo ("Database error! - Please see log file for detailed information.<br><br>");
                    } // end if

                    // check if the change was successfull or not
                    $num = mysql_affected_rows();
                    if ($num>0) {
                      // logging function call
                      $string = "changed userReminder to ". $userReminder ." and newToAvailable to " .$newToAvailable ."\n";
                      echo "<strong>Your changes have been executed successfully.</strong><br><br>";
                    } // end if
                    else {
                      // logging function call
                      $string = "Error: Organisational changes couldn't be made";
                      library_log($string);
                      echo "<strong>Error: The changes couldn't be made!</strong><br><br>";
                    } // end else
                  } // end if

                  // build sql select organisation string
                  $sqlSelectOrg = "SELECT userReminder, newToAvailable FROM organisation;";

                  // send query to database
                  $res = mysql_db_query("stilibrary", $sqlSelectOrg);
                  if (mysql_errno() != 0) {
                    // logging function call
                    $string = "sqlSelectOrg: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlSelectOrg . "\n";
                    library_log($string);
                    echo ("Database error! - Please see log file for detailed information.<br><br>");
                  } // end if

                  // extract results from organisation
                  $userReminder = mysql_result($res, 0, "userReminder");
                  $newToAvailable = mysql_result($res, 0, "newToAvailable");

                  echo "<form action = 'organisation.php' method = 'POST'>";
                  echo "<strong>Reminding email</strong><br><br>";
                  echo "This value determins how long a book can be hold by a user.<br>";
                  echo "After how many days shall a user get an email, reminding him to return the object to the library?<br><br>";

                  echo "<table cellspacing='10'>";
                  echo "<tr><td> <input type='text' name='userReminder' value='$userReminder' size='5' maxlength='3'></td>";
                  echo "<td> <input type='reset' value='   Reset to initial value  '></td></tr>";
                  echo "</table>";
                  echo "<br><br><hr><br><br>";

                  echo "<strong>Object status</strong><br><br>";
                  echo "This value determins after how many days the status of an object changes from 'new' to 'available'.<br>";
                  echo "An object can only be borrowed by users if its status is 'available', new objects shall remain at the library for a certain number of days.<br><br>";

                  echo "<table cellspacing='10'>";
                  echo "<tr><td> <input type='text' name='newToAvailable' value='$newToAvailable' size='5' maxlength='3'></td>";
                  echo "<td> <input type='reset' value='   Reset to initial value  '></td></tr>";
                  echo "</table>";

                  echo "<table cellspacing='10'>";
                  echo "<tr><td height='30'></td></tr>";
                  echo "<tr><td> <input type='submit' value='   Change values   '></td></tr>";
                  echo "</table>";
                  echo "</form>";
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

