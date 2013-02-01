<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "help";

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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="help.php">Help</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Help</h2><br>

                <table cellspacing="10">
                  <tr>
                    <td> <h3><div align="left"><a href="search_help.php"> Search help </a></div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="expert_search_help.php"> Expert search help </a></div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="borrow_help.php"> Borrow book help </a></div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="return_help.php"> Return book help </a></div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="change_passw_help.php"> Change password help </a></div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="priv_functions_help.php"> Privileged functions help </a></div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="mailto:Marek.Wieczorek@uibk.ac.at">Library Operator</a></div></h3> </td>
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

