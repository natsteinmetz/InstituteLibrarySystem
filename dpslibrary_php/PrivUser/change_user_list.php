<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "priv_change_user_list";

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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="priv_func_overview.php">Privileged functions</a> &gt; <a class="crumbTrail" href="change_user_search.php">Change user - Search & list</a> &gt; User list </span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Change user - User list</h2><br>

                <?php
                  // start database connection for the superuser, with error handling
                  $db = mysql_connect("localhost", "librarySuperuser", "superuser");
                  if (!mysql_select_db ("stilibrary", $db)){
                    die ("Connection to database failed - superuser");
                  } // end if

                  // extract the search string from a session variable
                  $string = "";
                  if (isset($_SESSION["change_user_string"]))
                    $string = $_SESSION["change_user_string"];

                  // extract the variable back from GET
                  $back = "";
                  if (isset($_GET["back"]))
                    $back = $_GET["back"];

                  // if the user comes back to this list he gets his old search results from the saved session string
                  if ($back != "")
                    $sqlSelectUser = $string;

                  // the list is called from the search form
                  else {
                    // build sql select user string
                    $sqlSelectUser = "SELECT uid, firstName, lastName, username, email FROM user WHERE";
                    $sqlSelectUserControl = "SELECT uid, firstName, lastName, username, email FROM user WHERE";

                    // check which attribute has been indicated and continue sql select string
                    if (($first_name = $_POST["firstName"]) != "")
                      $sqlSelectUser .= " firstName = '$first_name'";
                    if (($last_name = $_POST["lastName"]) != ""){
                      if ($sqlSelectUser == $sqlSelectUserControl)
                        $sqlSelectUser .= " lastName = '$last_name'";
                      else
                        $sqlSelectUser .= " AND lastName = '$last_name'";
                    } // end if
                    if (($user_name = $_POST["username"]) != ""){
                      if ($sqlSelectUser == $sqlSelectUserControl)
                        $sqlSelectUser .= " username = '$user_name'";
                      else
                        $sqlSelectUser .= " AND username = '$user_name'";
                    } // end if
                    if (($email = $_POST["email"]) != ""){
                      if ($sqlSelectUser == $sqlSelectUserControl)
                        $sqlSelectUser .= " email = '$email'";
                      else
                        $sqlSelectUser .= " AND email = '$email'";
                    } // end if
                    if (($reminder= $_POST["reminder"]) != ""){
                      if ($reminder == "yes")
                        $reminder = 1;
                      if ($reminder == "no")
                        $reminder = 0;
                      if ($sqlSelectUser == $sqlSelectUserControl)
                        $sqlSelectUser .= " reminder = '$reminder'";
                      else
                        $sqlSelectUser .= " AND reminder = '$reminder'";
                    } // end if
                    if (($superuser = $_POST["superuser"]) != ""){
                      if ($superuser == "yes")
                        $superuser = 1;
                      if ($superuser == "no")
                        $superuser = 0;
                      if ($sqlSelectUser == $sqlSelectUserControl)
                        $sqlSelectUser .= " superuser = '$superuser'";
                      else
                        $sqlSelectUser .= " AND superuser = '$superuser'";
                    } // end if

                    // check whether there are search words defined
                    $noSearch = 0;
                    if ($sqlSelectUser == $sqlSelectUserControl) {
                      $noSearch = 1;
                      echo "<br><br><strong>No search words defined</strong>";
                    } // end if
                    else {
                      // terminate the sql select string
                      $sqlSelectUser .= " ORDER BY lastName;";
                    } // end else
                  } // end else

                  if (!$noSearch) {
                    // send query to database
                    $res = mysql_db_query("stilibrary", $sqlSelectUser);
                    if (mysql_errno() != 0) {
                      // logging function call
                      $string = "sqlSelectUser: " . mysql_errno() . ": " . mysql_error(). "\n";
                      library_log($string);
                      echo ("Database error! - Please see log file for detailed information.<br><br>");
                    } // end if

                    // write values to session variables
                    $_SESSION["act_change_user_page"] = "list";
                    $_SESSION["change_user_string"] = $sqlSelectUser;

                    // get number of results
                    $num = mysql_num_rows($res);
                    if ($num > 0){
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

                      echo "<tr><td></td></tr><tr><td></td></tr>";
                      echo "<form action = 'change_user_search.php' method = 'GET'>";
                      echo "<tr><td> <input type='submit' name='back' value='  Get back to user search and list  '></td>";
                      echo "</tr></form>";

                      echo "</table>";
                    } // end if
                    else
                        echo "<br><br><strong> No user found </strong><br><br>";
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

