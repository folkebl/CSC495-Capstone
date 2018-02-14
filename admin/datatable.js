// This is the java script page for the admin page
//
$(document).ready(function(){
  var usertable = $('#usertable').DataTable();
  var itemtable = $('#itemtable').DataTable();
    $( "#tabs" ).tabs();
    $('#usertable tbody').on( 'click', 'tr', function(event){var data1 = usertable.row(this).data(); usertablerowclick(data1)});  // detects click on user table and passes the row data
    $('#itemtable tbody').on( 'click', 'tr', function(event){var data2 = itemtable.row(this).data(); itemtablerowclick(data2)});  // detects click on item table and passes the row data
});
//This gets the all of the data from the table and then creates a dialog with the data
function usertablerowclick(data1)
{
    var holddata;
    var table = $('#usertable').DataTable();
    $('#firstname').val(data1[1]);
    $('#lastname').val(data1[2]);
    $('#email').val(data1[3]);
    $('#phone').val(data1[4]);
    if(data1[5] == "No")
      holddata = "0";
    else 
      holddata = "1";
    $('#itemsbought').val(holddata);
    if(data1[6] == "No")
      holddata = "0";
    else 
      holddata = "1";
    $('#itemssold').val(holddata);

    console.log(data1);
    $( "#dialoguser" ).dialog({
        title: "User Admin",
        dialogClass: "no-close",
        draggable: false,
        height: 700,
        width: 500,
        resizable: false,
        modal: true,
        buttons: [
          {
            text: "Reprint Tag",
            click: function() {
              var id = data1[0];
              // this is the ajax request to reprint a user tag
              $.ajax({
                url:'zebraregisterajax.php',
                method:'POST',
                data: {id:id},
                dataType: "html",
                success: function(data){
                    console.log(data);
                                   }
            });
              $( this ).dialog("close");
            }
          },
          {
            text: "Update",
            click: function() {
               var fname = $('#firstname').val();
               var lname = $('#lastname').val();
               var email = $('#email').val();
               var phone = $('#phone').val();
               var itemsbought = $('#itemsbought').val();
               var itemssold = $('#itemssold').val();
               var id = data1[0];
              // ajax request to update all of the user information
              $.ajax({
                url:'Adminuserajax.php',
                method:'POST',
                data: {fname:fname, lname:lname, email:email, phone:phone, id:id, itemsbought:itemsbought, itemssold:itemssold },
                dataType: "html",
                success: function(event){
                    location.reload();
                                   }
            });
            }
            
          },
          {
            text: "Close",
            click: function() {
              $( this ).dialog("close");
            }
          }
        ]
      });
}
// this is called when a table row is clicked on
function itemtablerowclick(data2)
{
   // var table = $('#itemtable').DataTable();
    var sellerid = data2[0];
    $.ajax({
      url:'sellernameajax.php',
      method:'POST',
      data: {sellerid},
      dataType: "json",
      success: function(sellid){
          $("#sellernamedropdown").val(sellid); 
          console.log(sellid[0]);
                         }
  });
    console.log(data2);

    var buyerid = data2[0];
    $.ajax({
      url:'buyernameajax.php',
      method:'POST',
      data: {buyerid},
      dataType: "json",
      success: function(bid){
          $("#buyernamedropdown").val(bid); 
          console.log(bid);
                         }
  });
    console.log(data2[3]);
    $('#itemdesc').val(data2[3]);
    $('#itemcondition').val(data2[4]);
    $('#sellernotes').val(data2[5]);
    $('#startingbid').val(data2[6].replace('$ ',''));
    $('#sellingprice').val(data2[7].replace('$ ',''));
    if(data2[8] == "No")
      holddata = "0";
  else 
      holddata = "1";
    $('#charity').val(holddata);
    $( "#dialogitems" ).dialog({
        title: "Item Admin",
        dialogClass: "no-close",
        draggable: false,
        height: 900,
        width: 500,
        resizable: false,
        modal: true,
        buttons: [
          {
            text: "Reprint Tag",
            click: function() {
              var id = data2[0];
              $.ajax({
                url:'zebraitemajax.php',
                method:'POST',
                data: {id:id},
                dataType: "html",
                success: function(data){
                    console.log(data);
                                   }
            });
              $( this ).dialog("close");
            }
          },
          {
            text: "Close",
            click: function() {
              $( this ).dialog("close");
            }
          },
          {
            text: "Update",
            click: function() {
              var itemnum = data2[0];
              var sellernamedropdown = $("#sellernamedropdown").val(); 
              var buyernamedropdown =  $("#buyernamedropdown").val(); 
              var Description = $('#Description').val();
              var itemcondition = $('#itemcondition').val();
              var sellernotes = $('#sellernotes').val();
              var startingbid = $('#startingbid').val();
              var sellingprice = $('#sellingprice').val();
              var charity = $('#charity').val();
              $.ajax({
                url:'Adminitemajax.php',
                method:'POST',
                data: {itemnum:itemnum, sellernamedropdown:sellernamedropdown,
                      buyernamedropdown:buyernamedropdown,
                      Description:Description, itemcondition:itemcondition,
                      sellernotes:sellernotes, startingbid:startingbid, sellingprice:sellingprice, charity:charity },
                dataType: "html",
                success: function(event){
                    location.reload();
                                   }
              });
              $( this ).dialog("close");
            }
          }
        ]
      });
}