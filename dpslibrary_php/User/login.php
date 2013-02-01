<?php
  // start session
  session_start ();

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

      <span class="crumbTrail"><a class="crumbTrail" href="sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="login.php">Login</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h1>STI-Innsbruck Library</h1><br>
                <h2>Login</h2><br>

                <?php
                  // an error code 1 is set by the login_check if the password or the username is wrong
                  $error = 0;
                  if (isset ($_GET["error"])){
                    $error = $_GET["error"];

                  if ($error == 1)
                    echo "<strong>Wrong password or username.</strong><br><br>";
                  } // end if
                ?>

                <table cellpadding="0" cellspacing="5" border="0" width="70%">
                  <form action="login_check.php" method="post">

                    <tr> <td> <div align="left">Username</div> </td>
                    <td> <input type="text" name="username" value="" size="30" maxlength="50"> </td> </tr>

                    <tr> <td>  <div align="left">Password</div> </td>
                    <td> <input type="password" name="password" value="" size="30" maxlength="8"> </td> </tr>

                    <tr> <td> </td> <td><input type="submit" value="  Login  "> </td> </tr>
                  </form>
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

