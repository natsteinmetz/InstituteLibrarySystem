<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "search";

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

      <span class="crumbTrail"><a class="crumbTrail" href="sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="search.php">Search</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Search</h2><br>

                <!-- Search page - One keyword is searched for, the results are listed on the result_list.php page -->

                <table cellpadding="0" cellspacing="10" border="0" width="40%">
                  <form action = "result_list.php" method = "POST">
                    <tr>
                      <td> <input type="text" name="search" value="" size="40" maxlength="100"> </td>
                      <td> <input type="submit" value="  Search  "> </td>
                    </tr>
                  </form>
                  <form action = "result_list.php" method = "GET">
                    <tr>
                      <td></td>
                      <td> <input type="submit" name="search_all" value="  Show all objects  "> </td>
                    </tr>
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

