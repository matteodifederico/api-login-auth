<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/class-security.php';

/**
 * Box for API methods
 * @author Matteo Di Federico <moaidesign@protonmail.com> 
 */
class API {

  /**
   * login authentication
   * Expalmple login.php?token=YOURTOKEN&username=REQUESTUSERNAME&pasword=PLAINTEXTPASSWORD
   * @author Matteo Di Federico <moaidesign@protonmail.com>
   */
  public function login(){
    $db = new Connect;
    $security = new Security;
    $requestApplicationToken = $security->disinfectData($_GET['token']);
    $requestUserName = $security->disinfectData($_GET['username']);
    $requestUserPassword = $security->disinfectData($_GET['password']);
    $applicationIsValid = $security->validateApplicationToken($requestApplicationToken);
    if($applicationIsValid == true){
      $requestUserPasswordHash = $security->passwordHash($requestUserPassword);
      $services = array();
      $data = $db->prepare("SELECT * FROM users WHERE username='$requestUserName' AND password='$requestUserPasswordHash'");
      $data->execute();
      while($OutputData = $data->fetch(PDO::FETCH_ASSOC)){
        $services[$OutputData['id']] = array(
          'response'            => 'true',
          'id'            => $OutputData['id'],
          'username'        => $OutputData['username'],
          'password'   => $OutputData['password'],
          'recoveryPin'     => $OutputData['recoveryPin']
        );
      }
      return json_encode($services);
    }else{
      $error = 'Questa applicazione non è autorizzata ad utilizzare questo servizio';
      return $error;
    }

  }
}

?>
