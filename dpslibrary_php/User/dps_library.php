<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "index";

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

      <span class="crumbTrail"><a class="crumbTrail" href="sti_library.php">STI-Innsbruck Library</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>
                <h2>STI-Innsbruck Library</h2><br>

                <?php
                  // the privileged functions set an error code 1 if a normal user tries to execute privileged functions
                  $error=0;
                  if (isset($_GET["error"]))
                    $error = $_GET["error"];
                  if ($error == 1)
                    echo "<strong>You aren't authorized to use privileged functions!</strong><br><br>";
                ?>

                <!-- Entry page of the library with the different choices -->

                <table cellspacing="10">
                  <tr>
                    <td> <h3><div align="left"><a href="search.php"> Search </div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="expert_search.php"> Expert search </div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="return_obj_list.php"> Return object </div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="change_passw.php"> Change password </div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="../PrivUser/priv_func_overview.php"> Privileged functions </div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="library_policy.php"> Library policy </div></h3> </td>
                  </tr>
                  <tr>
                    <td> <h3><div align="left"><a href="../Help/help.php"> Help </div></h3> </td>
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

