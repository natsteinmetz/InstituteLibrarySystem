<?php
  // start session
  session_start ();

  // set actual page session variable
  $_SESSION["act_page"] = "priv_add_user";

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

      <span class="crumbTrail"><a class="crumbTrail" href="../User/sti_library.php">STI-Innsbruck Library</a> &gt; <a class="crumbTrail" href="priv_func_overview.php">Privileged functions</a> &gt; <a class="crumbTrail" href="add_user.php">Add new user</a></span>

  <?php
    // including vertical menue
    include("menue2.inc");
  ?>

          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td>

                <h2>Add new user</h2><br>

                <?php

                  // check if an error variable is set
                  $error=0;
                  if (isset ($_GET["error"]))
                    $error = $_GET["error"];

                  // if an error is set, the form shows the values saved in session variables
                  if ($error != 0) {
                    if ($error == 1)
                      echo "<strong>This username is already in use. Please choose another one!</strong><br><br>";
                    if ($error == 2)
                      echo "<strong>All fields are required!</strong><br><br>";
                    if ($error == 3)
                      echo "<strong>There exists already a user with this email address!</strong><br><br>";
                    if ($error == 4)
                      echo "<strong>The username is too long (max. 16 letters). Please choose another one!</strong><br><br>";

                    echo "<table cellpadding='0' cellspacing='5' border='0' width='70%'>";
                    echo "<form action = 'add_user_conf.php' method = 'post'>";
                    echo "<tr> <td> <div align='left'>first name</div> </td>";
                    echo "<td> <input type='text' name='firstName' value= '".$_SESSION["firstName"]."' size='30' maxlength='50'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>last name</div> </td>";
                    echo "<td> <input type='text' name='lastName' value= '".$_SESSION["lastName"]."' size='30' maxlength='50'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>username<span style='color: #9F9F9F'> (unique)</span></div> </td>";
                    echo "<td> <input type='text' name='username' value= '".$_SESSION["username"]."' size='30' maxlength='50'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>password</div> </td>";
                    echo "<td> <input type='password' name='password' value= '".$_SESSION["password"]."' size='30' maxlength='50'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>email<span style='color: #9F9F9F'> (unique)</span></div> </td>";
                    echo "<td> <input type='text' name ='email' value= '".$_SESSION["email"]."' size ='30' maxlength ='50'> </td> </tr>";
                    if ($_SESSION["reminder"] == 'yes'){
                      echo "<tr> <td> <div align='left'>reminder</div> </td>";
                      echo "<td> <input type='radio' name='reminder' value='yes' checked='checked'> Yes &#160;&#160;&#160;&#160;<input type='radio' name='reminder' value='no'> No </td> </tr>";
                    } // end if
                    else {
                      echo "<tr> <td> <div align='left'>reminder</div> </td>";
                      echo "<td> <input type='radio' name='reminder' value='yes'> Yes &#160;&#160;&#160;&#160;<input type='radio' name='reminder' value='no' checked='checked'> No </td> </tr>";
                    } // end else
                    if ($_SESSION["superuser"] == 'yes'){
                      echo "<tr> <td> <div align='left'>superuser</div> </td>";
                      echo "<td> <input type='radio' name='superuser' value='yes' checked='checked'> Yes &#160;&#160;&#160;&#160;<input type='radio' name='superuser' value='no'> No </td> </tr>";
                    } // end if
                    else {
                      echo "<tr> <td> <div align='left'>superuser</div> </td>";
                      echo "<td> <input type='radio' name='superuser' value='yes'> Yes &#160;&#160;&#160;&#160;<input type='radio' name='superuser' value='no' checked='checked'> No </td> </tr>";
                    } // end else
                    echo "<tr></tr><tr></tr><tr></tr>";

                    echo "<tr> <td> <input type='submit' value='  Add user  '> </td>";
                    echo "<td> <input type='reset' value='  Reset to initial value  '> </td> </tr>";
                    echo "</form></table>";
                  } // end if

                  // if no error variable is set, the form is still empty
                  else {
                    echo "<table cellpadding='0' cellspacing='5' border='0' width='70%'>";
                    echo "<form action = 'add_user_conf.php' method = 'post'>";
                    echo "<tr> <td> <div align='left'>first name</div> </td>";
                    echo "<td> <input type='text' name='firstName' value='' size='30' maxlength='50'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>last name</div> </td>";
                    echo "<td> <input type='text' name='lastName' value='' size='30' maxlength='50'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>username<span style='color: #9F9F9F'> (unique)</span></div> </td>";
                    echo "<td> <input type='text' name='username' value='' size='30' maxlength='50'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>password</div> </td>";
                    echo "<td> <input type='password' name='password' value='' size='30' maxlength='50'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>email<span style='color: #9F9F9F'> (unique)</span></div> </td>";
                    echo "<td> <input type='text' name ='email' value='' size ='30' maxlength ='50'> </td> </tr>";
                    echo "<tr> <td> <div align='left'>reminder</div> </td>";
                    echo "<td> <input type='radio' name='reminder' value='yes' checked='checked'> Yes &#160;&#160;&#160;&#160;<input type='radio' name='reminder' value='no'> No </td> </tr>";
                    echo "<tr> <td> <div align='left'>superuser</div> </td>";
                    echo "<td> <input type='radio' name='superuser' value='yes'> Yes &#160;&#160;&#160;&#160;<input type='radio' name='superuser' value='no' checked='checked'> No </td> </tr>";
                    echo "<tr></tr><tr></tr><tr></tr>";

                    echo "<tr> <td> <input type='submit' value='  Add user  '> </td>";
                    echo "<td> <input type='reset' value='  Reset form  '> </td> </tr>";
                    echo "</form></table>";
                  } // end else

                  // delete session variables;
                  unset($_SESSION["firstName"]);
                  unset($_SESSION["lastName"]);
                  unset($_SESSION["username"]);
                  unset($_SESSION["password"]);
                  unset($_SESSION["email"]);
                  unset($_SESSION["reminder"]);
                  unset($_SESSION["superuser"]);
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

