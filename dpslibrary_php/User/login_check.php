<?php
  // start session
  session_start ();

  include ("../library_functions.inc");

  // start database connection for the default user, with error handling
  $db = mysql_connect("localhost", "libraryDefault", "default");
  if (!mysql_select_db ("stilibrary", $db)){
    die ("Connection to database failed - user: libraryDefault");
  } // end if

  // extract username and password via POST from the login form
  $user_name = "";
  $password = "";
  if (isset($_POST["username"]))
    $user_name = $_POST["username"];
  if (isset($_POST["password"]))
    $password = $_POST["password"];

  // check if the password contains a single quote " ' "
  if(strpos($password, "'") != 0) {
    $password = str_replace("'","\'", $password);
  }

  // build sql select user string
  $sqlSelectUser = "SELECT uid, firstName, lastName, superuser FROM user WHERE username = '$user_name' AND password = md5('$password');";

  // send query to the database
  $res = mysql_db_query("stilibrary", $sqlSelectUser);
  if (mysql_errno() != 0) {
    // logging function call
    $string = "Error: sqlSelectUser: " . mysql_errno() . ": " . mysql_error(). "\n";
    library_log($string);
    echo ("Database error! - Please see log file for detailed information.<br><br>");
  } // end if

  // get number of results
  $num = mysql_num_rows($res);
  if ($num > 0){
    // logging function call
    $string = "User " . $user_name . " logged in.\n";
    library_log($string);

    // extract results and write them into session variables
    $_SESSION["user_id"] = mysql_result($res, 0, "uid");
    $_SESSION["user_firstName"] = mysql_result($res, 0, "firstName");
    $_SESSION["user_lastName"] = mysql_result($res, 0, "lastName");
    $_SESSION["user_username"] = $user_name;
    $_SESSION["user_superuser"] = mysql_result($res, 0, "superuser");

    // close database connection
    mysql_close($db);

    // check if there is a special page to return to
    $act_page = "";
    if (isset($_SESSION["act_page"]))
      $act_page = $_SESSION["act_page"];
    //if (substr_count($act_page, "detail") == 1) {
    if ($act_page == "borrow") {
      header ("Location: borrow_obj.php");
      exit;
    } // end if
    if ($act_page == "return_list") {
      header ("Location: return_obj_list.php");
      exit;
    } // end if
    if ($act_page == "passw"){
      header ("Location: change_passw.php");
      exit;
    } // end if
    if ($act_page == "priv_func_overview"){
      header ("Location: ../PrivUser/priv_func_overview.php");
      exit;
    } // end if
    if ($act_page == "help_priv_functions") {
      header ("Location: ../Help/priv_functions_help.php");
      exit;
    } // end if

    else {
      header ("Location: sti_library.php");
      exit;
    } // end else
  } // end if

  // if the password or username are wrong
  else  {
    // close database connection
    mysql_close($db);

    header("Location: login.php?error=1");
    exit;
  } // end else
?>

