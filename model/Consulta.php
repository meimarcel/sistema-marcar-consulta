<?php
// require_once "model/Paciente.php";
// require_once "model/Procedimento.php";
// require_once "model/Medico.php";

class Consulta {

    private $codigo;
    private $paciente;
    private $procedimento;
    private $medico;
    private $data_atendimento;
    private $DB;
    private $pacienteModel;
    private $procedimentoModel;
    private $medicoModel;

    public function __construct() {
        $this->DB = new DataBase();
        $this->pacienteModel = new Paciente();
        $this->procedimentoModel = new Procedimento();
        $this->medicoModel = new Medico();
    }

    public function fill($codigo, $paciente, $procedimento, $medico, $data_atendimento) {
        $this->codigo = $codigo;
        $this->paciente = $paciente;
        $this->procedimento = $procedimento;
        $this->medico = $medico;
        $this->data_atendimento = $data_atendimento;
    }

    public function getCodigo() {
        return $this->codigo;
    }
    private function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function getPaciente() {
        return $this->paciente;
    }
    public function setPaciente($paciente) {
        $this->paciente = $paciente;
    }
    public function getProcedimento() {
        return $this->procedimento;
    }
    public function setProcedimento($procedimento) {
        $this->procedimento = $procedimento;
    }
    public function getMedico() {
        return $this->medico;
    }
    public function setMedico($medico) {
        $this->medico = $medico;
    }
    public function getData_atendimento() {
        return $this->data_atendimento;
    }
    public function setData_atendimento($data_atendimento) {
        $this->data_atendimento = $data_atendimento;
    }


    public function save() {
        $this->DB->connect();
        $sql = "INSERT INTO consulta_exame(codigo, paciente, procedimento, medico, data_atendimento) VALUES ('$this->codigo', '$this->paciente', '$this->procedimento', '$this->medico', '$this->data_atendimento');";
        if(mysqli_query($this->DB->connection, $sql)) {
            $this->DB->close();
            return "Consulta marcada com sucesso";
        } else {
            $this->DB->close();
            return "Erro ao cadastrar";
        }
        
    }

    public function update() {
        $this->DB->connect();
        $sql = "UPDATE consulta_exame SET paciente='$this->paciente', procedimento='$this->procedimento', medico='$this->medico', data_atendimento='$this->data_atendimento' WHERE codigo = '$this->codigo';";
        if(mysqli_query($this->DB->connection, $sql)) {
            $this->DB->close();
            return "Consulta atualizada com sucesso";
        } else {
            $this->DB->close();
            return "Erro ao atualizar";
        } 
    }

    public function destroy() {
        $this->DB->connect();
        $sql = "DELETE FROM consulta_exame WHERE codigo = '$this->codigo'";

        if(mysqli_query($this->DB->connection, $sql)) {
            $this->DB->close();
            return "Consulta deletada com sucesso!";  
        } else {
            $error = mysqli_errno($this->DB->connection);
            $this->DB->close();
            if($error == "1451") {
                $error = "Não foi possível deletar: ESTA CONSULTA PERTENCE A UM REGISTRO DE ATENDIMENTO";
            } else {
                $error = "Erro ao deletar";
            }
            return $error;
        }
        
    }

    public function listAll() {
        $this->DB->connect();
        $sql = "SELECT * FROM consulta_exame;";
        $resultado = mysqli_query($this->DB->connection, $sql);
        $consultas = [];
        if(mysqli_num_rows($resultado) > 0) {
            while($dados = mysqli_fetch_array($resultado)) {
                $consulta = new Consulta();
                $consulta->fill($dados['codigo'],$this->pacienteModel->getById($dados['paciente'])->getNome(),$this->procedimentoModel->getByCodigo($dados['procedimento'])->getNome(),$this->medicoModel->getByCpf($dados['medico'])->getNome(),$dados['data_atendimento']);
                $consultas[] = $consulta;
            }
        }
        $this->DB->close();
        return $consultas;
    }

    public function getByCodigo($codigo) {
        $this->DB->connect();
        $sql = "SELECT * FROM consulta_exame WHERE codigo='$codigo';";
        $resultado = mysqli_query($this->DB->connection, $sql);
        if(mysqli_num_rows($resultado) > 0 ) {
            $dados = mysqli_fetch_array($resultado);
            $consulta = new Consulta();
            $consulta->fill($dados['codigo'],$this->pacienteModel->getById($dados['paciente']),$this->procedimentoModel->getByCodigo($dados['procedimento']),$this->medicoModel->getByCpf($dados['medico']),$dados['data_atendimento']);
            $this->DB->close();
            return $consulta;
        } else {
            $this->DB->close();
            return null;
        }
    }

    public function getLike($codigo) {
        $this->DB->connect();
        $sql = "SELECT * FROM consulta_exame WHERE codigo LIKE '%$codigo%' ORDER BY codigo;";
        $resultado = mysqli_query($this->DB->connection, $sql);
        $consultas = [];
        if(mysqli_num_rows($resultado) > 0) {
            while($dados = mysqli_fetch_array($resultado)) {
                $consulta = new Consulta();
                $consulta->fill($dados['codigo'],$dados['paciente'],$dados['procedimento'],$dados['medico'],$dados['data_atendimento']);
                $consultas[] = $consulta; 
            }
        }
        $this->DB->close();
        return $consultas;
    }

 




}


?>