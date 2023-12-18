<?php

    class Authentication{  
        private $userModel;

        function __construct($userModel){
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
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get form data
                $username = $_POST["username"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $confirm_password = $_POST["confirm_password"];
                
            
                // Basic validation
                if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
                    // Handle validation errors (e.g., display an error message)
                    echo "All fields are required.";
                } elseif ($password !== $confirm_password) {
                    // Handle password mismatch
                    echo "Passwords do not match.";
                } else {
                    
                     // Hash the password before storing it
                     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
                     // Insert user data into the database
                     $userModel->registerUser($username, $email, $hashedPassword);

                    // Check if the username or email is already registered
                    // if ($userModel->isUsernameTaken($username)) {
                    //     echo "Username is already taken.";
                    // }else {
                    //     // Hash the password before storing it
                    //     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
                    //     // Insert user data into the database
                    //     $userModel->registerUser($username, $email, $hashedPassword);
            
                    //     // Redirect to a success page or login page
                    //     header("Location: registration_success.php");
                    //     exit();
                    // }
                }
            } else {
                // Redirect to the registration form if the form is not submitted
                header("Location: register.php");
                exit();
            }
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
            case 'register':
                $this->register();
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