<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "expert_search";

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

      <span class="crumbTrail"><a class="crumbTrail" href="sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="expert_search.php">Expert search</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Expert search</h2><br>

                <?php
                  // checking if the user is getting back to this page from the expert result list page
                  $get_back="";
                  if (isset($_GET["get_back"]))
                    $get_back = $_GET["get_back"];

                  // an error code is set if a user enters the year or the proceeding time in a wrong format
                  $error=0;
                  if (isset($_GET["error"]))
                    $error = $_GET["error"];

                  // if the variable get_back or the error variable is set, the form is filled by values from session variables.
                  if (($get_back != "") || ($error != 0)) {
                    // check which error code is set
                    if ($error == 1)
                      echo "<strong>The year must be given in like 'yyyy'!</strong><br><br>";
                    if ($error == 2) {
                      echo "<strong>The proceeding time must be in one of the following formats:<br>";
                      echo "yyyy or yyyy-mm or yyyy-mm-dd</strong><br><br>";
                    } // end if

                    echo "<table cellpadding='0' cellspacing='5' border='0' width='85%'>";
                    echo "<form action = 'expert_result_list.php' method = 'post'>";
                    echo "<tr> <td> <div align='left'>author(s)<span style='color: #9F9F9F'> (more authors separated with &lt;space&gt;)</span></div> </td>";
                    echo "<td> <input type='text' name='author' value= '".$_SESSION["author"]."' size='30' maxlength='150'> </td></tr>";
                    echo "<tr> <td> <div align='left'>title</div> </td>";
                    echo "<td> <input type='text' name='title' value= '".$_SESSION["title"]."' size='30' maxlength='250'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>subtitle</div> </td>";
                    echo "<td> <input type='text' name='subtitle' value= '".$_SESSION["subtitle"]."' size='30' maxlength='1000'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>year<span style='color: #9F9F9F'> (yyyy)</span></div> </td>";
                    echo "<td> <input type='text' name='year' value= '".$_SESSION["year"]."' size='30' maxlength='4'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>publisher</div> </td>";
                    echo "<td> <input type='text' name ='publisher' value= '".$_SESSION["publisher"]."' size ='30' maxlength ='200'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>location</div> </td>";
                    echo "<td> <input type='text' name='location' value= '".$_SESSION["location"]."' size='30' maxlength='200'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>ISBN/ISSN</div> </td>";
                    echo "<td> <input type='text' name ='isbn' value= '".$_SESSION["isbn"]."' size ='30' maxlength ='13'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>keyword(s)<span style='color: #9F9F9F'> (more keywords separated with &lt;space&gt;)</span></div> </td>";
                    echo "<td> <input type='text' name='keywords' value= '".$_SESSION["keywords"]."' size='30' maxlength='150'> </td></tr>";
                    echo "<tr> <td> <div align='left'>comment</div> </td>";
                    echo "<td> <input type='text' name ='comment' value= '".$_SESSION["comment"]."' size ='30' maxlength ='2000'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>signature</div> </td>";
                    echo "<td> <input type='text' name='signature' value= '".$_SESSION["signature"]."' size='30' maxlength='15'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>proceeding time<span style='color: #9F9F9F'> (yyyy-mm-dd, yyyy-mm or yyyy) </span></div> </td>";
                    echo "<td> <input type='text' name ='proc_time' value= '".$_SESSION["proc_time"]."' size ='30' maxlength ='10'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>conference location<span style='color: #9F9F9F'> (only for proceedings) </span></div> </td>";
                    echo "<td> <input type='text' name='conf_loc' value= '".$_SESSION["conf_loc"]."' size='30' maxlength='200'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>supervisor<span style='color: #9F9F9F'> (only for thesises)                             </span></div> </td>";
                    echo "<td> <input type='text' name ='supervisor' value= '".$_SESSION["supervisor"]."' size ='30' maxlength ='100'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>school<span style='color: #9F9F9F'> (only for thesises)                             </span></div> </td>";
                    echo "<td> <input type='text' name='school' value= '".$_SESSION["school"]."' size='30' maxlength='200'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>type</div> </td>";
                    echo "<td> <select name='type' size='1'>";
                    if ($_SESSION["type"] == 'all')
                      echo "<option selected> all </option>";
                    else
                      echo "<option> all </option>";
                    if ($_SESSION["type"] == 'book')
                      echo "<option selected> book </option>";
                    else
                      echo "<option> book </option>";
                    if ($_SESSION["type"] == 'proceeding')
                      echo "<option selected> proceeding </option>";
                    else
                      echo "<option> proceeding </option>";
                    if ($_SESSION["type"] == 'manual')
                      echo "<option selected> manual </option>";
                    else
                      echo "<option> manual </option>";
                    if ($_SESSION["type"] == 'bachelor thesis')
                      echo "<option selected> bachelor thesis </option>";
                    else
                      echo "<option> bachelor thesis </option>";
                    if ($_SESSION["type"] == 'master thesis')
                      echo "<option selected> master thesis </option>";
                    else
                      echo "<option> master thesis </option>";
                    if ($_SESSION["type"] == 'phd thesis')
                      echo "<option selected> phd thesis </option>";
                    else
                      echo "<option> phd thesis </option>";
                    if ($_SESSION["type"] == 'miscellaneous')
                      echo "<option selected> miscellaneous </option>";
                    else
                      echo "<option> miscellaneous </option>";
                    echo "</select> </td> </tr>";
                    echo "<tr> <td> <div align='left'>classification</div> </td>";
                    echo "<td> <select name='classification' size='1'>";
                    if ($_SESSION["classification"] == 'all')
                      echo "<option selected> all </option>";
                    else
                      echo "<option> all </option>";
                    if ($_SESSION["classification"] == 'programming languages')
                      echo "<option selected> programming languages </option>";
                    else
                      echo "<option> programming languages </option>";
                    if ($_SESSION["classification"] == 'software engineering')
                      echo "<option selected> software engineering </option>";
                    else
                      echo "<option> software engineering </option>";
                    if ($_SESSION["classification"] == 'operation systems')
                      echo "<option selected> operation systems </option>";
                    else
                      echo "<option> operation systems </option>";
                    if ($_SESSION["classification"] == 'computer networks')
                      echo "<option selected> computer networks </option>";
                    else
                      echo "<option> computer networks </option>";
                    if ($_SESSION["classification"] == 'theoretical computer science')
                      echo "<option selected> theoretical computer science </option>";
                    else
                      echo "<option> theoretical computer science </option>";
                    if ($_SESSION["classification"] == 'databases')
                      echo "<option selected> databases </option>";
                    else
                      echo "<option> databases </option>";
                    if ($_SESSION["classification"] == 'compiler design')
                      echo "<option selected> compiler design </option>";
                    else
                      echo "<option> compiler design </option>";
                    if ($_SESSION["classification"] == 'hardware')
                      echo "<option selected> hardware </option>";
                    else
                      echo "<option> hardware </option>";
                    if ($_SESSION["classification"] == 'project management')
                      echo "<option selected> project management </option>";
                    else
                      echo "<option> project management </option>";
                    if ($_SESSION["classification"] == 'mathematics')
                      echo "<option selected> mathematics </option>";
                    else
                      echo "<option> mathematics </option>";
                    if ($_SESSION["classification"] == 'others')
                      echo "<option selected> others </option>";
                    else
                      echo "<option> others </option>";
                    echo "</select> </td> </tr>";
                    echo "<tr></tr><tr></tr><tr></tr>";

                    echo "<tr> <td> <input type='reset' value='  Reset form  '> </td>";
                    echo "<td> <input type='submit' value='  Search  '> </td></tr>";
                    echo "</form></table>";
                  } // end if

                  // if no error variable is set, and the user is not coming back from the result list, then the expert search form is emtpy
                  else {
                    echo "<table cellpadding='0' cellspacing='5' border='0' width='85%'>";
                    echo "<form action = 'expert_result_list.php' method = 'post'>";
                    echo "<tr> <td> <div align='left'>author(s)<span style='color: #9F9F9F'> (more authors separated with &lt;space&gt;)</span></div> </td>";
                    echo "<td> <input type='text' name='author' value= '' size='30' maxlength='1000'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>title</div> </td>";
                    echo "<td> <input type='text' name='title' value= '' size='30' maxlength='250'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>subtitle</div> </td>";
                    echo "<td> <input type='text' name='subtitle' value= '' size='30' maxlength='1000'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>year<span style='color: #9F9F9F'> (yyyy)</span></div> </td>";
                    echo "<td> <input type='text' name='year' value= '' size='30' maxlength='4'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>publisher</div> </td>";
                    echo "<td> <input type='text' name ='publisher' value= '' size ='30' maxlength ='200'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>location</div> </td>";
                    echo "<td> <input type='text' name='location' value= '' size='30' maxlength='200'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>ISBN/ISSN</div> </td>";
                    echo "<td> <input type='text' name ='isbn' value= '' size ='30' maxlength ='13'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>keyword(s)<span style='color: #9F9F9F'> (more keywords separated with &lt;space&gt;)</span></div> </td>";
                    echo "<td> <input type='text' name='keywords' value= '' size='30' maxlength='1000'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>comment</div> </td>";
                    echo "<td> <input type='text' name ='comment' value= '' size ='30' maxlength ='2000'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>signature</div> </td>";
                    echo "<td> <input type='text' name='signature' value= '' size='30' maxlength='15'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>proceeding time<span style='color: #9F9F9F'> (yyyy-mm-dd, yyyy-mm or yyyy) </span></div> </td>";
                    echo "<td> <input type='text' name ='proc_time' value= '' size ='30' maxlength ='10'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>conference location<span style='color: #9F9F9F'> (only for proceedings) </span></div> </td>";
                    echo "<td> <input type='text' name='conf_loc' value= '' size='30' maxlength='200'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>supervisor<span style='color: #9F9F9F'> (only for thesises)                             </span></div> </td>";
                    echo "<td> <input type='text' name ='supervisor' value= '' size ='30' maxlength ='100'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>school<span style='color: #9F9F9F'> (only for thesises)                             </span></div> </td>";
                    echo "<td> <input type='text' name='school' value= '' size='30' maxlength='200'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>type</div> </td>";
                    echo "<td> <select name='type' size='1'>";
                    echo "<option selected> all </option>";
                    echo "<option> book </option>";
                    echo "<option> proceeding </option>";
                    echo "<option> manual </option>";
                    echo "<option> bachelor thesis </option>";
                    echo "<option> master thesis </option>";
                    echo "<option> phd thesis </option>";
                    echo "<option> miscellaneous </option>";
                    echo "</select> </td> </tr>";
                    echo "<tr> <td> <div align='left'>classification</div> </td>";
                    echo "<td> <select name='classification' size='1'>";
                    echo "<option selected> all </option>";
                    echo "<option> programming languages </option>";
                    echo "<option> software engineering </option>";
                    echo "<option> operation systems </option>";
                    echo "<option> computer networks </option>";
                    echo "<option> theoretical computer science </option>";
                    echo "<option> databases </option>";
                    echo "<option> compiler design </option>";
                    echo "<option> hardware </option>";
                    echo "<option> project management </option>";
                    echo "<option> mathematics </option>";
                    echo "<option> others </option>";
                    echo "<tr></tr><tr></tr><tr></tr>";

                    echo "<tr> <td> <input type='reset' value='  Reset form  '> </td>";
                    echo "<td> <input type='submit' value='  Search  '> </td></tr>";
                    echo "</form></table>";
                  } // end else

                  // delete session variables
                  unset($_SESSION["author"]);
                  unset($_SESSION["title"]);
                  unset($_SESSION["subtitle"]);
                  unset($_SESSION["year"]);
                  unset($_SESSION["publisher"]);
                  unset($_SESSION["location"]);
                  unset($_SESSION["isbn"]);
                  unset($_SESSION["keywords"]);
                  unset($_SESSION["comment"]);
                  unset($_SESSION["signature"]);
                  unset($_SESSION["proc_time"]);
                  unset($_SESSION["conf_loc"]);
                  unset($_SESSION["supervisor"]);
                  unset($_SESSION["school"]);
                  unset($_SESSION["type"]);
                  unset($_SESSION["classification"]);
                ?>
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

