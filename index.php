<?php
    include_once('./conf/conf.php');
    require_once('./utils/Database.php');
    require_once('./models/UserModel.php');
    require_once('./controllers/authenticationController.php');

    //! setup
    $conf = new Config();
    $db = new Database($conf);
    $userModel = new UserModel($db);
    // $db->connect();
    $authController = new Authentication($userModel);
    $authController->mvcHandler();
    


    // $modelPlayer = new PlayerModel($conf);
    // $controllerPlayer->mvcHandler();

?>