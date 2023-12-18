<?php
    include_once('./conf/conf.php');

    require_once('./utils/Database.php');

    //! setup
    $conf = new Config();
    $db = new Database($conf);




    // $modelPlayer = new PlayerModel($conf);
    // $controllerPlayer->mvcHandler();

?>