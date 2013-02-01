<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "help_return";

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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="help.php">Help</a> &gt; <a class="crumbTrail" href="return_help.php">Return help</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Help</h2><br>

                <h3>Return help</h3>
                  <ul class="innerList">
                    <li>To return a book, you need to click on 'Return book' on the menue left. If you are not yet logged in to the system, then you need to log in now. To log in, you need to be a registered user. If you want to become a registered user, please contact the <a href="mailto:Marek.Wieczorek@uibk.ac.at">Library Operator</a>.</li>
                    <li> You now get a list of all books, that you have currently borrowed. You have the choice to return only one or some of the books, or to return all your books.</li>
                    <li>If you click on the title or the signature of one item, you get its detailed information and you can choose to return this book by clicking on 'Yes, return book'. After having done so, you get a confirmation that you have returned this book.</li>
                    <li>If you want to return all your books, you need to click on the button 'Return all books', below the list of your books. You need to confirm your choice to return all books, and after having done so, you get a confirmation that you have returned all your borrowed books.</li>
                    <li>A book can be checked out for 28 days. If you haven't returned a book within these 28 days, you get a reminding email.</li>
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

