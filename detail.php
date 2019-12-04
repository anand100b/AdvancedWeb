<?php
require('vendor/autoload.php');

use oldspice\productDetail;
if($_SERVER['REQUEST_METHOD']=="GET"&& isset($_GET['product_id'])){
    $product_id =$_GET['product_id'];
    $pd = new productDetail();
    $detail = $pd -> getDetail($product_id);
}
else{
    $detail = '';
}

//Twig
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
//load the templates
$template = $twig-> load('detail.twig');
//output the template to page
echo $template ->render([
    'detail' =>$detail,
    'title' =>'Detail for'.$detail['product']['name']
]);

?>