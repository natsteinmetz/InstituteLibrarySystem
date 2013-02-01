<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "help_priv_functions";

  // start session, check if the user is already logged in and if he is a superuser or not
  include ("../check_user.inc");

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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="help.php">Help</a> &gt; <a class="crumbTrail" href="priv_functions_help.php">Privileged functions help</a> &gt; <a class="crumbTrail" href="del_user_help.php">Delete user help</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Privileged functions help</h2><br>

                <h3>Delete user help</h3>
                  <ul class="innerList">
                    <li>To delete a user, you need to be logged in and you need to have superuser rights. If you are not yet logged in to the system, you click on 'Privileged functions' on the menue left and log in.</li>
                    <li>Then you choose 'Delete user' either directly or from the menue left.</li>
                    <li>You get to a form, where you can either search for a user or check if you find him on a list of all users.</li>
                    <li>By clicking on the user's username, you get to a page with his details.</li>
                    <li>To delete the user, click on 'Delete user'. You need to confirm once, that you really want to delete this user, by clicking on 'Yes, delete user'. You now get a confirmation that you deleted this user.</li>
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

