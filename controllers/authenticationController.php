<?php
    include("Database.php");
    class Authentication{
        
        private  $condb;

        private $userModel;
        function __construct($db,$userModel){
            $this->condb = $db;
            $this->userModel = $userModel;
            
        }

        public function login($username, $password)
        {
            $user = $this->userModel->getUserByUsername($username);
    
            if ($user && password_verify($password, $user['password'])) {
                // Start session and store user data
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
    
                return true;
            }
    
            return false;
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
        public function mvcHandler()
        {
            $playerRounter = isset($_GET['auth']) ? $_GET['authRoute'] : NULL;
            switch ($playerRounter) {
            case 'login':
                $this->insert();
                break;
            case 'register':
                $this->update();
                break;
            case 'logout':
                break;
            default:
                $this->indexView();

            }
        }
    }

?>