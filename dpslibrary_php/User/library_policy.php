<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "policy";

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

      <span class="crumbTrail"><a class="crumbTrail" href="sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="library_policy.php">Library policy</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Library policy</h2><br>

                <ul class="outerList">
                  <li>
                    <h3>Check out policies</h3></li>
                    <ul class="innerList">
                      <li><strong>Only books</strong> can be checked out for a maximum period of 4 weeks.</li>
        <!--              <li>New books can only be checked out by users with the appropriate permission. Ask the Library Operator for your permission.</li>
            -->       <li>Magazines, Journals, Proceedings, etc. cannot be checked out. You can read them at the library or make copies of sections of interest.</li>
                      <li>Only registered users are allowed to check out books. For becoming a registered user, please contact the Library Operator.</li>
                    </ul><br>
                  </li>
                  <li>
                    <h3>How to check out books</h3></li>
                    <ul class="innerList">
                      <li>Search the book either with the "Search" or with the "Expert search" from the Library-Homepage.</li>
                      <li>Click on the title to select a book.</li>
                      <li>You see the details of the selected book. Click on "Borrow this object".</li>
                      <li>Login to the system.</li>
                      <li>You are now allowed to take the borrowed book home with you, for 4 weeks.</li>
                      <li>IMPORTANT! Don't forget to return the book within 28 days!</li>
                    </ul><br>
                  </li>
                  <li>
                    <h3>Return books</h3></li>
                    <ul class="innerList">
                      <li>Return the book to the library and sort it in (see sorting policies below).</li>
                      <li>Select "Return book" in the Library-Homepage.</li>
                      <li>Identify the book, click on its title and click on "Return book" to return it.</li>
                      <li>You can also choose to return all your books by clicking on "Return all books".</li>
                    </ul><br>
                  </li>
                  <li>
                    <h3>Sorting policies</h3></li>
                    <ul class="innerList">
                      <li>Sort all books alphabetically, based on the last name of the first author.</li>
                      <li>If a book does not have an author, then sort it alphabetically based on the book-title.</li>
                      <li>Magazines and Journals are filed based on the title of the magazine or journal and sorted chronologically.</li>
                      <li>Proceedings are sorted chronologically.</li>
                    </ul><br>
                  </li>
                  <li>
                    <h3>Miscellaneous</h3></li>
                    <ul class="innerList">
                      <li>You may only borrow books using the Library-Homepage Catalog.</li>
                      <li>Click on the Help link on the menue left, to get a detailed help. If you have problems with the System, contact the local Library Operator.</li>
                      <li><a href="mailto:Marek.Wieczorek@uibk.ac.at">Library Operator</a></li>
                    </ul>
                  </li>
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

