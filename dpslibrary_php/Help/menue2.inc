              </td>
              <td align="right" bgcolor="#e6e6e6" height="20" align="left" valign="middle">
                <table border="0">
                  <tr>
                    <?php
                      if ($user_id != 0) {
                        echo "<td><strong>User: </strong>".$_SESSION['user_firstName']. " " .$_SESSION['user_lastName']. "&nbsp;</td></tr></table></td>";
                      } // end if
                      else {
                        echo "<td><strong>User: </strong>Visitor&nbsp;</td></tr></table></td>";
                      } // end else
                    ?>
            </tr>
            <tr> <td colspan="3" height="1" background="../Images/bluepixel.png"> </td> </tr>
          </table>
        </td>

      <!-- row for space -->
      <tr> <td colspan="3">
        <table width="100%" border="0" cellpadding="15" cellspacing="0">
          <tr> <td></td> </tr>
        </table>
      </td> </tr>
    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
      <colgroup>
        <col width="200">
        <col>
      </colgroup>

      <!-- row for verticalmenu and content -->
      <tr>
        <td align="left" valign="top">

          <table border="0">
            <tr> <td> <span class="verticalMenu">
              <a class="verticalMenu" href="../User/search.php">Search</a><br>
              <a class="verticalMenu" href="../User/expert_search.php">Expert search</a><br>
              <a class="verticalMenu" href="../User/return_obj_list.php">Return book</a><br>
              <a class="verticalMenu" href="../User/change_passw.php">Change password</a><br>
              <?php
                if ($user_superuser != 0) {
                  echo "<a class='verticalMenu' href='priv_func_overview.php'><span class='verticalMenu'>Privileged functions</span></a><br>";
                    echo "<table cellpadding=0 cellspacing=0 border=0 class='verticalMenu'>";
                      echo "<tr><td class='verticalMenu'>&nbsp;&nbsp;&nbsp;&nbsp;</td><td class='verticalMenu'>";
                        echo "<a class='verticalMenu' href='../PrivUser/add_obj.php?new=1'>Add new object</a><br>";
                        echo "<a class='verticalMenu' href='../PrivUser/change_obj_search.php'>Change object</a><br>";
                        echo "<a class='verticalMenu' href='../PrivUser/del_obj_search.php'>Delete object</a><br>";
                        echo "<a class='verticalMenu' href='../PrivUser/add_user.php'>Add new user</a><br>";
                        echo "<a class='verticalMenu' href='../PrivUser/change_user_search.php'>Change user</a><br>";
                        echo "<a class='verticalMenu' href='../PrivUser/del_user_search.php'>Delete user</a><br>";
                        echo "<a class='verticalMenu' href='../PrivUser/obj_overview.php'>See object list</a><br>";
                        echo "<a class='verticalMenu' href='../PrivUser/organisation.php'>Organisation</a><br>";
                      echo "</td></tr>";
                    echo "</table>";
                  echo "</span>";
                } // end if
                else {
                  echo "<a class='verticalMenu' href='../PrivUser/priv_func_overview.php'>Privileged functions</a><br>";
                } // end else
              ?>
              <a class="verticalMenu" href="../User/library_policy.php">Library policy</a><br>
              <a class="verticalMenu" href="../Help/help.php">Help</a><br>
            </td> </tr>
          </table>

        </td>
        <td align="left" valign="top">

