<?php
class Database
{
    private string $host = "";
    private string $user = "";
    private string $pass = "";
    private string $db = "";
    private  $condb = "";

    public function __construct(object $conf)
    {
        $this->host = $conf->host;
        $this->user = $conf->user;
        $this->pass = $conf->pass;
        $this->db = $conf->db;
    }

    public function connect()
    {
        try {
            $this->condb = new PDO("mysql:host=localhost;dbname=sport;", "root", "");
            $this->condb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function close_db()
    {
        $this->condb = null;
    }
}
?>
