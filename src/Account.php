<?php

namespace oldspice;

use oldspice\Database;
use \Exception;

class Account extends Database {
    public function __construct() {
        parent::__construct();
    }

    public function register($email, $password) {
        $response = array();
        $errors = array();

        // validate email
        try{
            if( filter_var( $email, FILTER_VALIDATE_EMAIL ) == false )  {
                throw new Exception('Invalid email address');
            }
        }
        catch ( Exception $exc) {
            $errors['email'] = $exc -> getMessage();
        }

        // validate password
        try {
            if( strlen($password) < 8 ) {
                throw new Exception('Password minimum is 8 characters');
            }
        }
        catch (Exception $exc) {
            $errors['password'] = $exc -> getMessage();
        }

        if (count($errors) > 0) {
            $response['success'] = false;
            $response['errors']=$errors;
            return $response;
        }
        // if there are no errors
        // hash the password

        $hash = password_hash( $password, PASSWORD_DEFAULT );
        $account_id = $this -> generateId();

        // QUERY to insert account
        $query = "INSERT INTO account 
        (account_id, email, password, created, active, lastlogin)
        VALUES (UNHEX(?), ?, ?, NOW(), 1, NOW()) ";

        $statement = $this -> connection -> prepare($query);
        $statement -> bind_param('sss', $account_id, $email, $hash);
        try{
            if ($statement -> execute() == false) {
                // checkif the account already exists
                if( $this -> connection -> errno == '1062') {
                    throw new Exception('email address already used');
                }
                else {
                    throw new Exception('something is terrible wrong');
                }
            }
        }
        catch (Exception $exc){
            $errors['system'] = $exc -> getMessage();
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        // no errors, registration successful
        // create user session
        if ( session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['auth'] = $account_id;
        $response['success'] = true;
        return $response;
    }

    private function generateId() {
        if( function_exists('random_bytes')) {
            $bytes = random_bytes(16);
        }
        else {
            $bytes = openssl_random_pseudo_bytes(16);
        }
        return bin2hex( $bytes );
    }
}

?>
