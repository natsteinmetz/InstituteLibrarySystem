<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "help_change_obj";

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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="help.php">Help</a> &gt; <a class="crumbTrail" href="priv_functions_help.php">Privileged functions help</a> &gt; <a class="crumbTrail" href="change_obj_help.php">Change object help</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Privileged functions help</h2><br>

                <h3>Change object help</h3>
                  <ul class="innerList">
                    <li>To change an object's information, you need to be logged in and you need to have superuser rights. If you are not yet logged in to the system, you click on 'Privileged functions' on the menue left and log in.</li>
                    <li>Then you choose 'Change object' either directly or from the menue left.</li>
                    <li>You get to a form, where you can either search for an object or check if you find it on a list of all objects.</li>
                    <li>By clicking on the object's title or signature, you get to a page with its details, where you can change the information.</li>
                    <li>The title field and the signature field need to be filled out.</li>
                    <li>The signature is unique, so one signature can only belong to one object.</li>
                    <li>If you want to add more than one author, click on 'Add one more author', right to the author's field. You then get another field to enter an author. Don't enter more than one author in one field.</li>
                    <li>If you want to add more than one keyword, click on 'Add one more keyword', right to the keyword's field. You then get another field to enter a keyword. Don't enter more than one keyword in one field.</li>
                    <li>The proceeding time and the conference location need only to be enterend if the new object is a proceeding. The proceeding time need to be in the format 'yyyy-mm-dd'.</li>
                    <li>The supervisor and the school need only to be entered if the new object is a bachelor thesis, a master thesis or a phd thesis.</li>
                    <li>To finally change the information, click on 'Change object'. You then get a confirmation that you changed the object's information.</li>
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

