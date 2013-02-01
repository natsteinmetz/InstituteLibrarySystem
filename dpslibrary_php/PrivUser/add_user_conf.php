<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "priv_add_user_conf";

  // start session, check if the user is already logged in and if he is a superuser or not
  include ("../check_user.inc");
  include ("../library_functions.inc");

  // check if the logged-in is a superuser
  if (!$user_superuser && isset($_SESSION["user_id"])){
    header("Location: ../User/sti_library.php?error=1");
    exit;
  } // end if

  else {
    // extract values from POST
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
    $superuser = 0;
    if (isset($_POST["superuser"]))
      $superuser = $_POST["superuser"];

    // write values to session variables
    $_SESSION["firstName"] = $first_name;
    $_SESSION["lastName"] = $last_name;
    $_SESSION["username"] = $user_name;
    $_SESSION["password"] = $password;
    $_SESSION["email"] = $email;
    $_SESSION["reminder"] = $reminder;
    $_SESSION["superuser"] = $superuser;

    // all the fields have to be filled out
    if (($first_name == "") || ($last_name == "") || ($user_name == "") || ($password == "") || ($email == "")){
      header("Location: add_user.php?error=2");
      exit;
    } // end if

    // the username mustn't be longer than 16 letters
    if (strlen($user_name) > 16){
      header("Location: add_user.php?error=4");
      exit;
    } // end if

    // start database connection for the superuser, with error handling
    $db = mysql_connect("localhost", "librarySuperuser", "superuser");
    if (!mysql_select_db ("stilibrary", $db)){
      die ("Connection to database failed - superuser");
    } // end if

    // send query to database
    $res1 = mysql_db_query("stilibrary", "SELECT username FROM user WHERE username = '$user_name';");
    if (mysql_errno() != 0) {
      // logging function call
      $string = "Error: " . mysql_errno() . ": " . mysql_error(). "\n";
      library_log($string);
      echo ("Database error! - Please see log file for detailed information.<br><br>");
    } // end if

    // an error code is set, if the chosen username exists already. The user is sent back to the previous page.
    $num1 = mysql_num_rows($res1);
    if ($num1 > 0){
      // close database connection
      mysql_close($db);

      header("Location: add_user.php?error=1");
      exit;
    } // end if

    // send query to database
    $res2 = mysql_db_query("stilibrary", "SELECT email FROM user WHERE email = '$email';");
    if (mysql_errno() != 0) {
      // logging function call
      $string = "Error: " . mysql_errno() . ": " . mysql_error(). "\n";
      library_log($string);
      echo ("Database error! - Please see log file for detailed information.<br><br>");
    }

    // an error code is set, if the chosen email exists already. The user is sent back to the previous page.
    $num2 = mysql_num_rows($res2);
    if ($num2 > 0){
      // close database connection
      mysql_close($db);

      header("Location: add_user.php?error=3");
      exit;
    } // end if

    // close database connection
    mysql_close($db);
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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="priv_func_overview.php">Privileged functions</a> &gt; <a class="crumbTrail" href="add_user.php">Add new user</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Add new user</h2><br>

                <?php
                  // start database connection for the superuser, with error handling
                  $db = mysql_connect("localhost", "librarySuperuser", "superuser");
                  if (!mysql_select_db ("stilibrary", $db)){
                    die ("Connection to database failed - superuser");
                  } // end if

                  if ($reminder == 'yes')
                    $reminder = 1;
                  else
                    $reminder = 0;

                  if ($superuser == 'yes')
                    $superuser = 1;
                  else
                    $superuser = 0;

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

                  // build sql insert into user string
                  $sqlInsertUser = "INSERT INTO user VALUES ('NULL', '$first_name', '$last_name', '$user_name', ";
                  $sqlInsertUser .= "md5('$password'), '$email', '$reminder', '$superuser');";

                  // send query to database
                  mysql_db_query("stilibrary", $sqlInsertUser);
                  if (mysql_errno() != 0) {
                    // logging function call
                    $string = "Error: sqlInsertUser: " . mysql_errno() . ": " . mysql_error(). "\n";
                    library_log($string);
                    echo ("Database error! - Please see log file for detailed information.<br><br>");
                  } // end if

                  // if insert was successfull
                  $num = mysql_affected_rows();
                  if ($num>0) {
                    // logging function call
                    $string = "Inserted new user " . $user_name . "\n";
                    library_log($string);

                    // send select user query to database
                    $res = mysql_db_query("stilibrary", "SELECT firstName, lastName, username, email, reminder, superuser FROM user WHERE username = '$user_name';");

                    // extract results
                    $first_name = mysql_result($res, 0, "firstName");
                    $last_name = mysql_result($res, 0, "lastName");
                    $user_name = mysql_result($res, 0, "username");
                    $email = mysql_result($res, 0, "email");
                    $reminder = mysql_result($res, 0, "reminder");
                    $superuser = mysql_result($res, 0, "superuser");

                    echo "<strong> You've succesfully added this user to the database. </strong>";
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
                    $string = "Error: Couldn't insert new user " . $username . "\n";
                    library_log($string);
                    echo "<br><strong> The user hasn't been added to the database. </strong>";
                  } // end else

                  // close database connection
                  mysql_close($db);
                ?>

                <br><br><br>

                <table>
                  <tr>
                    <form action="add_user.php" method = "GET">
                      <td><input type="submit" name="add_button" value="  Add another user  "></td>
                    </form>
                    <form action="priv_func_overview.php" method = "GET">
                      <td><input type="submit" name="priv_func_button" value= "Privileged functions overview"></td>
                    </form>
                  </tr>
                </table>

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

