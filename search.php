<?php
require('vendor/autoload.php');
use oldspice\ProductSearch;
use oldspice\Navigation;
if(isset($_GET['query'])){
  $search = new ProductSearch();
  $search_result = $search-> getResult($_GET['query']);

}
else{
  $search_result = null;
}
$navigation = Navigation::getNavigation();
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
$templates = $twig -> load('search.twig');

echo $templates -> render(
  array(
    'result' => $search_result,
    'keyword'=> $_GET['query'],

    'navigation' => $navigation,
    'title'=>"Search result for".$_GET['query']

  )
)


?>