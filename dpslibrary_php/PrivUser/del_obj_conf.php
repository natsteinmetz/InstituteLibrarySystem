<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "priv_del_obj_conf";

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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="priv_func_overview.php">Privileged functions</a> &gt; <a class="crumbTrail" href="del_obj_search.php">Delete object - Search & list</a> &gt; Delete object </span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Delete object</h2><br>

                <?php
                  // start database connection for the superuser, with error handling
                  $db = mysql_connect("localhost", "librarySuperuser", "superuser");
                  if (!mysql_select_db ("stilibrary", $db)){
                    die ("Connection to database failed - superuser");
                  } // end if

                  // extract publication from POST
                  $pid=0;
                  if (isset($_POST["pid"]))
                    $pid = $_POST["pid"];

                  // build sql delete publication string
                  $sqlDeleteObj = "DELETE FROM publication WHERE pid = '$pid';";

                  // send query to database
                  mysql_db_query("stilibrary", $sqlDeleteObj);
                  if (mysql_errno() != 0) {
                    // logging function call
                    $string = "Error: sqlDeleteObj: " . mysql_errno() . ": " . mysql_error(). "\n";
                    library_log($string);
                    echo ("Database error! - Please see log file for detailed information.<br><br>");
                  } // end if

                  // check if delete was successfull
                  $num = mysql_affected_rows();
                  if ($num > 0) {
                    // logging function call
                    $string = "Successfully deleted the object with id " . $pid . "\n";
                    library_log($string);
                    echo "<br><strong> You've succesfully deleted this object from the database. </strong><br>";
                  } // end if
                  else {
                    // logging function call
                    $string = "Error: Couldn't delete the object with id " . $uid . "\n";
                    library_log($string);
                    echo "<br><strong> The object hasn't been deleted from the database. </strong><br>";
                  } // end else

                  // close database connection
                  mysql_close($db);
                ?>

                <br><br><br>

                <table>
                  <tr>
                    <form action="del_obj_search.php" method = "GET">
                      <td><input type="submit" name="delete_button" value="  Delete another object  "></td>
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

