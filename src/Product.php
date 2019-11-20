<?php
namespace oldspice;

use \Exception;
use oldspice\Database;
class Product extends Database{
  public function __construct(){
      parent::__construct();
  }  
  public function getProducts(){
$query = "
SELECT 
product_id,
name,
description,
price
FROM product
";
try{
$statement = $this ->connection ->prepare($query);
if($statement->execute()==false){
    throw new Exception ("query failed to execute");
}
}
catch(Exception $exe){
    echo $exc;

}
$result =$statement->get_result();
//product array
$products = array();
//loop through result and add to array
while ($row = $result ->fetch_assoc()){
    array_push($products, $row);
}
return $products;

  }
}
?>