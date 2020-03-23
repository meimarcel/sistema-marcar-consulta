<?php

class Procedimento {

    private $codigo;
    private $nome;
    private $idade_minima;
    private $idade_maxima;
    private $sexo;
    private $DB;

    public function __construct() {
        $this->DB = new DataBase();
    }

    public function fill($codigo, $nome, $idade_minima, $idade_maxima, $sexo) {
        $this->codigo = $codigo;
        $this->nome = $nome;
        $this->idade_minima = $idade_minima;
        $this->idade_maxima = $idade_maxima;
        $this->sexo = $sexo;
    }

    public function getCodigo() {
        return $this->codigo;
    }
    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getIdade_minima() {
        return $this->idade_minima;
    }
    public function setIdade_minima($idade_minima) {
        $this->idade_minima = $idade_minima;
    }
    public function getIdade_maxima() {
        return $this->idade_maxima;
    }
    public function setIdade_maxima($idade_maxima) {
        $this->idade_maxima = $idade_maxima;
    }
    public function getSexo() {
        return $this->sexo;
    }
    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    public function save() {
        $this->DB->connect();
        $sql = "SELECT * FROM procedimento WHERE codigo = '$this->codigo';";
        $resultado = mysqli_query($this->DB->connection, $sql);
        if(mysqli_num_rows($resultado) > 0) {
            $this->DB->close();
            return "JA_CADASTRADO";
        }
        $sql = "INSERT INTO procedimento(codigo, nome, idade_minima, idade_maxima, sexo) VALUES ('$this->codigo', '$this->nome', '$this->idade_minima', '$this->idade_maxima', '$this->sexo');";
        if(mysqli_query($this->DB->connection, $sql)) {
            $this->DB->close();
            return "Procedimento cadastrado com sucesso";
        } else {
            $this->DB->close();
            return "Erro ao cadastrar";
        }
        
    }

    public function update() {
        $this->DB->connect();
        $sql = "UPDATE procedimento SET nome='$this->nome', idade_minima='$this->idade_minima', idade_maxima='$this->idade_maxima', sexo='$this->sexo' WHERE codigo = '$this->codigo';";
        if(mysqli_query($this->DB->connection, $sql)) {
            $this->DB->close();
            return "Procedimento atualizado com sucesso";
        } else {
            $this->DB->close();
            return "Erro ao atualizar";
        }
        
    }

    public function destroy() {
        $this->DB->connect();
        $sql = "DELETE FROM procedimento WHERE codigo = '$this->codigo';";

        if(mysqli_query($this->DB->connection, $sql)) {
            $this->DB->close();
            return "Procedimento deletado com sucesso!";  
        } else {
            $error = mysqli_errno($this->DB->connection);
            $this->DB->close();
            if($error == "1451") {
                $error = "Não foi possível deletar: ESTE PROCEDIMENTO PERTENCE A UMA CONSULTA";
            } else {
                $error = "Erro ao deletar";
            }
            return $error;
        }
        
    }

    public function listAll() {
        $this->DB->connect();
        $sql = "SELECT * FROM procedimento ORDER BY nome;";
        $resultado = mysqli_query($this->DB->connection, $sql);

        $procedimentos = [];
        if(mysqli_num_rows($resultado) > 0) {
            while($dados = mysqli_fetch_array($resultado)) {
                $procedimento = new Procedimento();
                $procedimento->fill($dados['codigo'],$dados['nome'],$dados['idade_minima'],$dados['idade_maxima'],$dados['sexo']);
                $procedimentos[] = $procedimento;
            }
        }
        $this->DB->close();
        return $procedimentos;
    }

    public function getByCodigo($codigo) {
        $this->DB->connect();
        $sql = "SELECT * FROM procedimento WHERE codigo = '$codigo'";
        $resultado = mysqli_query($this->DB->connection, $sql);
        if(mysqli_num_rows($resultado) > 0) {
            $dados = mysqli_fetch_array($resultado);
            $procedimento = new Procedimento();
            $procedimento->fill($dados['codigo'],$dados['nome'],$dados['idade_minima'],$dados['idade_maxima'],$dados['sexo']);
            $this->DB->close();
            return $procedimento; 
        } else {
            $this->DB->close();
            return null;
        }
    }


}


?>