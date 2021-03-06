<?php
    $NameOfUser = $_POST["id"];
    $user = "root";
    $pass = "";
    $dbh = new PDO('mysql:host=localhost;dbname=capstone', $user,$pass);
echo
    "<table>
    <tr>
        <th>Item Number</th>
        <th>Description</th>
        <th>Opening Bid</th>
        <th>Selling Price</th>
        <th>For Charity</th> 
        <th>  Total  </th>
    </tr>";
 //Gets the table data where base on the name selected.
    $querytabledata = "SELECT `ItemNumber`, `sellerNumber`, `BuyerNumber`, `StartingBid`, `SellingPrice`, `Charity`,`Description` FROM `iteminformation` where BuyerNumber = :nameofuser AND item_delete = 0;";
    $tablestatement = $dbh->prepare($querytabledata);
    $tablestatement->bindparam(':nameofuser',$NameOfUser);
    $tablestatement->execute();
//Gets the name of the seller
    $NameQuery = "SELECT `FirstName`,`LastName` FROM `registration` where `Seller ID` = :nameofuser";
    $statement = $dbh->prepare($NameQuery);
    $statement->bindparam(':nameofuser',$NameOfUser);
    $statement->execute();
    $namerowbuyer = $statement->fetch();
    $RunningTotal = 0;
    while($row = $tablestatement->fetch()):
         $RunningTotal += $row[4];
         if($row[5] == true)
            $paid = "Yes"; 
         else
            $paid = "No";
         echo "<tr><td>".$row[0]."</td><td>". $row[6]."</td><td>"."$".$row[3]."</td><td>"."$".$row[4]."</td><td>".$paid."</td><td>"."$".$row[4]."</td></tr>";
        endwhile;   

        echo "<tfoot>
        <tr>
          <th id = \"total\" colspan=\"5\">Total Amount Owed:</th>
          <td>$$RunningTotal</td>
      </tr>
      </tfoot>
  </table>";

  echo "<div class = \"confirmpayment\"><button id = \"payinconfirmbutton\" type=\"button\" name = \"confirmbutton\"> Confirm Payment</button></div>";
?>