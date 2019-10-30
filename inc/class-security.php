<?php

require_once __DIR__ . '/config.php';

/**
 * Box for security and criptogrphy methods
 * @author Matteo Di Federico <moaidesign@protonmail.com> 
 */
class Security
{

  /**
   * Check if get application token is exists
   */
  public function validateApplicationToken($token){
      $sanifyToken = $this->disinfectData($token);
      $db = new Connect;
      $services = array();
      $data = $db->prepare("SELECT * FROM applications WHERE token='$sanifyToken'");
      $data->execute();
      $OutputData = $data->fetch(PDO::FETCH_ASSOC);
      if($OutputData == null || $OutputData == ''){
        return false;
      }else{
        return true;
      }
  }

  /**
   * Didinfect input (get or post) receiving generics data
   */
  public function disinfectData($data){
    $a = filter_var($data, FILTER_SANITIZE_SPECIAL_CHARS);
    $SanifyData = filter_var($a, FILTER_SANITIZE_STRING);
    return $SanifyData;
  }

  /**
   * Disinfect and validation an email address data
   */
  public function disinfecteMail($data){
    $a = filter_var($data, FILTER_SANITIZE_SPECIAL_CHARS);
    $b = filter_var($a, FILTER_SANITIZE_EMAIL);
    $SanifyEmail = filter_var($b, FILTER_SANITIZE_STRING);
    return $SanifyEmail;
  }

  /**
   * Generate a random alphanumeric string
   */
  public function createRandomKey() {
      $lenght = 50;
      $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $randomString = '';
      for ($i = 0; $i < $lenght; $i++) {
          $randomString .= $char[rand(0, strlen($char) - 1)];
      }
      return $randomString;
  }

  /**
   * Generate an application random token
   */
  public function createRandomToken() {
      $lenght = 30;
      $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_!"£$%&/()=+*§#@;:,.<>"';
      $randomString = '';
      for ($i = 0; $i < $lenght; $i++) {
          $randomString .= $char[rand(0, strlen($char) - 1)];
      }
      return $randomString;
  }

  /**
   * Password hashing method
   */
  public function passwordHash($password) {
    $hash = sha1(md5(sha1($password)));
    return $hash;
  }

}

?>
