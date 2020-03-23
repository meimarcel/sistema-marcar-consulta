<?php

class RegistroAtendimento {

    private $id;
    private $codigo_agendamento;
    private $situacao;
    private $data_efetiva_atendimento;
    private $obs;
    private $DB;

    public function __construct() {
        $this->DB = new DataBase();        
    }

    public function fill($codigo_agendamento, $situacao, $data_efetiva_atendimento, $obs) {
        $this->codigo_agendamento = $codigo_agendamento;
        $this->situacao = $situacao;
        $this->data_efetiva_atendimento = $data_efetiva_atendimento;
        $this->obs = $obs;
    }

    public function getId() {
        return $this->id;
    }
    private function setId($id) {
        $this->id = $id;
    }

    public function getCodigo_agendamento() {
        return $this->codigo_agendamento;
    }
    public function setCodigo_agendamento($codigo_agendamento) {
        $this->codigo_agendamento = $codigo_agendamento;
    }

    public function getSituacao() {
        return $this->situacao;
    }
    public function setSituacao($situacao) {
        $this->situacao = $situacao;
    }
    public function getData_efetiva_atendimento() {
        return $this->data_efetiva_atendimento;
    }
    public function setData_efetiva_atendimento($data_efetiva_atendimento) {
        $this->data_efetiva_atendimento = $data_efetiva_atendimento;
    }
    public function getObs() {
        return $this->obs;
    }
    public function setObs($obs) {
        $this->obs = $obs;
    }

    public function save() {
        $this->DB->connect();
        if($this->data_efetiva_atendimento == null && $this->obs != null) {
            $sql = "INSERT INTO registro_atendimento(codigo_agendamento, situacao, data_efetiva_atendimento, obs) VALUES ('$this->codigo_agendamento', '$this->situacao', NULL, '$this->obs');";    
        }
        else if($this->data_efetiva_atendimento != null && $this->obs == null) {
            $sql = "INSERT INTO registro_atendimento(codigo_agendamento, situacao, data_efetiva_atendimento, obs) VALUES ('$this->codigo_agendamento', '$this->situacao', '$this->data_efetiva_atendimento', NULL);";
        }
        else if($this->data_efetiva_atendimento == null && $this->obs == null) {
            $sql = "INSERT INTO registro_atendimento(codigo_agendamento, situacao, data_efetiva_atendimento, obs) VALUES ('$this->codigo_agendamento', '$this->situacao', NULL, NULL);";
        } else {
            $sql = "INSERT INTO registro_atendimento(codigo_agendamento, situacao, data_efetiva_atendimento, obs) VALUES ('$this->codigo_agendamento', '$this->situacao', '$this->data_efetiva_atendimento', '$this->obs');";
        }
        if(mysqli_query($this->DB->connection, $sql)) {
            $this->DB->close();
            return "Registro de atendimento cadastrado com sucesso";
        } else {
            $this->DB->close();
            return "Erro ao cadastrar";
        }
    }

    public function update() {
        $this->DB->connect();
        if($this->data_efetiva_atendimento == null && $this->obs != null) {
            $sql = "UPDATE registro_atendimento SET codigo_agendamento = '$this->codigo_agendamento',situacao = '$this->situacao',data_efetiva_atendimento = NULL,obs = '$this->obs' WHERE id = '$this->id';";
        }
        else if($this->data_efetiva_atendimento != null && $this->obs == null) {
            $sql = "UPDATE registro_atendimento SET codigo_agendamento = '$this->codigo_agendamento',situacao = '$this->situacao',data_efetiva_atendimento = '$this->data_efetiva_atendimento',obs = NULL WHERE id = '$this->id';";
        }
        else if($this->data_efetiva_atendimento == null && $this->obs == null) {
            $sql = "UPDATE registro_atendimento SET codigo_agendamento = '$this->codigo_agendamento',situacao = '$this->situacao',data_efetiva_atendimento = NULL,obs = NULL WHERE id = '$this->id';";
        } else {
            $sql = "UPDATE registro_atendimento SET codigo_agendamento = '$this->codigo_agendamento',situacao = '$this->situacao',data_efetiva_atendimento = '$this->data_efetiva_atendimento',obs = '$this->obs' WHERE id = '$this->id';";
        }
        
        if(mysqli_query($this->DB->connection, $sql)) {
            $this->DB->close();
            return "Registro de atendimento atualizado com sucesso";
        } else {
            $this->DB->close();
            return "Erro ao atualizar";
        }
        
    }

    public function destroy() {
        $this->DB->connect();
        $sql = "DELETE FROM registro_atendimento WHERE id = '$this->id';";
        if(mysqli_query($this->DB->connection, $sql)) {
            $this->DB->close();
            return "Registro de atendimento deletado com sucesso!";  
        } else {
            $this->DB->close();
            return "Erro ao deletar";
        }
    }

    public function listAll() {
        $this->DB->connect();
        $sql = "SELECT * FROM registro_atendimento";
        $resultado = mysqli_query($this->DB->connection, $sql);
        $registros = [];
        if(mysqli_num_rows($resultado) > 0) {
            while($dados = mysqli_fetch_array($resultado)) {
                $registro = new RegistroAtendimento();
                $registro->fill($dados['codigo_agendamento'],$dados['situacao'], $dados['data_efetiva_atendimento'], $dados['obs']);
                $registro->setId($dados['id']);
                $registros[] = $registro;
            }
        }
        $this->DB->close();
        return $registros;
    }

    public function getById($id) {
        $this->DB->connect();
        $sql = "SELECT * FROM registro_atendimento WHERE id = '$id'";
        $resultado = mysqli_query($this->DB->connection, $sql);
        if(mysqli_num_rows($resultado) > 0) {
            $dados = mysqli_fetch_array($resultado);
            $registro = new RegistroAtendimento();
            $registro->fill($dados['codigo_agendamento'],$dados['situacao'], $dados['data_efetiva_atendimento'], $dados['obs']);
            $registro->setId($dados['id']);
            $this->DB->close();
            return $registro;
        } else {
            $this->DB->close();
            return null;
        }
    }





}

?>