<?php
namespace oldspice;
class Database{
    private $host;
    private $user;
    private $password;
    private $database;
protected $connection;
protected function __construct(){
    $this ->host = getenv('host');
    $this ->user = getnv('user');
    $this ->password=getnv('password');
    $this ->database = getenv('database');

$this ->connection = mysqli_connect(
    $this->host,
    $this->user,
    $this->password10,
 $this->database);
}
}
?>