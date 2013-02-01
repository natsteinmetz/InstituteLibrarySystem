<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "help_borrow";

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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="help.php">Help</a> &gt; <a class="crumbTrail" href="borrow_help.php">Borrow help</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Help</h2><br>

                <h3>Borrow help</h3>
                  <ul class="innerList">
                    <li>By clicking on the title or the signature of an item in your search result list, you come to the detail information of this object.</li>
                    <li>If a book is available, you can click on 'Borrow book'.</li>
                    <li>If you are not yet logged in to the system, then you need to log in now. To log in, you need to be a registered user. If you want to become a registered user, please contact the <a href="mailto:Marek.Wieczorek@uibk.ac.at">Library Operator</a>.
                    <li>After clicking on 'Borrow book' and identifying yourself, you need to confirm this choice by clicking on 'Yes, borrow book'. You now get a confirmation that you borrowed this book.</li>
                    <li>Only books can be borrowed, so for proceedings, thesises and others, you get informed that you can't borrow these.</li>
                    <li>If a book has a status 'new' or 'checked out' or 'missing', it is not available to be borrowed.</li>
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

