<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "expert_result";

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

      <span class="crumbTrail"><a class="crumbTrail" href="sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="expert_search.php">Expert search</a> &gt; <a class="crumbTrail" href="expert_result_list.php?get_back=getBack">Search results</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Search results</h2><br>

                <?php
                  // the variable noSearch indicates whether a search has to be made
                  $noSearch=0;

                  // checking if the user is getting back to this page from an object detail page
                  $get_back="";
                  if (isset($_GET["get_back"]))
                    $get_back = $_GET["get_back"];

                  // if the user gets back from an object detail page, the old search string is used from a session variable
                  if ($get_back != "") {
                    $sqlSelectObj = $_SESSION["expert_search_string"];
                    // if the $sqlSelectObj saved in the session variable is still the base string, no search word is defined
                    if ($sqlSelectObj == "SELECT pid, author, title, year, signature, status FROM publication WHERE ") {
                      $noSearch=1;
                      echo "<strong> No search words defined!</strong><br><br>";
                    } // end if
                  } // end if

                  // if this page is reached from the search page, the new search string is built
                  else {
                    // build the database sql select string
                    $sqlSelectObj = "SELECT pid, author, title, year, signature, status FROM publication WHERE ";                   // control string to see if the sql select string has already changed
                    $sqlSelectObjControl = "SELECT pid, author, title, year, signature, status FROM publication WHERE ";
                    // the author variable is split up, to see if there are more authors searched for
                    if (($author = $_POST["author"]) != "") {
                      $arrayA = explode(" ", $author);
                      for ($i=0; $i<count($arrayA); $i++)
                        $arrayA[$i] = trim($arrayA[$i], " ");
                      if (count($arrayA) == 1)
                        $sqlSelectObj .= "author LIKE '%$author%'";
                      else {
                        $sqlSelectObj .= "author LIKE '%$arrayA[0]%'";
                        for ($i=1; $i<count($arrayA); $i++) {
                          $sqlSelectObj .= " AND author LIKE '%$arrayA[$i]%'";
                        } // end for
                      } // end else
                    } // end if
                    if (($title = $_POST["title"]) != ""){
                      if ($sqlSelectObj == $sqlSelectObjControl)
                        $sqlSelectObj .= " title LIKE '%$title%'";
                      else
                        $sqlSelectObj .= " AND title LIKE '%$title%'";
                    } // end if
                    if (($subtitle = $_POST["subtitle"]) != ""){
                      if ($sqlSelectObj == $sqlSelectObjControl)
                        $sqlSelectObj .= " subtitle LIKE '%$subtitle%'";
                      else
                        $sqlSelectObj .= " AND subtitle LIKE '%$subtitle%'";
                    } // end if
                    if (($year = $_POST["year"]) != ""){
                      if ($sqlSelectObj == $sqlSelectObjControl)
                        $sqlSelectObj .= " year LIKE '%$year%'";
                      else
                        $sqlSelectObj .= " AND year LIKE '%$year%'";
                    } // end if
                    if (($publisher = $_POST["publisher"]) != "") {
                      if ($sqlSelectObj == $sqlSelectObjControl)
                        $sqlSelectObj .= " publisher LIKE '%$publisher%'";
                      else
                        $sqlSelectObj .= " AND publisher LIKE '%$publisher%'";
                    } // end if
                    if (($location = $_POST["location"]) != ""){
                      if ($sqlSelectObj == $sqlSelectObjControl)
                        $sqlSelectObj .= " location LIKE '%$location%'";
                      else
                        $sqlSelectObj .= " AND location LIKE '%$location%'";
                    } // end if
                    if (($isbn = $_POST["isbn"]) != "") {
                      if ($sqlSelectObj == $sqlSelectObjControl)
                        $sqlSelectObj .= " isbn LIKE '%$isbn%'";
                      else
                        $sqlSelectObj .= " AND isbn LIKE '%$isbn%'";
                    } // end if
                    // the keywords variable is split up, to see if there are more keywords searched for
                    if (($keywords = $_POST["keywords"]) != ""){
                      $arrayK = explode(" ", $keywords);
                      for ($i=0; $i<count($arrayK); $i++)
                        $arrayK[$i] = trim($arrayK[$i], " ");
                      if (count($arrayK) == 1) {
                        if ($sqlSelectObj == $sqlSelectObjControl)
                          $sqlSelectObj .= " keywords LIKE '%$keywords%'";
                        else
                          $sqlSelectObj .= " AND keywords LIKE '%$keywords%'";
                      } // end if
                      else {
                        if ($sqlSelectObj == $sqlSelectObjControl)
                          $sqlSelectObj .= " keywords LIKE '%$arrayK[0]%'";
                        else
                          $sqlSelectObj .= " AND keywords LIKE '%$arrayK[0]%'";
                        for ($i=1; $i<count($arrayK); $i++) {
                          $sqlSelectObj .= " AND keywords LIKE '%$arrayK[$i]%'";
                        } // end for
                      } // end else
                    } // end if
                    if (($signature = $_POST["signature"]) != ""){
                      if ($sqlSelectObj == $sqlSelectObjControl)
                        $sqlSelectObj .= " signature LIKE '%$signature%'";
                      else
                        $sqlSelectObj .= " AND signature LIKE '%$signature%'";
                    } // end if
                    if (($proc_time = $_POST["proc_time"]) != ""){
                      if ($sqlSelectObj == $sqlSelectObjControl)
                        $sqlSelectObj .= " procTime LIKE '%$proc_time%'";
                      else
                        $sqlSelectObj .= " AND procTime LIKE '%$proc_time%'";
                    } // end if
                    if (($conf_loc = $_POST["conf_loc"]) != ""){
                      if ($sqlSelectObj == $sqlSelectObjControl)
                        $sqlSelectObj .= " confLoc LIKE '%$conf_loc%'";
                      else
                        $sqlSelectObj .= " AND confLoc LIKE '%$conf_loc%'";
                    } // end if
                    if (($supervisor = $_POST["supervisor"]) != ""){
                      if ($sqlSelectObj == $sqlSelectObjControl)
                        $sqlSelectObj .= " supervisor LIKE '%$supervisor%'";
                      else
                        $sqlSelectObj .= " AND supervisor LIKE '%$supervisor%'";
                    } // end if
                    if (($school = $_POST["school"]) != ""){
                      if ($sqlSelectObj == $sqlSelectObjControl)
                        $sqlSelectObj .= " school LIKE '%$school%'";
                      else
                        $sqlSelectObj .= " AND school LIKE '%$school%'";
                    } // end if
                    if (($type = $_POST["type"]) != 'all'){
                      if ($sqlSelectObj == $sqlSelectObjControl)
                        $sqlSelectObj .= " type LIKE '%$type%'";
                      else
                        $sqlSelectObj .= " AND type LIKE '%$type%'";
                    } // end if
                    if (($classification = $_POST["classification"]) != 'all'){
                      if ($sqlSelectObj == $sqlSelectObjControl)
                        $sqlSelectObj .= " classification LIKE '%$classification%'";
                      else
                        $sqlSelectObj .= " AND classification LIKE '%$classification%'";
                    } // end if

                    // check whether there are search words defined
                    if ($sqlSelectObj == $sqlSelectObjControl) {
                      $noSearch = 1;
                      echo "<br><br><strong>No search words defined!</strong>";
                    } // end if
                    else {
                      // order results by title
                      $sqlSelectObj .= " ORDER BY title;";
                    } // end else

                    // the new search string and the search values are saved in session variables
                    $_SESSION["expert_search_string"] = $sqlSelectObj;
                    $_SESSION["author"] = $author;
                    $_SESSION["title"] = $title;
                    $_SESSION["subtitle"] = $subtitle;
                    $_SESSION["year"] = $year;
                    $_SESSION["publisher"] = $publisher;
                    $_SESSION["location"] = $location;
                    $_SESSION["isbn"] = $isbn;
                    $_SESSION["keywords"] = $keywords;
                    $_SESSION["comment"] = $comment;
                    $_SESSION["signature"] = $signature;
                    $_SESSION["proc_time"] = $proc_time;
                    $_SESSION["conf_loc"] = $conf_loc;
                    $_SESSION["supervisor"] = $supervisor;
                    $_SESSION["school"] = $school;
                    $_SESSION["type"] = $type;
                    $_SESSION["classification"] = $classification;
                  } // end else

                  if (!$noSearch) {
                    // check if the year and the proceeding time are given in in the right format
                    if (($year != "") && (strlen($year) != 4)){
                      header("Location: expert_search.php?error=1");
                      exit;
                    } // end if
                    if (($proc_time != "") && (strlen($proc_time) != 4) && (strlen($proc_time) != 7) && (strlen($proc_time) != 10)){
                      header("Location: expert_search.php?error=2");
                      exit;
                    } // end if

                    // start database connection for the default user, with error handling
                    $db = mysql_connect("localhost", "libraryDefault", "default");
                    if (!mysql_select_db ("stilibrary", $db)){
                      die ("Connection to database failed - default user");
                    } // end if

                    // send query to the database
                    $res = mysql_db_query("stilibrary", $sqlSelectObj);
                    if (mysql_errno() != 0) {
                      // logging function call
                      $string = "Error: sqlSelectObj: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlSelectObj. "\n";
                      library_log($string);
                      echo ("Database error! - Please see log file for detailed information.<br><br>");
                    } // end if

                    // get the number of results
                    $num = mysql_num_rows($res);
                    if ($num > 0) {
                      echo "<table cellspacing='0' cellpadding='5'>";
                      echo "<tr>";
                      echo "<td> <h3>title</h3> </td>";
                      echo "<td> <h3>author</h3> </td>";
                      echo "<td> <h3>year</h3> </td>";
                      echo "<td> <h3>signature</h3> </td>";
                      echo "<td> <h3>status</h3></td>";
                      echo "<td> <h3>borrowed by</h3> </td>";
                      echo "<td> <h3>return date</h3> </td>";
                      echo "</tr>";
                      $color=1;     // variable to indicate how to style a row
                      for ($i=0; $i<$num; $i++)
                      {
                        // extract results
                        $pid = mysql_result($res, $i, "pid");
                        $author = mysql_result($res, $i, "author");
                        if ($author == 'NULL')
                          $author = '';
                        $title = mysql_result($res, $i, "title");
                        $year = mysql_result($res, $i, "year");
                        if (($year == 'NULL') || ($year == '0000'))
                          $year = '';
                        $signature = mysql_result($res, $i, "signature");
                        $status = mysql_result($res, $i, "status");

                        // build sql select borrowing string
                        $sqlSelectOrdBor = "SELECT returnDate, user FROM borrowing WHERE publication = '$pid';";

                        // send query to database
                        $res2 = mysql_db_query("stilibrary", $sqlSelectOrdBor);
                        if (mysql_errno() != 0) {
                          // logging function call
                          $string = "Error: sqlSelectOrdBor: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlSelectOrdBor . "\n";
                          library_log($string);
                          echo ("Database error! - Please see log file for detailed information.<br><br>");
                        } // end if

                        // check if and how many results there are
                        $num2 = mysql_num_rows($res2);
                        if ($num2 > 0) {
                          // extract results from borrowing
                          if ($borrowDate == "NULL" || $borrowDate == "0000-00-00")
                            $borrowDate="";
                          $returnDate = mysql_result($res2, 0, "returnDate");
                          if ($returnDate == "NULL" || $returnDate == "0000-00-00")
                            $returnDate="";
                          $user = mysql_result($res2, 0, "user");
                          if ($user == "NULL")
                            $user="";
                          // the username of the user wo borrowed the object is also needed
                          if ($user != ""){
                            // build sql select user string
                            $sqlSelectUser = "SELECT username FROM user WHERE uid = '$user'";

                            // send query to database
                            $res3 = mysql_db_query("stilibrary", $sqlSelectUser);
                            if (mysql_errno() != 0) {
                              // logging function call
                              $string = "Error: sqlSelectUser: " . mysql_errno() . ": " . mysql_error(). "\n" . $sqlSelectUser . "\n";
                              library_log($string);
                              echo ("Database error! - Please see log file for detailed information.<br><br>");
                            } // end if

                            // extract result from user
                            $username = mysql_result($res3, 0, "username");
                          } // end if
                        } // end if
                        else{
                          $username="";
                          $returnDate="";
                        } // end else

                        // begin row and indicate color (class row)
                        if ($color) {
                          echo "<tr class='row'>";
                          $color=0;
                        } // end if
                        else {
                          echo "<tr>";
                          $color=1;
                        } // end else
                        echo "<td> <a href='expert_obj_detail.php?pid=$pid'> $title </a> </td>";
                        echo "<td> $author </td>";
                        echo "<td> $year </td>";
                        echo "<td> <a href='expert_obj_detail.php?pid=$pid'> $signature </a ></td>";
                        echo "<td> $status </td>";
                        echo "<td> $username </td>";
                        echo "<td> $returnDate </td>";
                        echo "</tr>";
                      } // end for
                      echo "<tr><td></td></tr><tr><td></td></tr><tr><td>";
                      echo "<form action='expert_search.php' method='GET'>";
                      echo "<input type='submit' name='get_back' value='Back to this expert search'>";
                      echo "</form></td></tr></table>";
                    } // end if
                    else {
                      echo "<strong>No objects found</strong><br><br><br>";
                      echo "<table cellspacing='5'><tr><td>";
                      echo "<form action='expert_search.php' method='GET'>";
                      echo "<input type='submit' name='get_back' value='Back to this expert search'>";
                      echo "</form></td></tr></table>";
                    } // end else

                    // close database connection
                    mysql_close($db);
                  } // end if !noSearch
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

