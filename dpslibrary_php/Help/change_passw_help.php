<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "help_passw";

  // checking if the user is already logged in
  $user_id = 0;
  if (isset ($_SESSION["user_id"]))
    $user_id = $_SESSION["user_id"];

  // checking if the logged-in user is a superuser
  $user_superuser = 0;
  if (isset($_SESSION["user_superuser"]))
    $user_superuser = $_SESSION["user_superuser"];
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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="help.php">Help</a> &gt; <a class="crumbTrail" href="change_passw_help.php">Change password help</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Help</h2><br>

                <h3>Change password help</h3>
                  <ul class="innerList">
                    <li>To change your library system password, you click on 'Change password' on the menue left.</li>
                    <li>If you are not yet logged in to the system, then you need to log in now. To log in, you need to be a registered user. If you want to become a registered user, please contact the <a href="mailto:Marek.Wieczorek@uibk.ac.at">Library Operator</a>.</li>
                    <li>In the change password form, you need to enter your old password, and then enter twice your new password.</li>
                    <li>If the new password is not equal with the old one, and if the two enterings of the new password are identical, then your new password is accepted and you get a confirmation.</li>
                    <li>From this moment on, you need your new password to identify to the system.</li>
                    <li>If ever you forget your password, please send a mail to the <a href="mailto:Marek.Wieczorek@uibk.ac.at">Library Operator</a>. You will then get a new password.</li>
                  </ul>
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

