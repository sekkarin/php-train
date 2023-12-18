<?php

    class Authentication{  
        private  $condb;
        private $userModel;

        function __construct($db,$userModel){
            $this->condb = $db;
            $this->userModel = $userModel;
            
        }
        public function pageRedirect($url)
        {
          header("location:" . $url);
          exit(0);
        }
        public function login()
        {
           
            $user = $this->userModel->getUserByUsername($username);
            try {
                if (isset($_POST['login'])) {

                    if ($user && password_verify($password, $user['password'])) {
                        // Start session and store user data
                        session_start();
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
            
                        return true;
                    }
            
                    return false;
          
                }
              } catch (Exception $error) {
                echo $error;
              }
    
            
        }
    
        public function logout()
        {
            // Destroy session and redirect to login page
            session_start();
            session_destroy();
            header("Location: login.php");
            exit();
        }
    
        public function isAuthenticated()
        {
            // Check if the user is authenticated
            return isset($_SESSION['user_id']);
        }
        public function register()
        {
            // Check if the user is authenticated
            // return isset($_SESSION['user_id']);
        }
        public function indexView()
        {
        
          include('./views/homeView.php');
        }
        public function mvcHandler()
        {
            $authRouter = isset($_GET['authRoute']) ? $_GET['authRoute'] : NULL;
            switch ($authRouter) {
            case 'loginPage':
                $this->pageRedirect("./views/login.php");
                break;
            case 'login':
                $this->login();
                break;
            case 'registerPage':
                $this->pageRedirect("./views/registerView.php");
                break;
            case 'logout':
                break;
            default:
                $this->indexView();

            }
        }
    }

?>