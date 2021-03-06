<!-- This is the main page for the Admin page -->
<?php 
session_start();
require("UserAuthenticator.php");
if(!$UserAuthenticator->isLoggedin())
{
    $UserAuthenticator->redirectToLogin();
}
    require("../Query.php"); // some of the queries are done on this page
    $user = "root";
    $pass = "";
    $dbh = new PDO('mysql:host=localhost;dbname=capstone', $user,$pass);
    $userquery = "SELECT * FROM capstone.registration WHERE user_delete = 0;";
    $userquery = $dbh->prepare($userquery);
    $userquery->execute();
    $userdeletequery = "SELECT * FROM capstone.registration WHERE user_delete = 1;";
    $userdeletequery = $dbh->prepare($userdeletequery);
    $userdeletequery->execute();
    $itemquery = "SELECT * FROM capstone.iteminformation WHERE item_delete = 0;";
    $itemquery = $dbh->prepare($itemquery);
    $itemquery->execute();
    $deleteditemquery = "SELECT * FROM capstone.iteminformation WHERE item_delete = 1;";
    $deleteditemquery = $dbh->prepare($deleteditemquery);
    $deleteditemquery->execute();
    $adminquery = "SELECT * FROM capstone.admin_users";
    $adminquery = $dbh->prepare($adminquery);
    $adminquery->execute();
?>
<!DOCTYPE html>
<html>
<title>Admin</title>
    <?php require("../links.html");?> 
    <script type="text/javascript" src = "datatable.js"></script>
  </head>
  <body class="pagecolor">
    <div class="menu-wrap">
        <nav class="menu">
            <ul class="clearfix">
                <li><a href="logout.php">logout</a></li>
            </ul>
        </nav>
    </div>
		<div class = "textboxes">
            <h1>Admin Page</h1>
        </div>
        <div id = "dialoguser" title="Basic dialog" style="display:none">
            <div class = "Popup">
                <h3>First Name:</h3> <input type="text" name="fname" id = "firstname"><br>
                <h3>Last Name:</h3> <input type="text" name="lname" id = "lastname"><br>
                <h3>Email: </h3> <input type="text" name="email" id = "email"><br>
                <h3>Phone:</h3> <input type="text" name="phone" id = "phone"><br>
                <h3>Paid for items bought: </h3>
                    <select id = "itemsbought">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                <h3>Paid for items sold: </h3>
                    <select id = "itemssold">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
            </div>
        </div>
        <div id = "dialogitems" title="Basic dialog" style="display:none">
            <div class = "Popup">
                <h3>Seller Name: </h3> 
                <select name="namedropdown" class = "adminnamedropdown" id = "sellernamedropdown"> 
                    <option name = "DropDown" value = "0">Select Name:</option>
                        <?php
                            $stmt = $queryclass->getnamequery();
                            while($row = $stmt->fetch()):; ?>
                                <option name = "DropDown" value="<?php echo $row[0]?>"><?php echo $row[1] . " " . $row[2];?></option>
                    <?php endwhile;?>
                </select><br>
                <h3>Name of buyer:</h3>
                <select name="namedropdown" class = "adminnamedropdown" id ="buyernamedropdown">
                    <option name = "DropDown" value = "0">Select Name:</option>
                        <?php
                            $stmt = $queryclass->getnamequery();
                            while($row = $stmt->fetch()):; ?>
                                <option name = "DropDown" value="<?php echo $row[0]?>"><?php echo $row[1] . " " . $row[2];?></option>
                        <?php endwhile;?>
                    </select><br>
                <h3>Description: </h3> <textarea rows="3" cols="30" name="Description" id = "itemdesc"></textarea><br>
                <h3>Item Condition:</h3> <input type="text" name="phone" id = "itemcondition"><br>
                <h3>Seller Notes: </h3> <textarea rows="3" cols="30" name="lname" id = "sellernotes"></textarea><br>
                <h3>Starting Bid: </h3> <input type="number" name="lname" id = "startingbid"><br>
                <h3>Selling Price: </h3> <input type="number" name="lname" id = "sellingprice"><br>
                <h3>Charity: </h3>
                        <select id = "charity">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
            </div>
        </div>
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Users</a></li>
                <li><a href="#tabs-2">Items</a></li>
                <li><a href="#tabs-3">Database</a></li>
                <li><a href="#tabs-4">Deleted Users</a></li>
                <li><a href="#tabs-5">Deleted Items</a></li>
                <li><a href="#tabs-6">Admin Users</a></li>
                <li><a href="#tabs-7">Label Printer</a></li>
            </ul>
  <div id="tabs-1">
    <table class = "myTable" id = "usertable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Paid for items bought</th>
                    <th>Paid for items sold</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                while($row = $userquery->fetch()):
                    if($row[6] == TRUE)
                        $paidforbought = "Yes";
                    else
                        $paidforbought = "No";
                    if($row[7] == TRUE)
                        $paidforsold = "Yes";
                    else
                        $paidforsold = "No";
            ?>
            <tr id ="<?php echo $row[0]?>"><td><?php echo $row[0] ?></td><td><?php echo $row[1] ?></td><td><?php echo $row[2] ?></td><td><?php echo $row[3] ?></td><td><?php echo $row[4] ?></td><td><?php echo $paidforbought ?></td><td><?php echo $paidforsold ?></td></tr>
            <?php endwhile?>
            </tbody>
    </table> 
  </div>
        <div id="tabs-2">
        <table class = "myTable" id = "itemtable">
            <thead>
                <tr>
                    <th>Item Number</th>
                    <th>Name of seller</th>
                    <th>Name of buyer</th>
                    <th>Description</th>
                    <th>Item Condition</th>
                    <th>Seller Notes</th>
                    <th>Opening Bid</th>
                    <th>Selling Price</th>
                    <th>Charity</th> 
                </tr>
            </thead>
                <?php 
                while($row = $itemquery->fetch()):
                    $sellerNameQuery = "SELECT `FirstName`,`LastName` FROM `registration` where `Seller ID` = :ID";
                    $statement = $dbh->prepare($sellerNameQuery);
                    $statement->bindparam(':ID',$row[1]);
                    $statement->execute();
                    $sellernamerow = $statement->fetch();

                    $buyerNameQuery = "SELECT `FirstName`,`LastName` FROM `registration` where `Seller ID` = :ID";
                    $statement = $dbh->prepare($buyerNameQuery);
                    $statement->bindparam(':ID',$row[2]);
                    $statement->execute();
                    $buyernamerow = $statement->fetch();
                    if($row[8] == TRUE)
                        $charity = "Yes";
                    else
                        $charity = "No";
                ?>
                <tr><td><?php echo $row[0] ?></td><td><?php echo $sellernamerow[0] . " " . $sellernamerow[1] ?></td><td><?php echo $buyernamerow[0] . " " . $buyernamerow[1] ?></td><td><?php echo $row[3] ?></td><td><?php echo $row[4] ?></td><td><?php echo $row[5] ?></td><td><?php echo "$ " . $row[6] ?></td><td><?php echo "$ " . $row[7] ?></td><td><?php echo $charity ?></td></tr>
            <?php endwhile?>
        </table> 
        </div>
        <div id="tabs-3">
                    <h3>This button will delete all data from the database</h3>
                    <input type="button" value = "Delete Tables" id="delete_tables_button"></input>
        </div>
        <div id = "delete_table_div" style = "Display:none"> 
        <h3>You are about to delete all of the database information. Are you sure you want to?</h3>
        </div>
        <div id="tabs-4">
        <table class = "myTable" id = "userdeletetable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Paid for items bought</th>
                    <th>Paid for items sold</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                while($row = $userdeletequery->fetch()):
                    if($row[6] == TRUE)
                        $paidforbought = "Yes";
                    else
                        $paidforbought = "No";
                    if($row[7] == TRUE)
                        $paidforsold = "Yes";
                    else
                        $paidforsold = "No";
            ?>
            <tr id ="<?php echo $row[0]?>"><td><?php echo $row[0] ?></td><td><?php echo $row[1] ?></td><td><?php echo $row[2] ?></td><td><?php echo $row[3] ?></td><td><?php echo $row[4] ?></td><td><?php echo $paidforbought ?></td><td><?php echo $paidforsold ?></td></tr>
            <?php endwhile?>
            </tbody>
        </table>          
        </div>
        <div id = "undeleteuser" style = "display:none">
         <h3>Would you like to add this user back?</h3>
        </div>
        <div id="tabs-5">
        <table class = "myTable" id = "itemdeletetable">
            <thead>
                <tr>
                    <th>Item Number</th>
                    <th>Name of seller</th>
                    <th>Name of buyer</th>
                    <th>Description</th>
                    <th>Item Condition</th>
                    <th>Seller Notes</th>
                    <th>Opening Bid</th>
                    <th>Selling Price</th>
                    <th>Charity</th> 
                </tr>
            </thead>
                <?php 
                while($row = $deleteditemquery->fetch()):
                    $sellerNameQuery = "SELECT `FirstName`,`LastName` FROM `registration` where `Seller ID` = :ID";
                    $statement = $dbh->prepare($sellerNameQuery);
                    $statement->bindparam(':ID',$row[1]);
                    $statement->execute();
                    $sellernamerow = $statement->fetch();

                    $buyerNameQuery = "SELECT `FirstName`,`LastName` FROM `registration` where `Seller ID` = :ID";
                    $statement = $dbh->prepare($buyerNameQuery);
                    $statement->bindparam(':ID',$row[2]);
                    $statement->execute();
                    $buyernamerow = $statement->fetch();
                    if($row[8] == TRUE)
                        $charity = "Yes";
                    else
                        $charity = "No";
                ?>
                <tr><td><?php echo $row[0] ?></td><td><?php echo $sellernamerow[0] . " " . $sellernamerow[1] ?></td><td><?php echo $buyernamerow[0] . " " . $buyernamerow[1] ?></td><td><?php echo $row[3] ?></td><td><?php echo $row[4] ?></td><td><?php echo $row[5] ?></td><td><?php echo "$ " . $row[6] ?></td><td><?php echo "$ " . $row[7] ?></td><td><?php echo $charity ?></td></tr>
            <?php endwhile?>
        </table>        
        </div>
        <div id = "undeleteitem" style = "display:none">
        <h3>Would you like to add this item back?</h3>
        </div>
        <div id="tabs-6">
            <div id = "admin_wrap">
                <div id = "new_admin_user">
                    <h3>Create a new admin user</h3>
                    <input type="text" name = "username" Placeholder = "Username:" id = "admin_username"><br>
                    <input type="password" name = "password" Placeholder = "Password:" id = "admin_password"><br>
                    <input type="password" name = "password" Placeholder = "Confirm Password:" id = "admin_password_confirm"><br>
                    <input type = "button" name = "backtomain" value = "Add User" id = "add_admin_user_button"></input>
                </div>
                <div id = "admin_user_table_div">
                        <table class = "myTable" id = "admin_user_table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while($adminuser = $adminquery->fetch()): 
                                ?>
                                    <tr id = "<?php echo $adminuser[0]?>"><td><?php echo $adminuser[0] ?></td><td><?php echo $adminuser[1]?></td></tr> 
                                <?php
                                endwhile
                                ?>
                            </tbody>
                        </table>
                </div>
            </div>
            <div id = "delete_admin" style = "display:none">
                <h2> Would you like to delete this admin user?</h2>
            </div>
        </div>
        <div id="tabs-7">
            <h3>Label Printer IP</h3>
            <input type="text" id = "label_ip"><br>
            <input type = "button"  value = "Update IP address" id = "update_label_printer_button"></input>
        </div>
        </div>
 </body>
</html>
