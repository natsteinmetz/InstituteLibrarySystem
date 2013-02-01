<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "priv_add_obj";

  // start session, check if the user is already logged in and if he is a superuser or not
  include ("../check_user.inc");
  include ("../library_functions.inc");

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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="priv_func_overview.php">Privileged functions</a> &gt; <a class="crumbTrail" href="add_obj.php">Add new object</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tbody>
              <tr>
                <td>

                  <h2>Add new object</h2><br>

                  <?php
                    // check if an error code is set
                    $error=0;
                    if (isset($_GET["error"]))
                      $error = $_GET["error"];

                    // check if a new object shall be added
                    $new=0;
                    if (isset($_GET["new"]))
                      $new = $_GET["new"];
                    if (isset($_GET["add_new"])){
                      $new = $_GET["add_new"];
                      if ($new != "")
                        $new = 1;
                    } // end if

                    // extract number of authors via GET
                    $numAuthor=1;
                    if (isset($_GET["numAuthor"]))
                      $numAuthor = $_GET["numAuthor"];

                    // extract number of keywords via GET
                    $numKeyword=1;
                    if (isset($_GET["numKeyword"]))
                      $numKeyword = $_GET["numKeyword"];

                    // if this variable is set, an author field is added to the form
                    $addedA=0;
                    if (isset($_GET["addedA"]))
                      $addedA = $_GET["addedA"];

                    // if this variable is set, a keyword field is added to the form
                    $addedK=0;
                    if (isset($_GET["addedK"]))
                      $addedK = $_GET["addedK"];

                    // if an author is added, the number of authors must be increased by 1
                    if ($addedA)
                      $numAuthor = $numAuthor+1;

                    // if a keyword is added, the number of keywords must be increased by 1
                    if ($addedK)
                      $numKeyword = $numKeyword+1;

                    // a new object shall be added, if the variable new is set. The form is empty
                    if ($new){
                      $new=0;
                      echo "<table cellpadding='0' cellspacing='5' border='0' width='85%'>";
                      echo "<form action = 'add_obj_conf.php' method = 'post'>";

                      // the number of authors starts by 1
                      echo "<input type='hidden' name='numAuthor' value='$numAuthor'>";
                      echo "<tr> <td> <div align='left'>author 1</div> </td>";
                      echo "<td> <input type='text' name='author0' value= '' size='30' maxlength='150'> </td>";
                      echo "<td> <input type='submit' name='add_author' value='Add one more author'></td></tr>";
                      echo "<tr> <td> <div align='left'>title<span style='color: #9F9F9F'> (required)</span></div> </td>";
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

                      // the number of keywords starts by 1
                      echo "<input type='hidden' name='numKeyword' value='$numKeyword'>";
                      echo "<tr> <td> <div align='left'>keyword 1</div> </td>";
                      echo "<td> <input type='text' name='keywords0' value= '' size='30' maxlength='150'> </td>";
                      echo "<td> <input type='submit' name='add_keyword' value='Add one more keyword'></td></tr>";
                      echo "<tr> <td> <div align='left'>comment</div> </td>";
                      echo "<td> <input type='text' name ='comment' value= '' size ='30' maxlength ='2000'> </td> </tr>";
                      echo "<tr> <td> <div align='left'>signature<span style='color: #9F9F9F'> (required) </span></div> </td>";
                      echo "<td> <input type='text' name='signature' value= '' size='30' maxlength='15'> </td> </tr>";
                      echo "<tr> <td> <div align='left'>proceeding time<span style='color: #9F9F9F'> (yyyy-mm-dd, only for proceedings)                             </span></div> </td>";
                      echo "<td> <input type='text' name ='proc_time' value= '' size ='30' maxlength ='10'> </td> </tr>";
                      echo "<tr> <td> <div align='left'>conference location<span style='color: #9F9F9F'> (only for proceedings)                             </span></div> </td>";
                      echo "<td> <input type='text' name='conf_loc' value= '' size='30' maxlength='200'> </td> </tr>";
                      echo "<tr> <td> <div align='left'>supervisor<span style='color: #9F9F9F'> (only for thesises)                             </span></div> </td>";
                      echo "<td> <input type='text' name ='supervisor' value= '' size ='30' maxlength ='100'> </td> </tr>";
                      echo "<tr> <td> <div align='left'>school<span style='color: #9F9F9F'> (only for thesises)                             </span></div> </td>";
                      echo "<td> <input type='text' name='school' value= '' size='30' maxlength='200'> </td> </tr>";
                      echo "<tr> <td> <div align='left'>type</div> </td>";
                      echo "<td> <select name='type' size='1'>";
                      echo "<option selected> book </option>";
                      echo "<option> proceeding </option>";
                      echo "<option> manual </option>";
                      echo "<option> bachelor thesis </option>";
                      echo "<option> master thesis </option>";
                      echo "<option> phd thesis </option>";
                      echo "<option> miscellaneous </option>";
                      echo "</select> </td> </tr>";
                      echo "<tr> <td> <div align='left'>classification</div> </td>";
                      echo "<td> <select name='classification' size='1'>";
                      echo "<option selected> programming languages </option>";
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

                      echo "<tr> <td> <input type='submit' value='Add object'> </td>";
                      echo "<td> <input type='reset' value='Reset form'> </td> </tr>";
                      echo "</form></table>";
                    } // end if

                    // if the variable $new is not set, the form is filled by values from session variables. This could be for example, if another author or keyword field is added, or if an error occured
                    else {
                      // check if an error code is set
                      if ($error != 0) {
                        // check which error code is set
                        if ($error == 1)
                          echo "<strong>Title and signature are required fields!</strong><br><br>";
                        if ($error == 2)
                          echo "<strong>Proceeding time and conference location are only needed for proceedings!</strong><br><br>";
                        if ($error == 3)
                          echo "<strong>School and supervisor are only needed for thesises!</strong><br><br>";
                        if ($error == 4)
                          echo "<strong>Year must be of format 'yyyy'!</strong><br><br>";
                        if ($error == 5)
                          echo "<strong>Proceeding time must be of format 'yyyy-mm-dd'!</strong><br><br>";
                        if ($error == 6)
                          echo "<strong>Proceeding time must be a valid date!</strong><br><br>";
                        if ($error == 7)
                          echo "<strong>The signature must be unique - there exists already a publication with this signature!</strong><br><br>";
                      } // end if

                      echo "<table cellpadding='0' cellspacing='5' border='0' width='85%'>";
                      echo "<form action = 'add_obj_conf.php' method = 'post'>";

                      // the number of authors is taken from the variable numAuthors
                      echo "<input type='hidden' name='numAuthor' value='$numAuthor'>";
                      for ($i=0; $i<$numAuthor; $i++){
                        $j=$i+1;
                        echo "<tr> <td> <div align='left'>author $j</div> </td>";
                        echo "<td> <input type='text' name='author$i' value= '".$_SESSION["author"][$i]."' size='30' maxlength='150'> </td>";
                        echo "<td> <input type='submit' name='add_author' value='Add one more author'></td></tr>";
                      } // end for
                      echo "<tr> <td> <div align='left'>title<span style='color: #9F9F9F'> (required)</span></div> </td>";
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

                      // the number of keywords is taken from the variable numKeyword
                      echo "<input type='hidden' name='numKeyword' value='$numKeyword'>";
                      for ($i=0; $i<$numKeyword; $i++){
                        $j=$i+1;
                        echo "<tr> <td> <div align='left'>keyword $j</div> </td>";
                        echo "<td> <input type='text' name='keywords$i' value= '".$_SESSION["keywords"][$i]."' size='30' maxlength='150'> </td>";
                        echo "<td> <input type='submit' name='add_keyword' value='Add one more keyword'></td></tr>";
                      } // end for
                      echo "<tr> <td> <div align='left'>comment</div> </td>";
                      echo "<td> <input type='text' name ='comment' value= '".$_SESSION["comment"]."' size ='30' maxlength ='2000'> </td> </tr>";
                      echo "<tr> <td> <div align='left'>signature<span style='color: #9F9F9F'> (required) </span></div> </td>";
                      echo "<td> <input type='text' name='signature' value= '".$_SESSION["signature"]."' size='30' maxlength='15'> </td> </tr>";
                      echo "<tr> <td> <div align='left'>proceeding time<span style='color: #9F9F9F'> (yyyy-mm-dd, only for proceedings)                             </span></div> </td>";
                      echo "<td> <input type='text' name ='proc_time' value= '".$_SESSION["proc_time"]."' size ='30' maxlength ='10'> </td> </tr>";
                      echo "<tr> <td> <div align='left'>conference location<span style='color: #9F9F9F'> (only for proceedings)                             </span></div> </td>";
                      echo "<td> <input type='text' name='conf_loc' value= '".$_SESSION["conf_loc"]."' size='30' maxlength='200'> </td> </tr>";
                      echo "<tr> <td> <div align='left'>supervisor<span style='color: #9F9F9F'> (only for thesises)                             </span></div> </td>";
                      echo "<td> <input type='text' name ='supervisor' value= '".$_SESSION["supervisor"]."' size ='30' maxlength ='100'> </td> </tr>";
                      echo "<tr> <td> <div align='left'>school<span style='color: #9F9F9F'> (only for thesises)                             </span></div> </td>";
                      echo "<td> <input type='text' name='school' value= '".$_SESSION["school"]."' size='30' maxlength='200'> </td> </tr>";
                      echo "<tr> <td> <div align='left'>type</div> </td>";
                      echo "<td> <select name='type' size='1'>";
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

                      echo "<tr> <td> <input type='submit' value='Add object'> </td>";
                      echo "<td> <input type='reset' value='Reset form'> </td> </tr>";
                      echo "</form></table>";
                    } // end else

                    // delete session variables
                    for ($i=0; $i<$_SESSION["numA"]; $i++){
                      unset($_SESSION["author"][$i]);
                    } // end for
                    unset($_SESSION["title"]);
                    unset($_SESSION["subtitle"]);
                    unset($_SESSION["year"]);
                    unset($_SESSION["publisher"]);
                    unset($_SESSION["location"]);
                    unset($_SESSION["isbn"]);
                    for ($i=0; $i<$_SESSION["numK"]; $i++){
                      unset($_SESSION["keywords"][$i]);
                    } // end for
                    unset($_SESSION["comment"]);
                    unset($_SESSION["signature"]);
                    unset($_SESSION["proc_time"]);
                    unset($_SESSION["conf_loc"]);
                    unset($_SESSION["supervisor"]);
                    unset($_SESSION["school"]);
                    unset($_SESSION["type"]);
                    unset($_SESSION["classification"]);
                    unset($_SESSION["numA"]);
                    unset($_SESSION["numK"]);
                  ?>

                </td>
              </tr>
            </tbody>
          </table>

        </td>
      </tr>
    </table>

    <?php
      // including links
      include("menue3.inc");
    ?>

  </body>

</html>

