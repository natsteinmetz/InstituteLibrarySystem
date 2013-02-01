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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="help.php">Help</a> &gt; <a class="crumbTrail" href="priv_functions_help.php">Privileged functions help</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Privileged functions help</h2><br>

                <table cellspacing="10">
                  <tr>
                    <td> <h3><div align="left"><a href="add_obj_help.php"> Add new object help </div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="change_obj_help.php"> Change object help </div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="del_obj_help.php"> Delete object help </div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="add_user_help.php"> Add new user help </div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="change_user_help.php"> Change user help</div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="del_user_help.php"> Delete user help </div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="obj_list_help.php"> Object list help </div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="organisation_help.php"> Organisation help </div></h3> </td>
                  </tr>
                  <tr> </tr> <tr> </tr>
                </table>
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

