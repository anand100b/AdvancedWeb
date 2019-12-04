<?php
require('vendor/autoload.php');

use oldspice\Navigation;
use oldspice\Product;

$navigation = Navigation::getNavigation();
$p = new Product();
$products = $p ->getProducts();

//Twig
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
//load the templates
$template = $twig-> load('home.twig');
//output the template to page
echo $template ->render([
    'navigation'=>$navigation,
    'products' =>$products,
    'title' =>'Home Page'

]);

?>