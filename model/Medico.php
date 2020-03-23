<?php
class Medico {

    private $cpf;
    private $nome;
    private $DB;

    public function __construct() {
        $this->DB = new DataBase();
    }

    public function fill($cpf, $nome) {
        $this->nome = $nome;
        $this->cpf = $cpf;
    }


    public function getCpf() {
        return $this->cpf;
    }
    private function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function save() {
        $this->DB->connect();
        $sql = "SELECT * FROM medico WHERE cpf = '$this->cpf';";
        $resultado = mysqli_query($this->DB->connection, $sql);
        if(mysqli_num_rows($resultado) > 0) {
            return "JA_CADASTRADO";
        }
        $sql = "INSERT INTO medico(nome, cpf) VALUES ('$this->nome', '$this->cpf');";
        if(mysqli_query($this->DB->connection, $sql)) {
            $this->DB->close();
            return "Médico cadastrado com sucesso";
        } else {
            $this->DB->close();
            return "Erro ao cadastrar";
        }
    }

    public function update() {
        $this->DB->connect();
        $sql = "UPDATE medico SET nome = '$this->nome' WHERE cpf = '$this->cpf';";
        if(mysqli_query($this->DB->connection, $sql)) {
            $this->DB->close();
            return "Médico atualizado com sucesso";
        } else {
            $this->DB->close();
            return "Erro ao atualizar";
        }
        
    }

    public function destroy() {
        $this->DB->connect();
        $sql = "DELETE FROM medico WHERE cpf = '$this->cpf';";
        if(mysqli_query($this->DB->connection, $sql)) {
            $this->DB->close();
            return "Médico deletado com sucesso!";  
        } else {
            $error = mysqli_errno($this->DB->connection);
            $this->DB->close();
            if($error == "1451") {
                $error = "Não foi possível deletar: ESTE MÈDICO PERTENCE A UMA CONSULTA";
            } else {
                $error = "Erro ao deletar";
            }
            return $error;
        }
    }

    public function listAll() {
        $this->DB->connect();
        $sql = "SELECT * FROM medico ORDER BY nome;";
        $resultado = mysqli_query($this->DB->connection, $sql);
        $medicos = [];
        if(mysqli_num_rows($resultado) > 0) {
            while($dados = mysqli_fetch_array($resultado)) {
                $medico = new Medico();
                $medico->fill($dados['cpf'],$dados['nome']);
                $medicos[] = $medico;
            }
        }
        $this->DB->close();
        return $medicos;
    }

    public function getByCpf($cpf) {
        $this->DB->connect();
        $sql = "SELECT * FROM medico WHERE cpf = '$cpf'";
        $resultado = mysqli_query($this->DB->connection, $sql);
        if(mysqli_num_rows($resultado) > 0) {
            $dados = mysqli_fetch_array($resultado);
            $medico = new Medico();
            $medico->fill($dados['cpf'],$dados['nome']);
            $this->DB->close();
            return $medico;
        } else {
            $this->DB->close();
            return null;
        }
    }

    public function getByCpfAndNome($cpf, $nome) {
        $this->DB->connect();
        $sql = "SELECT * FROM medico WHERE cpf = '$cpf'AND nome = '$nome';";
        $resultado = mysqli_query($this->DB->connection, $sql);
        if(mysqli_num_rows($resultado) > 0) {
            $dados = mysqli_fetch_array($resultado);
            $medico = new Medico();
            $medico->fill($dados['cpf'],$dados['nome']);
            $this->DB->close();
            return $medico;
        } else {
            $this->DB->close();
            return null;
        }
    }

    public function getLike($nome) {
        $this->DB->connect();
        $sql = "SELECT * FROM medico WHERE nome LIKE '%$nome%' ORDER BY nome;";
        $resultado = mysqli_query($this->DB->connection, $sql);
        $medicos = [];
        if(mysqli_num_rows($resultado) > 0) {
            while($dados = mysqli_fetch_array($resultado)) {
                $medico = new Medico();
                $medico->fill($dados['cpf'],$dados['nome']);
                $medicos[] = $medico; 
            }
        }
        $this->DB->close();
        return $medicos;
    }


}


?>