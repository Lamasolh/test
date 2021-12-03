<?php  
      
      include "simple_html_dom.php";
       $items = file_get_contents("items.json");
     $items = json_decode($items,true);
 
     $orders = file_get_contents("orders.json"); 
     $orders = json_decode($orders,true);
 
     $customer = file_get_contents("customer.json");
     $customer = json_decode($customer,true);
     $table ='  <table >  
                           <tr>  
                                <th>orderID</th>  
                                <th>orderDate</th>  
                                <th>orderItemID</th>  
                                <th>orderItemName</th>  
                                <th>orderitemQuantity</th>  
                                <th>orderItemPrice</th>  
                                <th>customerAddress</th>  
                                <th>customerCity</th>  
                                <th>customerZipCode</th>  
                                <th>customerEmail</th>  
                           </tr>  ';
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
                                            
                                            $address = $row2['addresses'][1]['address'];
                                                $city = $row2['addresses'][1]['city'];
                                            $zip = $row2['addresses'][1]['zip'];
            $table = $table.'<tr><td>'.$orderid.'</td>
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
   $table = $table.'</table>';
 
  
 $html = str_get_html($table);
 
 
 
 header('Content-type: application/ms-excel');
 header('Content-Disposition: attachment; filename=lamaorders.csv');
 
 $fp = fopen("php://output", "w");
 
 foreach($html->find('tr') as $element)
 {
         $th = array();
         foreach( $element->find('th') as $row)  
         {
             $th [] = $row->plaintext;
         }
 
         $td = array();
         foreach( $element->find('td') as $row)  
         {
             $td [] = $row->plaintext;
         }
         !empty($th) ? fputcsv($fp, $th) : fputcsv($fp, $td);
 }
 
 
 fclose($fp);
 ?>