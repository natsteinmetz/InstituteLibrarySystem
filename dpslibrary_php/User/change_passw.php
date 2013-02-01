<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "passw";

  // check if the user is already logged in and if he is a superuser or not
  include ("../check_user.inc");
  include ("../library_functions.inc");
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
                  // if an error variable is set, the passwords must be entered again
                  $error = $_GET["error"];
                  if (isset ($error)){
                    if ($error == 1)
                      echo "<strong>Both entries of the new password must be identical!</strong><br><br>";
                    if ($error == 2)
                      echo "<strong>Wrong password (old password)!</strong><br><br>";
                    if ($error == 3)
                      echo "<strong>Old password is identical with new password!</strong><br><br>";
                  } // end if
                ?>

                <!-- to change his password, the user must first enter his old password and must then enter twice the new password - twice to be sure of the right spelling of the new password -->

                <table cellpadding="0" cellspacing="5" border="0" width="70%">

                <form action="change_passw_conf.php" method="post">

                <tr> <td> <div align="left">old password</div> </td>
                <td> <input type="Password" name="old_passw" value="" size="30" maxlength="30"></td> </tr>

                <tr> <td> <div align="left">new password</div> </td>
                <td> <input type="Password" name="new_passw" value="" size="30" maxlength="30"> </td> </tr>

                <tr> <td> <div align="left">reenter new password</div> </td>
                <td> <input type="Password" name="new_passw2" value="" size="30" maxlength="30"> </td> </tr>

                <tr> <td></td>
                <td> <input type="submit" name="submit" value="  Submit  "> </td> </tr>

                </form></table>

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

