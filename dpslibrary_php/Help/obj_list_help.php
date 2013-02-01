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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="help.php">Help</a> &gt; <a class="crumbTrail" href="priv_functions_help.php">Privileged functions help</a> &gt; <a class="crumbTrail" href="obj_list_help.php">Object list help</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Privileged functions help</h2><br>

                <h3>Object list help</h3>
                  <ul class="innerList">
                    <li>To see this object list, you need to be logged in and you need to have superuser rights. If you are not yet logged in to the system, you click on 'Privileged functions' on the menue left and log in.</li>
                    <li>Then you choose 'See object list' either directly or from the menue left.</li>
                    <li>You get to a form, where you see a list of all the objects that are in the database.</li>
                    <li>For each object you see its title, its author(s), its year and its status (new, available, not available, checked out, missing). If a book is currently checked out, you see the borrowing date, the return date and the username of the user who checked out this book.</li>
                    <li>By default, the objects are ordered by their title. You can change this by choosing a radio button above the list, and clicking on 'Order by: ' next. You now see the list ordered either by author, by year, by type, by status, by borrowing date, by return date or by user.</li>
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

