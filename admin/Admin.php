<?php 
    require("../Query.php");
    $user = "root";
    $pass = "";
    $dbh = new PDO('mysql:host=localhost;dbname=capstone', $user,$pass);
    $userquery = "SELECT * FROM capstone.registration;";
    $userquery = $dbh->prepare($userquery);
    $userquery->execute();
    $itemquery = "SELECT * FROM capstone.iteminformation;";
    $itemquery = $dbh->prepare($itemquery);
    $itemquery->execute();
?>
<!DOCTYPE html>
<html>
<title>Admin</title>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Arvo"/>
    <link rel="stylesheet" type="text/css" href="../stylesheet.css"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src = "datatable.js"></script>
  </head>
  <body class="pagecolor">
    <div class="menu-wrap">
        <nav class="menu">
            <ul class="clearfix">
                <li><a href="../index.html">Home</a></li>
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
                <h3>Description: </h3> <input type="text" name="email" id = "Description"><br>
                <h3>Item Condition:</h3> <input type="text" name="phone" id = "itemcondition"><br>
                <h3>Seller Notes: </h3> <input type="text" name="lname" id = "sellernotes"><br>
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
                    <th>Starting Bid</th>
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
        </div>
 </body>
</html>