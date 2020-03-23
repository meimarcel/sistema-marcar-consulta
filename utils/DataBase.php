<?php
class DataBase {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $db_name = "sis_consultas";
    public $connection;
    
    public function __construct($servername = "localhost", $username = "root", $password = "", $db_name = "sis_consultas") {
        $this->servername = $servername;
        $this->$username = $username;
        $this->$password = $password;
        $this->$db_name = $db_name;
    }

    public function connect() {
        $this->connection = mysqli_connect($this->servername, $this->username, $this->password, $this->db_name);
        mysqli_set_charset($this->connection, "utf8");
        if(mysqli_connect_error()) {
            return "Erro na conexao: ".mysqli_connect_error();
        }
    }

    public function protect($input) {
        $this->connection;
        $var = mysqli_escape_string($this->connection, $input);
        $var = htmlspecialchars($var);
        return $var;
    }
    public function close() {
        mysqli_close($this->connection);
    }
}
?>