<!DOCTYPE html>  
 <html>  
      <head>  
           <title>Data Table</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
      </head>  
      <style>
/*the container must be positioned relative:*/
.custom-select {
  position: relative;
  font-family: Arial;
}

.custom-select select {
  display: none; /*hide original SELECT element:*/
}

.select-selected {
  background-color: DodgerBlue;
}

/*style the arrow inside the select element:*/
.select-selected:after {
  position: absolute;
  content: "";
  top: 14px;
  right: 10px;
  width: 0;
  height: 0;
  border: 6px solid transparent;
  border-color: #fff transparent transparent transparent;
}

/*point the arrow upwards when the select box is open (active):*/
.select-selected.select-arrow-active:after {
  border-color: transparent transparent #fff transparent;
  top: 7px;
}

/*style the items (options), including the selected item:*/
.select-items div,.select-selected {
  color: #ffffff;
  padding: 8px 16px;
  border: 1px solid transparent;
  border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent;
  cursor: pointer;
  user-select: none;
}

/*style items (options):*/
.select-items {
  position: absolute;
  background-color: DodgerBlue;
  top: 100%;
  left: 0;
  right: 0;
  z-index: 99;
}

/*hide the items when the select box is closed:*/
.select-hide {
  display: none;
}

.select-items div:hover, .same-as-selected {
  background-color: rgba(0, 0, 0, 0.1);
}
</style>
      <body>  

      <br />  
           <div class="container" style="">  
                <h1 align="center">Data Of Orders</h1><br />    
                <form method="extract" action="export.php" align="center">  
                     <input type="submit" name="export" value="Extract Data" class="btn btn-success" />  
                </form>     
                <br>   
                <form action  method="GET">
                     <input type="text" name="ordersearch" style="height:35px" placeholder="Search By orderid" > OR
                     <input type="text" name="usersearch" style="height:35px" placeholder="Search By Firstname" >
                     <input type="submit" value="Submit"  class="btn btn-success">
</form>
                <br>    
                <form method="POST"  action="hayssam.php">
         
&nbsp;&nbsp; <input style="float:right" type="submit" name="submit" value="GO"  class="btn btn-success"/> 
       <select class="custom-select" style="float:right;width:100px;height:35px;margin-right:10px" name="select1" id="select1">
<option value="all">All Orders</option>
  <option value="5">5</option>
  <option value="10">10</option>
  <option value="14">15</option>
</select> &nbsp;
</form>
 <?php
if(isset($_POST['submit'])){
      $selectOption = $_POST['select1'];
      echo $selectOption;
}


?> 
<br><br>

                <div class="table-responsive">  
                     <table class="table table-bordered">  
                          <tr>  
                               <th>orderID</th>  
                               <th>orderDate</th>  
                               <th>orderItemID</th>  
                               <th>orderItemName</th>  
                               <th>orderitemQuantity</th>  
                               <th>orderItemPrice</th>  
                               <th>customerFirstName</th>  
                               <th>customerLastName</th>  
                               <th>customerAddress</th>  
                               <th>customerCity</th>  
                               <th>customerZipCode</th>  
                               <th>customerEmail</th>  
                          </tr>  
<?php

    $items = file_get_contents("items.json");
    $items = json_decode($items,true);

    $orders = file_get_contents("orders.json"); //orderid->iteam (name,price,quantity)  ->user(data,)
    $orders = json_decode($orders,true);

    $customer = file_get_contents("customer.json");
    $customer = json_decode($customer,true);
    // echo'<pre>';
    // print_r($data);
    // echo'</pre>';
    if (isset($_GET['ordersearch'])&&$_GET['ordersearch']!=""){
     
     foreach($orders as $row){
          $orderid = $row['id'];
          $customerIdfromorder = $row['customerId'];
          $dateoforder = $row['createdAt'];
          if($orderid == $_GET['ordersearch']){
               foreach($items as $row1){
                    $orderidinitems = $row1['orderId'];
                    if($orderid ==$orderidinitems){
                         $itemid = $row1['id'];
                         $itemname = $row1['name'];
                         $itemquantity = $row1['quantity'];
                         $itemprice = $row1['basePrice'];
           
                         foreach($customer as $row2){
                              if($customerIdfromorder==$row2['id']){
                                   $firstName = $row2['firstName'];
                                   $lastName = $row2['lastName'];
                                   $email = $row2['email'];
                                   
                                   $address = $row2['addresses'][1]['address'];
                                       $city = $row2['addresses'][1]['city'];
                                   $zip = $row2['addresses'][1]['zip'];
                                   echo '<tr><td>'.$orderid.'</td>
                             <td>'.$dateoforder.'</td>
                             <td>'.$itemid.'</td>
                             <td>'.$itemname.'</td>
                             <td>'.$itemquantity.'</td>
                             <td>'.$itemprice.'</td>
                             <td>'.$firstName.'</td>
                             <td>'.$lastName.'</td>
                             <td>'.$address.'</td>
                             <td>'.$city.'</td>
                             <td>'.$zip.'</td>
                             <td>'.$email.'</td> </tr>';
                             break;
                              }
                              
                         }
                    }
              
                   }
           
          }


}
    }
else if(isset($_GET['usersearch'])&&$_GET['usersearch']!=""){
     foreach($orders as $row){
          $orderid = $row['id'];
          $customerIdfromorder = $row['customerId'];
          $dateoforder = $row['createdAt'];
          
 
       foreach($items as $row1){
          $orderidinitems = $row1['orderId'];
          if($orderid ==$orderidinitems){
               $itemid = $row1['id'];
               $itemname = $row1['name'];
               $itemquantity = $row1['quantity'];
               $itemprice = $row1['basePrice'];
 
               foreach($customer as $row2){
                    if($customerIdfromorder==$row2['id']){
                         $firstName = $row2['firstName'];
                         $lastName = $row2['lastName'];
                         $email = $row2['email'];
                         if($firstName == $_GET['usersearch']){
                         $address = $row2['addresses'][1]['address'];
                             $city = $row2['addresses'][1]['city'];
                         $zip = $row2['addresses'][1]['zip'];
                         echo '<tr><td>'.$orderid.'</td>
                   <td>'.$dateoforder.'</td>
                   <td>'.$itemid.'</td>
                   <td>'.$itemname.'</td>
                   <td>'.$itemquantity.'</td>
                   <td>'.$itemprice.'</td>
                   <td>'.$firstName.'</td>
                   <td>'.$lastName.'</td>
                   <td>'.$address.'</td>
                   <td>'.$city.'</td>
                   <td>'.$zip.'</td>
                   <td>'.$email.'</td> </tr>';
                   break;
                    }}
                    
               }
          }
    
         }
 
     }

}
else {
   
    foreach($orders as $row){
         $orderid = $row['id'];
         $customerIdfromorder = $row['customerId'];
         $dateoforder = $row['createdAt'];
         // Slice it, getting the first 10 elements



      foreach($items as $row1){
         $orderidinitems = $row1['orderId'];
     
         if($orderid ==$orderidinitems){
              $itemid = $row1['id'];
              $itemname = $row1['name'];
              $itemquantity = $row1['quantity'];
              $itemprice = $row1['basePrice'];

              foreach($customer as $row2){
                   if($customerIdfromorder==$row2['id']){
                        
                        $firstName = $row2['firstName'];
                        $lastName = $row2['lastName'];
                        $email = $row2['email'];
                        
                        $address = $row2['addresses'][1]['address'];
                            $city = $row2['addresses'][1]['city'];
                        $zip = $row2['addresses'][1]['zip'];
                        
                              echo '<tr><td>'.$orderid.'</td>
                  <td>'.$dateoforder.'</td>
                  <td>'.$itemid.'</td>
                  <td>'.$itemname.'</td>
                  <td>'.$itemquantity.'</td>
                  <td>'.$itemprice.'</td>
                  <td>'.$firstName.'</td>
                  <td>'.$lastName.'</td>
                  <td>'.$address.'</td>
                  <td>'.$city.'</td>
                  <td>'.$zip.'</td>
                  <td>'.$email.'</td> </tr>';
                
                  break;
                   
                   
              
         }
     }
        }

    }
}}  
?>

  </table>
  

                </div>  
           </div>  
           <br />  
      </body>  
 </html>  