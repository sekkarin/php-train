<?php
class PlayerModel
{
    private string $host = '';
    private string $user = '';
    private string $pass = '';
    private string $db = '';
    private $condb;

    function __construct(object $conf)
    {
        $this->host = $conf->host;
        $this->user = $conf->user;
        $this->pass = $conf->pass;
        $this->db = $conf->db;
    }
    public function connect(): void
    {
        try {
            $this->condb = new PDO("mysql:host=$this->host;dbname=$this->db;", $this->user, $this->pass);
            // set the PDO error mode to exception
            $this->condb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public function close_db()
    {
        $this->condb = null;
    }
    public function insertPlayer(array $dataArray): bool
    {
        $this->connect();
        $sql = " INSERT INTO `football_player` (`identifier`, `firstname`, `lastname`, `team`, `position`, `image_url`)";
        $sql .= " VALUES (null, :firstname, :lastname, :team,:position , :image_url);";
        $query = $this->condb->prepare($sql);
        if($query->execute($dataArray)){

            return true;
        }else{
            return false;
        }
        
    }
    public function updatePlayer($dataArray)
    {
        // $sql = "UPDATE `football_player` SET 
        // `firstname` = :firstname,
        // `lastname` = :lastname,
        // `team` = :team,
        // `position` = :position,
        // `image_url` = :image_url";
        // $sql .= " WHERE `football_player`.`identifier` = :identifier";
    }
    public function deletePlayer($identifier): bool
    {
        
        // $sql = "DELETE FROM football_player WHERE `football_player`.`identifier` = " . $identifier . " ;";
        return true;
    }
    public function getPlayer($identifier)
    {
        // $sql = "SELECT * FROM `football_player` WHERE `identifier` = " . $identifier;
    }
    public function getAllPlayer()
    {
        $this->connect();
        $sql = "SELECT * FROM `football_player` ORDER BY `football_player`.`identifier` DESC";
        $query = $this->condb->prepare($sql);
        if($query->execute()){
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($result);
        }else{
            return false;
        }

    }
}

?>