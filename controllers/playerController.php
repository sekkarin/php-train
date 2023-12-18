<?php

include_once('./models/PlayerModel.php');
include_once('./conf/conf.php');

class PlayerController
{
  private $playerModel;
  private $conf;

  function __construct()
  {
    $this->conf = new Config();
    $this->playerModel = new PlayerModel($this->conf);
  }
  public function pageRedirect($url)
  {
    header("location:" . $url);
    exit(0);
  }
  public function indexView()
  {
    $json = $this->playerModel->getAllPlayer();
    $result = json_decode($json);
    // print_r($result);
    include('./views/listView.php');
  }
  public function insert()
  {
    try {
      if (isset($_POST['btnadd'])) {
        // add data to array
        $dataArrar = array();
        $dataArrar['firstname'] = $_POST['firstname'];
        $dataArrar['lastname'] = $_POST['lastname'];
        $dataArrar['team'] = $_POST['team'];
        $dataArrar['position'] = $_POST['position'];
        $dataArrar['image_url'] = $_POST['image'];

        //! upload image
        $target_dir = "./public/images/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        $upLoadOK = 1;
        $imageFileType  = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        //  check already exists
        if(file_exists($target_file)){
          echo "มีไฟล์แล้งใอ้เหี้ย";
          $upLoadOK = 0;
        }

        // check file size
        if($_FILES['image']['size'] > 1000000){
          echo "ของมึงใหญ่เกิน";
          $upLoadOK = 0;
        }

        //* Allow certain file formats 
        if(
          $imageFileType != "jpg" &&
          $imageFileType != "png" &&
          $imageFileType != "jpeg" &&
          $imageFileType != "gif" 
          
        ){
          echo "file มึงไม่ใช่วะ";
          $upLoadOK = 0;
        }

        //! check state
        if($upLoadOK == 0){
          echo"มีข้อผิดพลาดวะ ";
        }else{
          if(move_uploaded_file($_FILES['image']['tmp_name'],$target_file)){
              $dataArrar['image_url'] = htmlspecialchars(basename($_FILES['image']['name']));
          }else{
            echo "มีข้อผิดพลาดใอ้เวน";
          }
        }

        $insert = $this->playerModel->insertPlayer($dataArrar);
        if($insert == true){
          $this->pageRedirect('./index.php');
        }else{
          echo "ไม่สามารถอยู่ในชีวิตเขาได้ (ข้อมูล)";
        }

      }
    } catch (Exception $error) {
      echo $error;
    }
  }
  public function update()
  {
    // $this->pageRedirect("./views/updatePlayer.php");
    // include('./views/updatePlayer.php');

  }
  public function delete()
  {

  }
  public function mvcHandler()
  {
    $playerRounter = isset($_GET['playerRout']) ? $_GET['playerRout'] : NULL;
    switch ($playerRounter) {
      case 'add':
        $this->insert();
        break;
      case 'update':
        $this->update();
        break;
      case 'delete':
        break;
      default:
        $this->indexView();

    }
  }

}

?>