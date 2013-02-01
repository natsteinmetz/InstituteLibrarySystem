<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "priv_change_obj";

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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="priv_func_overview.php">Privileged functions</a> &gt; <a class="crumbTrail" href="change_obj_search.php">Change object - Search & list</a> &gt; Change object</span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Change object</h2><br>

                <?php
                  // check if an error code is set
                  $error=0;
                  if (isset($_GET["error"]))
                    $error = $_GET["error"];

                  // extract number of authors and keywords via GET
                  $numAuthor=1;
                  if (isset($_GET["numAuthor"]))
                    $numAuthor = $_GET["numAuthor"];
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

                  // if an error variable is set, the values are filled in from saved session variables
                  if (($error != 0) || ($addedA) || ($addedK)) {
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
                      echo "<strong>This signature is already used 'yyyy'!</strong><br><br>";

                    echo "<table cellpadding='0' cellspacing='5' border='0' width='85%'>";
                    echo "<form action = 'change_obj_conf.php' method = 'post'>";

                    // the number of authors is taken from the variable numAuthors
                    echo "<input type='hidden' name='numAuthor' value='$numAuthor'>";
                    for ($i=0; $i<$numAuthor; $i++){
                      $j=$i+1;
                      echo "<tr> <td> <div align='left'>author $j</div> </td>";
                      echo "<td> <input type='text' name='author$i' value= '".$_SESSION["author"][$i]."' size='40' maxlength='150'> </td>";
                      echo "<td> <input type='submit' name='add_author' value='Add one more author'></td></tr>";
                    } // end for
                    echo "<tr> <td> <div align='left'>title<span style='color: #9F9F9F'> (required)</span></div> </td>";
                    echo "<td> <input type='text' name='title' value= '".$_SESSION["title"]."' size='40' maxlength='250'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>subtitle</div> </td>";
                    echo "<td> <input type='text' name='subtitle' value= '".$_SESSION["subtitle"]."' size='40' maxlength='1000'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>year<span style='color: #9F9F9F'> (yyyy)</span></div> </td>";
                    echo "<td> <input type='text' name='year' value= '".$_SESSION["year"]."' size='40' maxlength='4'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>publisher</div> </td>";
                    echo "<td> <input type='text' name ='publisher' value= '".$_SESSION["publisher"]."' size ='40' maxlength ='200'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>location</div> </td>";
                    echo "<td> <input type='text' name='location' value= '".$_SESSION["location"]."' size='40' maxlength='200'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>ISBN/ISSN</div> </td>";
                    echo "<td> <input type='text' name ='isbn' value= '".$_SESSION["isbn"]."' size ='40' maxlength ='13'> </td> </tr>";

                    // the number of keywords is taken from the variable numKeyword
                    echo "<input type='hidden' name='numKeyword' value='$numKeyword'>";
                    for ($i=0; $i<$numKeyword; $i++){
                      $j=$i+1;
                      echo "<tr> <td> <div align='left'>keyword $j</div> </td>";
                      echo "<td> <input type='text' name='keywords$i' value= '".$_SESSION["keywords"][$i]."' size='40' maxlength='150'> </td>";
                      echo "<td> <input type='submit' name='add_keyword' value='Add one more keyword'></td></tr>";
                    } // end for
                    echo "<tr> <td> <div align='left'>comment</div> </td>";
                    echo "<td> <input type='text' name ='comment' value= '".$_SESSION["comment"]."' size ='40' maxlength ='2000'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>signature<span style='color: #9F9F9F'> (required) </span></div> </td>";
                    echo "<td> <input type='text' name='signature' value= '".$_SESSION["signature"]."' size='40' maxlength='15'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>proceeding time<span style='color: #9F9F9F'> (yyyy-mm-dd, only for proceedings)                             </span></div> </td>";
                    echo "<td> <input type='text' name ='proc_time' value= '".$_SESSION["proc_time"]."' size ='40' maxlength ='10'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>conference location<span style='color: #9F9F9F'> (only for proceedings)                             </span></div> </td>";
                    echo "<td> <input type='text' name='conf_loc' value= '".$_SESSION["conf_loc"]."' size='40' maxlength='200'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>supervisor<span style='color: #9F9F9F'> (only for thesises)                             </span></div> </td>";
                    echo "<td> <input type='text' name ='supervisor' value= '".$_SESSION["supervisor"]."' size ='40' maxlength ='100'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>school<span style='color: #9F9F9F'> (only for thesises)                             </span></div> </td>";
                    echo "<td> <input type='text' name='school' value= '".$_SESSION["school"]."' size='40' maxlength='200'> </td> </tr>";
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
                    echo "<tr> <td> <div align='left'>status</div> </td>";
                    echo "<td> <select name ='status' size='1'>";
                    if ($_SESSION["status"] == 'new')
                      echo "<option selected> new </option>";
                    else
                      echo "<option> new </option>";
                    if ($_SESSION["status"] == 'available')
                      echo "<option selected> available </option>";
                    else
                      echo "<option> available </option>";
                    if ($_SESSION["status"] == 'not available')
                      echo "<option selected> not available </option>";
                    else
                      echo "<option> not available </option>";
                    if ($_SESSION["status"] == 'checked out')
                      echo "<option selected> checked out </option>";
                    else
                      echo "<option> checked out </option>";
                    if ($_SESSION["status"] == 'missing')
                      echo "<option selected> missing </option>";
                    else
                      echo "<option> missing </option>";
                    echo "</select> </td> </tr>";

                    echo "<input type='hidden' name='pid' value='".$_SESSION["pid"]."'>";
                    echo "<tr></tr><tr></tr><tr></tr>";

                    echo "<tr> <td> <input type='submit' value='Change object'> </td>";
                    echo "<td> <input type='reset' value='Reset form'> </td> </tr></form>";
                    echo "<tr><td></td></tr><tr><td></td></tr>";
                    if ($_SESSION["act_change_obj_page"] == "list") {
                      echo "<form action = 'change_obj_list.php' method = 'GET'>";
                      echo "<tr><td> <input type='submit' name='back' value='  Get back to object list  '></td>";
                      echo "</tr></form>";
                    } // end if
                    else {
                      echo "<form action = 'change_obj_search.php' method = 'GET'>";
                      echo "<tr><td> <input type='submit' name='back' value='  Get back to object list  '></td>";
                      echo "</tr></form>";
                    } // end else
                    echo "</table>";
                  } // end if

                  // if no error variable is set and no author or keyword field shall be added, the values are taken out of the database for the user id sent via GET from the user list
                  else {
                    // extract publication id that is sent from the object list via GET
                    $pid=-1;
                    if (isset($_GET["pid"]))
                      $pid = $_GET["pid"];

                    // start database connection for the superuser, with error handling
                    $db = mysql_connect("localhost", "librarySuperuser", "superuser");
                    if (!mysql_select_db ("stilibrary", $db)){
                      die ("Connection to database failed - superuser");
                    } // end if

                    // send select publication query to database
                    $res = mysql_db_query("stilibrary", "SELECT * FROM publication WHERE pid = '$pid';");
                    if (mysql_errno() != 0) {
                      // logging function call
                      $string = "Error: sqlSelectObj: " . mysql_errno() . ": " . mysql_error(). "\n";
                      library_log($string);
                      echo ("Database error! - Please see log file for detailed information.<br><br>");
                    } // end if

                    $numAuthor=1;
                    if(($author = mysql_result($res, 0, "author")) == 'NULL')
                      $arrayA = "";
                    else {
                      $arrayA = explode("; ", $author);
                      $numAuthor = count($arrayA);
                    } // end else
                    $title = mysql_result($res, 0, "title");
                    if(($subtitle = mysql_result($res, 0, "subtitle")) == 'NULL')
                      $subtitle = "";
                    if(($year = mysql_result($res, 0, "year")) == 'NULL' || $year == '0000')
                      $year = "";
                    if(($publisher = mysql_result($res, 0, "publisher")) == 'NULL')
                      $publisher = "";
                    if(($location = mysql_result($res, 0, "location")) == 'NULL')
                      $location = "";
                    if(($isbn = mysql_result($res, 0, "isbn")) == 'NULL')
                      $isbn = "";
                    $numKeyword=1;
                    if(($keywords = mysql_result($res, 0, "keywords")) == 'NULL')
                      $arrayK[0] = "";
                    else {
                      $arrayK = explode("; ", $keywords);
                      $numKeyword = count($arrayK);
                    } // end else
                    if(($comment = mysql_result($res, 0, "comment")) == 'NULL')
                      $comment = "";
                    $signature = mysql_result($res, 0, "signature");
                    if(($proc_time = mysql_result($res, 0, "procTime")) == 'NULL'|| $proc_time == '0000-00-00')
                      $proc_time = "";
                    if(($conf_loc = mysql_result($res, 0, "confLoc")) == 'NULL')
                      $conf_loc = "";
                    if(($supervisor = mysql_result($res, 0, "supervisor")) == 'NULL')
                      $supervisor = "";
                    if(($school = mysql_result($res, 0, "school")) == 'NULL')
                      $school = "";
                    $type = mysql_result($res, 0, "type");
                    $classification = mysql_result($res, 0, "classification");
                    $status = mysql_result($res, 0, "status");

                    // write the old values into session variables
                    $_SESSION["old_author"] = $author;
                    $_SESSION["old_title"] = $title;
                    $_SESSION["old_subtitle"] = $subtitle;
                    $_SESSION["old_year"] = $year;
                    $_SESSION["old_publisher"] = $publisher;
                    $_SESSION["old_location"] = $location;
                    $_SESSION["old_isbn"] = $isbn;
                    $_SESSION["old_keywords"] = $keywords;
                    $_SESSION["old_comment"] = $comment;
                    $_SESSION["old_signature"] = $signature;
                    $_SESSION["old_procTime"] = $proc_time;
                    $_SESSION["old_confLoc"] = $conf_loc;
                    $_SESSION["old_supervisor"] = $supervisor;
                    $_SESSION["old_school"] = $school;
                    $_SESSION["old_type"] = $type;
                    $_SESSION["old_classification"] = $classification;
                    $_SESSION["old_status"] = $status;

                    echo "<form action = 'change_obj_conf.php' method = 'post'>";
                    echo "<table cellpadding='0' cellspacing='5' border='0' width='85%'>";

                    echo "<input type='hidden' name='numAuthor' value='$numAuthor'>";
                    for ($i=0; $i<$numAuthor; $i++){
                      $j = $i+1;
                      echo "<tr> <td> <div align='left'>author $j</div> </td>";
                      echo "<td> <input type='text' name='author$i' value='$arrayA[$i]' size='40' maxlength='150'> </td>";                 echo "<td> <input type='submit' name='add_author' value='Add one more author'></td></tr>";
                    } // end for
                    echo "<tr> <td> <div align='left'>title<span style='color: #9F9F9F'> (required)</span></div> </td>";
                    echo "<td> <input type='text' name='title' value='$title' size='40' maxlength='250'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>subtitle</div> </td>";
                    echo "<td> <input type='text' name='subtitle' value='$subtitle' size='40' maxlength='1000'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>year<span style='color: #9F9F9F'> (yyyy)</span></div> </td>";
                    echo "<td> <input type='text' name ='year' value='$year' size ='40' maxlength ='4'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>publisher</div> </td>";
                    echo "<td> <input type='text' name='publisher' value='$publisher' size='40' maxlength='200'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>location</div> </td>";
                    echo "<td> <input type='text' name='location' value='$location' size='40' maxlength='200'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>isbn</div> </td>";
                    echo "<td> <input type='text' name='isbn' value='$isbn' size='40' maxlength='13'> </td> </tr>";
                    echo "<input type='hidden' name='numKeyword' value='$numKeyword'>";
                    for ($i=0; $i<$numKeyword; $i++){
                      $j = $i+1;
                      echo "<tr> <td> <div align='left'>keyword $j</div> </td>";
                      echo "<td> <input type='text' name ='keywords$i' value='$arrayK[$i]' size ='40' maxlength ='150'> </td>";
                      echo "<td> <input type='submit' name='add_keyword' value='Add one more keyword'></td></tr>";
                    } // end for
                    echo "<tr> <td> <div align='left'>comment</div> </td>";
                    echo "<td> <input type='text' name='comment' value='$comment' size='40' maxlength='2000'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>signature<span style='color: #9F9F9F'> (required) </span></div> </td>";
                    echo "<td> <input type='text' name='signature' value='$signature' size='40' maxlength='15'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>proceeding time<span style='color: #9F9F9F'> (yyyy-mm-dd, only for proceedings)</span></div> </td>";
                    echo "<td> <input type='text' name='proc_time' value='$proc_time' size='40' maxlength='10'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>conference location<span style='color: #9F9F9F'> (only for proceedings)</span></div> </td>";
                    echo "<td> <input type='text' name ='conf_loc' value='$conf_loc' size ='40' maxlength ='200'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>supervisor<span style='color: #9F9F9F'> (only for thesises)                             </span></div> </td>";
                    echo "<td> <input type='text' name='supervisor' value='$supervisor' size='40' maxlength='100'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>school<span style='color: #9F9F9F'> (only for thesises)                             </span></div> </td>";
                    echo "<td> <input type='text' name='school' value='$school' size='40' maxlength='200'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>type</div> </td>";
                    echo "<td> <select name='type' size='1'>";
                    if ($type == 'book')
                      echo "<option selected> book </option>";
                    else
                      echo "<option> book </option>";
                    if ($type == 'proceeding')
                      echo "<option selected> proceeding </option>";
                    else
                      echo "<option> proceeding </option>";
                    if ($type == 'manual')
                      echo "<option selected> manual </option>";
                    else
                      echo "<option> manual </option>";
                    if ($type == 'bachelor thesis')
                      echo "<option selected> bachelor thesis </option>";
                    else
                      echo "<option> bachelor thesis </option>";
                    if ($type == 'master thesis')
                      echo "<option selected> master thesis </option>";
                    else
                      echo "<option> master thesis </option>";
                    if ($type == 'phd thesis')
                      echo "<option selected> phd thesis </option>";
                    else
                      echo "<option> phd thesis </option>";
                    if ($type == 'miscellaneous')
                      echo "<option selected> miscellaneous </option>";
                    else
                      echo "<option> miscellaneous </option>";
                    echo "</select> </td> </tr>";
                    echo "<tr> <td> <div align='left'>classification</div> </td>";
                    echo "<td> <select name='classification' size='1'>";
                    if ($classification == 'programming languages')
                      echo "<option selected> programming languages </option>";
                    else
                      echo "<option> programming languages </option>";
                    if ($classification == 'software engineering')
                      echo "<option selected> software engineering </option>";
                    else
                      echo "<option> software engineering </option>";
                    if ($classification == 'operation systems')
                      echo "<option selected> operation systems </option>";
                    else
                      echo "<option> operation systems </option>";
                    if ($classification == 'computer networks')
                      echo "<option selected> computer networks </option>";
                    else
                      echo "<option> computer networks </option>";
                    if ($classification == 'theoretical computer science')
                      echo "<option selected> theoretical computer science </option>";
                    else
                      echo "<option> theoretical computer science </option>";
                    if ($classification == 'databases')
                      echo "<option selected> databases </option>";
                    else
                      echo "<option> databases </option>";
                    if ($classification == 'compiler design')
                      echo "<option selected> compiler design </option>";
                    else
                      echo "<option> compiler design </option>";
                    if ($classification == 'hardware')
                      echo "<option selected> hardware </option>";
                    else
                      echo "<option> hardware </option>";
                    if ($classification == 'project management')
                      echo "<option selected> project management </option>";
                    else
                      echo "<option> project management </option>";
                    if ($classification == 'mathematics')
                      echo "<option selected> mathematics </option>";
                    else
                      echo "<option> mathematics </option>";
                    if ($classification == 'others')
                      echo "<option selected> others </option>";
                    else
                      echo "<option> others </option>";
                    echo "</select> </td> </tr>";
                    echo "<tr> <td> <div align='left'>status</div> </td>";
                    echo "<td> <select name ='status' size='1'>";
                    if ($status == 'new')
                      echo "<option selected> new </option>";
                    else
                      echo "<option> new </option>";
                    if ($status == 'available')
                      echo "<option selected> available </option>";
                    else
                      echo "<option> available </option>";
                    if ($status == 'not available')
                      echo "<option selected> not available </option>";
                    else
                      echo "<option> not available </option>";
                    if ($status == 'checked out')
                      echo "<option selected> checked out </option>";
                    else
                      echo "<option> checked out </option>";
                    if ($status == 'missing')
                      echo "<option selected> missing </option>";
                    else
                      echo "<option> missing </option>";
                    echo "</select> </td> </tr>";

                    echo "<input type='hidden' name='pid' value='$pid'>";
                    echo "<tr></tr><tr></tr><tr></tr>";

                    echo "<tr> <td> <input type='submit' value='  Change object  '> </td>";
                    echo "<td> <input type='reset' value='  Reset to initial value  '> </td> </tr></form>";
                    echo "<tr><td></td></tr><tr><td></td></tr>";
                    if ($_SESSION["act_change_obj_page"] == "list") {
                      echo "<form action = 'change_obj_list.php' method = 'GET'>";
                      echo "<tr><td> <input type='submit' name='back' value='  Get back to object list  '></td>";
                      echo "</tr></form>";
                    } // end if
                    else {
                      echo "<form action = 'change_obj_search.php' method = 'GET'>";
                      echo "<tr><td> <input type='submit' name='back' value='  Get back to object list  '></td>";
                      echo "</tr></form>";
                    } // end else
                    echo "</table>";

                    // close database connection
                    mysql_close($db);
                  } // end else

                  // delete session variables
                  unset($_SESSION["pid"]);
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
                  unset($_SESSION["status"]);
                  unset($_SESSION["numA"]);
                  unset($_SESSION["numK"]);
                ?>

              </td>
            </tr>
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

