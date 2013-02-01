<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "priv_add_obj_conf";

  // start session, check if the user is already logged in and if he is a superuser or not
  include ("../check_user.inc");
  include ("../library_functions.inc");

  // check if the logged-in is a superuser
  if (!$user_superuser && isset($_SESSION["user_id"])){
    header("Location: ../User/sti_library.php?error=1");
    exit;
  } // end if

  // extract values from POST
  $add_author="";                         // if an author field shall be added to the form
  if (isset($_POST["add_author"]))
    $add_author = $_POST["add_author"];
  $add_keyword="";                        // if a keyword field shall be added to the form
  if (isset($_POST["add_keyword"]))
    $add_keyword = $_POST["add_keyword"];
  $numAuthor=1;                           // number of authors
  if (isset($_POST["numAuthor"]))
    $numAuthor = $_POST["numAuthor"];
  $numKeyword=1;                          // number of keywords
  if (isset($_POST["numKeyword"]))
    $numKeyword = $_POST["numKeyword"];
  for ($i=0; $i<$numAuthor; $i++){        // extract 'numAuthor' authors
    $authors[$i]="";
    if (isset($_POST["author$i"]))
      $authors[$i] = $_POST["author$i"];
  } // end for
  $title="";
  if (isset($_POST["title"]))
    $title = $_POST["title"];
  $subtitle="";
  if (isset($_POST["subtitle"]))
    $subtitle = $_POST["subtitle"];
  $year="";
  if (isset($_POST["year"]))
    $year = $_POST["year"];
  $publisher="";
  if (isset($_POST["publisher"]))
    $publisher = $_POST["publisher"];
  $location="";
  if (isset($_POST["location"]))
    $location = $_POST["location"];
  $isbn="";
  if (isset($_POST["isbn"]))
    $isbn = $_POST["isbn"];
  for ($i=0; $i<$numKeyword; $i++){       // extract 'numKeyword' keywords
    $keyword[$i]="";
    if (isset($_POST["keywords$i"]))
      $keyword[$i] = $_POST["keywords$i"];
  } // end for
  $comment="";
  if (isset($_POST["comment"]))
    $comment = $_POST["comment"];
  $signature="";
  if (isset($_POST["signature"]))
    $signature = $_POST["signature"];
  $proc_time="";
  if (isset($_POST["proc_time"]))
    $proc_time = $_POST["proc_time"];
  $conf_loc="";
  if (isset($_POST["conf_loc"]))
    $conf_loc = $_POST["conf_loc"];
  $supervisor="";
  if (isset($_POST["supervisor"]))
    $supervisor = $_POST["supervisor"];
  $school="";
  if (isset($_POST["school"]))
    $school = $_POST["school"];
  $type="";
  if (isset($_POST["type"]))
    $type = $_POST["type"];
  $classification="";
  if (isset($_POST["classification"]))
    $classification = $_POST["classification"];

  // write values into session variables
  for ($i=0; $i<$numAuthor; $i++){
    $_SESSION["author"][$i] = $authors[$i];
  } // end for
  $_SESSION["title"] = $title;
  $_SESSION["subtitle"] = $subtitle;
  $_SESSION["year"] = $year;
  $_SESSION["publisher"] = $publisher;
  $_SESSION["location"] = $location;
  $_SESSION["isbn"] = $isbn;
  for ($i=0; $i<$numKeyword; $i++){
    $_SESSION["keywords"][$i] = $keyword[$i];
  } // end for
  $_SESSION["comment"] = $comment;
  $_SESSION["signature"] = $signature;
  $_SESSION["proc_time"] = $proc_time;
  $_SESSION["conf_loc"] = $conf_loc;
  $_SESSION["supervisor"] = $supervisor;
  $_SESSION["school"] = $school;
  $_SESSION["type"] = $type;
  $_SESSION["classification"] = $classification;
  $_SESSION["numA"] = $numAuthor;
  $_SESSION["numK"] = $numKeyword;

  // if an author shall be added, the variable addedA is set and the variables are sent back to the previous page
  if ($add_author != ""){
    $addedA=1;
    $addedK=0;

    header("Location: add_obj.php?numAuthor=$numAuthor&numKeyword=$numKeyword&addedA=$addedA&addedK=$addedK");
    exit;
  } // end if

  // if a keyword shall be added, the variable addedK is set and the variables are sent back to the previous page
  if ($add_keyword != ""){
    $addedK=1;
    $addedA=0;

    header("Location: add_obj.php?numAuthor=$numAuthor&numKeyword=$numKeyword&addedA=$addedA&addedK=$addedK");
    exit;
  } // end if

  // title and signature are required fields
  if (($title == "") || ($signature == "")){
    header("Location: add_obj.php?error=1&numAuthor=$numAuthor&numKeyword=$numKeyword");
    exit;
  } // end if

  // proceeding time and conference location are only needed for the object type 'proceeding'
  if (($proc_time != "" || $conf_loc != "") && ($type != "proceeding")){
    header("Location: add_obj.php?error=2&numAuthor=$numAuthor&numKeyword=$numKeyword");
    exit;
  } // end if

  // supervisor and school are only needed for one of the 'thesis' object types
  $thesis = stristr($type, "thesis");
  if (($supervisor != "" || $school != "") && ($thesis == false) ){
    header("Location: add_obj.php?error=3&numAuthor=$numAuthor&numKeyword=$numKeyword");
    exit;
  } // end if

  // the year must contain four numerals
  if ($year != "" && (strlen($year) != 4 || !is_numeric($year))){
    header("Location: add_obj.php?error=4&numAuthor=$numAuthor&numKeyword=$numKeyword");
    exit;
  } // end if

  // the proceeding time must be of the format 'yyyy-mm-dd'
  if ($proc_time != "" && (strlen($proc_time) != 10 || strpos($proc_time, "-")!=4 || strrpos($proc_time, "-")!=7)){
    header("Location: add_obj.php?error=5&numAuthor=$numAuthor&numKeyword=$numKeyword");
    exit;
  } // end if

  // the proceeding time must be a valid date
  $proc_date = explode("-", $proc_time);
  if ($proc_time != "" && !checkdate($proc_date[0], $proc_date[1], $proc_date[2])){
    header("Location: add_obj.php?error=6&numAuthor=$numAuthor&numKeyword=$numKeyword");
    exit;
  } // end if

  // start database connection for the superuser, with error handling
  $db = mysql_connect("localhost", "librarySuperuser", "superuser");
  if (!mysql_select_db ("stilibrary", $db)){
    die ("Connection to database failed - superuser");
  } // end if

  // send query to database
  $res1 = mysql_db_query("stilibrary", "SELECT signature FROM publication WHERE signature = '$signature';");
  if (mysql_errno() != 0) {
    // logging function call
    $string = "Error: " . mysql_errno() . ": " . mysql_error(). "\n";
    library_log($string);
    echo ("Database error! - Please see log file for detailed information.<br><br>");
  } // end if

  // an error code is set, if the chosen username exists already. The user is sent back to the previous page.
  $num1 = mysql_num_rows($res1);
  if ($num1 > 0){
    // close database connection
    mysql_close($db);

    header("Location: add_obj.php?error=7&numAuthor=$numAuthor&numKeyword=$numKeyword");
    exit;
  } // end if

  // close database connection
  mysql_close($db);
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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a>  &gt; <a class="crumbTrail" href="priv_func_overview.php">Privileged functions</a> &gt; <a class="crumbTrail" href="add_obj.php?new=1">Add new object</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Add new object</h2><br>

                <?php

                  // start database connection for the superuser, with error handling
                  $db = mysql_connect("localhost", "librarySuperuser", "superuser");
                  if (!mysql_select_db ("stilibrary", $db)){
                    die ("Connection to database failed - superuser");
                  } // end if

                  // check values for NULL values and build author and keywords value
                  for ($i=0; $i<$numAuthor; $i++){
                    if ($i == 0) {
                      $author = $authors[$i]; }
                    else {
                      $author .= "; " . $authors[$i]; }
                  } // end for
                  if ($author == "")
                    $author = 'NULL';
                  if ($subtitle == "")
                    $subtitle = 'NULL';
                  if ($year == "")
                    $year = 'NULL';
                  if ($publisher == "")
                    $publisher = 'NULL';
                  if ($location == "")
                    $location = 'NULL';
                  if ($isbn == "")
                    $isbn = 'NULL';
                  for ($i=0; $i<$numKeyword; $i++){
                    if ($i == 0) {
                      $keywords = $keyword[$i]; }
                    else {
                      $keywords .= "; " . $keyword[$i]; }
                  } // end for
                  if ($keywords == "")
                    $keywords = 'NULL';
                  if ($comment == "")
                    $comment = 'NULL';
                  if ($proc_time == "")
                    $proc_time = 'NULL';
                  if ($conf_loc == "")
                    $conf_loc = 'NULL';
                  if ($supervisor == "")
                    $supervisor = 'NULL';
                  if ($school == "")
                    $school = 'NULL';

                  // today's date for the origin date of the publication. This helps look when the 'new' status of the publication can be changed into 'available'
                  $today = date("Y-m-d");

                  // check if the author contains a single quote " ' "
                  if(strpos($author, "'") != 0) {
                    $author = str_replace("'","\'", $author);
                  }
                  // check if the title contains a single quote " ' "
                  if(strpos($title, "'") != 0) {
                    $title = str_replace("'","\'", $title);
                  }
                  // check if the subtitle contains a single quote " ' "
                  if(strpos($subtitle, "'") != 0) {
                    $subtitle = str_replace("'","\'", $subtitle);
                  }
                  // check if the publisher contains a single quote " ' "
                  if(strpos($publisher, "'") != 0) {
                    $publisher = str_replace("'","\'", $publisher);
                  }
                  // check if the location contains a single quote " ' "
                  if(strpos($location, "'") != 0) {
                    $location = str_replace("'","\'", $location);
                  }
                  // check if the keywords contain a single quote " ' "
                  if(strpos($keywords, "'") != 0) {
                    $keywords = str_replace("'","\'", $keywords);
                  }
                  // check if the comment contains a single quote " ' "
                  if(strpos($comment, "'") != 0) {
                    $comment = str_replace("'","\'", $comment);
                  }
                  // check if the conf_loc contains a single quote " ' "
                  if(strpos($conf_loc, "'") != 0) {
                    $conf_loc = str_replace("'","\'", $conf_loc);
                  }
                  // check if the supervisor contains a single quote " ' "
                  if(strpos($supervisor, "'") != 0) {
                    $supervisor = str_replace("'","\'", $supervisor);
                  }
                  // check if the school contains a single quote " ' "
                  if(strpos($school, "'") != 0) {
                    $school = str_replace("'","\'", $school);
                  }

                  // build sql insert publication string
                  $sqlInsertObj = "INSERT INTO publication VALUES ('NULL', '$author', '$title', '$subtitle', '$year', '$publisher', '$location', '$isbn', '$keywords', '$comment', '$signature', '$proc_time', '$conf_loc', '$supervisor', '$school', '$type', '$classification', 'new', '$today');";

                  // send query to database
                  mysql_db_query("stilibrary", $sqlInsertObj);
                  if (mysql_errno() != 0) {
                    // logging function call
                    $string = "Error: sqlInsertObj: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlInsertObj. "\n";
                    library_log($string);
                    echo ("Database error! - Please see log file for detailed information.<br><br>");
                  } // end if

                  // check if the insert was successfull
                  $num = mysql_affected_rows();
                  if ($num>0) {
                    // send select publication query to database
                    $res = mysql_db_query("stilibrary", "SELECT * FROM publication WHERE signature = '$signature';");

                    // extract publication results
                    $pid = mysql_result($res, 0, "author");
                    $author = mysql_result($res, 0, "author");
                    $title = mysql_result($res, 0, "title");
                    $subtitle = mysql_result($res, 0, "subtitle");
                    $year = mysql_result($res, 0, "year");
                    $publisher = mysql_result($res, 0, "publisher");
                    $location = mysql_result($res, 0, "location");
                    $isbn = mysql_result($res, 0, "isbn");
                    $keywords = mysql_result($res, 0, "keywords");
                    $comment = mysql_result($res, 0, "comment");
                    $signature = mysql_result($res, 0, "signature");
                    $proc_time = mysql_result($res, 0, "procTime");
                    $conf_loc = mysql_result($res, 0, "confLoc");
                    $supervisor = mysql_result($res, 0, "supervisor");
                    $school = mysql_result($res, 0, "school");
                    $type = mysql_result($res, 0, "type");
                    $classification = mysql_result($res, 0, "classification");
                    $status = mysql_result($res, 0, "status");

                    echo "<strong> You've succesfully added this ", $type, " to the database. </strong>";
                    echo "<br><br>";

                    echo "<table cellspacing='10'>";
                    if(( $author != 'NULL') && ($author != '')) {
                      echo "<tr> <td> <div align='right'><strong> author(s) </strong></div> </td>";
                      echo "<td>", $author, "</td> </tr>"; }
                    echo "<tr> <td> <div align='right'><strong> title </strong></div> </td>";
                    echo "<td>", $title, "</td> </tr>";
                    if(($subtitle != 'NULL') && ($subtitle != '')) {
                      echo "<tr> <td> <div align='right'><strong> subtitle </strong></div> </td>";
                      echo "<td>", $subtitle, "</td> </tr>";}
                    if(($year != 'NULL') && ($year != '') && ($year != '0000')) {
                      echo "<tr> <td> <div align='right'><strong> year </strong></div> </td>";
                      echo "<td>", $year, "</td> </tr>";}
                    if(($publisher != 'NULL') && ($publisher != '')) {
                      echo "<tr> <td> <div align='right'><strong> publisher </strong></div> </td>";
                      echo "<td>", $publisher, "</td> </tr>";}
                    if(($location != 'NULL') && ($location != '')) {
                      echo "<tr> <td> <div align='right'><strong> location </strong></div> </td>";
                      echo "<td>", $location, "</td> </tr>";}
                    if(($isbn != 'NULL') && ($isbn != '')) {
                      echo "<tr> <td> <div align='right'><strong> ISBN / ISSN </strong></div> </td>";
                      echo "<td>", $isbn, "</td> </tr>";}
                    if(($keywords != 'NULL') && ($keywords != '')) {
                      echo "<tr> <td> <div align='right'><strong> keywords </strong></div> </td>";
                      echo "<td>", $keywords, "</td> </tr>";}
                    if(($comment != 'NULL') && ($comment != '')) {
                      echo "<tr> <td> <div align='right'><strong> comment </strong></div> </td>";
                      echo "<td>", $comment, "</td> </tr>";}
                    echo "<tr> <td> <div align='right'><strong> signature </strong></div> </td>";
                    echo "<td>", $signature, "</td> </tr>";
                    if(($proc_time != 'NULL') && ($proc_time != '0000-00-00') && ($proc_time != '')) {
                      echo "<tr> <td> <div align='right'><strong> proceeding time </strong></div> </td>";
                      echo "<td>", $proc_time, "</td> </tr>";}
                    if(($conf_loc != 'NULL') && ($conf_loc != '')) {
                      echo "<tr> <td> <div align='right'><strong> conference location </strong></div> </td>";
                      echo "<td>", $conf_loc, "</td> </tr>";}
                    if(($supervisor != 'NULL') && ($supervisor != '')) {
                      echo "<tr> <td> <div align='right'><strong> supervisor </strong></div> </td>";
                      echo "<td>", $supervisor, "</td> </tr>";}
                    if(($school != 'NULL') && ($school != '')) {
                      echo "<tr> <td> <div align='right'><strong> school </strong></div> </td>";
                      echo "<td>", $school, "</td> </tr>";}
                    echo "<tr> <td> <div align='right'><strong> type </strong></div> </td>";
                    echo "<td>", $type, "</td> </tr>";
                    echo "<tr> <td> <div align='right'><strong> classification </strong></div> </td>";
                    echo "<td>", $classification, "</td> </tr>";
                    echo "<tr> <td> <div align='right'><strong> status </strong></div> </td>";
                    echo "<td>", $status, "</td> </tr>";
                    echo "</table> <br>";

                    // logging function call
                    $string = "Successfully added the publication with id " . $pid . "\n";
                    library_log($string);
                  }
                  else {
                    // logging function call
                    $string = "Error: Couldn't add the publication with signature " . $signature . "\n";
                    library_log($string);
                    echo "<br><strong> The ", $type, " hasn't been added to the database. </strong><br>";
                    echo "<br><br>";
                  }

                  // close database connection
                  mysql_close($db);
                ?>

                <table>
                  <tr>
                    <form action="add_obj.php" method = "GET">
                      <td><input type="submit" name="add_new" value="  Add another object  "></td>
                    </form>
                    <form action="priv_func_overview.php" method = "GET">
                      <td><input type="submit" name="priv_func_button" value= "  Privileged functions overview  "></td>
                    </form>
                  </tr>
                </table>

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

