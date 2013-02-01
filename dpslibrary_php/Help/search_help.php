<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "help_search";

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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="help.php">Help</a> &gt; <a class="crumbTrail" href="search_help.php">Search help</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Help</h2><br>

                <h3>Search help</h3>
                  <ul class="innerList">
                    <li>You can enter more than one search word in the search field. These words should be separated by &lt;space&gt;.</li>
                    <li>The search form searchs in the database fields 'author', 'title', 'subtitle' and 'keywords'.</li>
                    <li>By clicking on 'Show all objects', you get a complete list of objects.</li>
                    <li>The search results are ordered by title.</li>
                    <li>By clicking on the title or signature of an item, you get the detail information of this object. From here you can either <a href="borrow_help.php">borrow</a> a book, get back to your result list or start a new search.</li>
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

