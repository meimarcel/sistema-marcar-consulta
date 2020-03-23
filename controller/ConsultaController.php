<?php
// require_once 'utils/db_connection.php';
// require_once 'utils/util.php';
// require_once 'model/Paciente.php';
// require_once 'model/Medico.php';
// require_once 'model/Procedimento.php';
// require_once "model/Consulta.php";

class ConsultaController {
    private $DB;
    private $util;
    private $consultaModel;
    private $procedimentoModel;
    private $pacienteModel;
    private $medicoModel;

    public function __construct() {
        $this->DB = new DataBase();
        $this->util = new Utils();
        $this->consultaModel = new Consulta();
        $this->procedimentoModel = new Procedimento();
        $this->medicoModel = new Medico();
        $this->pacienteModel = new Paciente();

    }

    public function index() {
        $consultas = $this->consultaModel->listAll();
        $_REQUEST['consultas'] = $consultas;
        require_once "views/consulta-menu.php";
    }


    public function create() {
        $procedimentos = $this->procedimentoModel->listAll();
        $_REQUEST['procedimentos'] = $procedimentos;
        require_once "views/consulta-create.php";
    }

    public function editar() {
        $consulta = $this->consultaModel->getByCodigo($_GET['codigo']);
        $procedimentos = $this->procedimentoModel->listAll();
        $_REQUEST['procedimentos'] = $procedimentos;
        $_REQUEST['consulta'] = $consulta;
        require_once "views/consulta-editar.php";
    }

    public function read() {
        $consulta = $this->consultaModel->getByCodigo($_GET['codigo']);
        $_REQUEST['consulta'] = $consulta;
        require_once "views/consulta-read.php";
    }

    public function save() {
        $this->DB->connect();
        $paciente_view = $this->DB->protect($_POST['paciente-view']);
        $paciente = $this->DB->protect($_POST['paciente']);
        $procedimento = $this->DB->protect($_POST['procedimento']);
        $medico_view = $this->DB->protect($_POST['medico_view']);
        $medico = $this->DB->protect($_POST['medico']);
        $data_atendimento = $this->DB->protect($_POST['data_atendimento']);
        $this->DB->close();
        $_SESSION['paciente_view'] = $paciente_view;
        $_SESSION['paciente'] = $paciente;
        $_SESSION['medico_view'] = $medico_view;
        $_SESSION['medico'] = $medico;
        $_SESSION['data_atendimento'] = $data_atendimento;

        if(!$this->util->strNoEmptyOrNull($paciente_view)) {
            $_SESSION['mensagem'] = "Escolha um paciente";
            return header('location: index.php?classe=Consulta&metodo=create');
        }
        if(!$this->util->strNoEmptyOrNull($procedimento)){
            $_SESSION['mensagem'] = "Informe o precedimento";
            return header('location: index.php?classe=Consulta&metodo=create');
        }
        $procedimento_aux = $this->procedimentoModel->getByCodigo($procedimento);
        $_SESSION['procedimento_codigo'] = $procedimento_aux->getCodigo();
        $_SESSION['procedimento_nome'] = "#".$procedimento_aux->getCodigo()." ".$procedimento_aux->getNome();

        if(!$this->util->strNoEmptyOrNull($medico_view) ){
            $_SESSION['mensagem'] = "Escolha um médico";
            return header('location: index.php?classe=Consulta&metodo=create');
        }
        if(!$this->util->strNoEmptyOrNull($data_atendimento)){
            $_SESSION['mensagem'] = "Informe a data de atendimento";
            return header('location: index.php?classe=Consulta&metodo=create');
        } 

        $paciente_aux = $this->pacienteModel->getByIdAndNome($paciente, $paciente_view);
        if($paciente_aux == null) {
            $_SESSION['mensagem'] = "Paciente não encontrado";
            $_SESSION['paciente'] = "-1";
            $_SESSION['paciente_view'] = "";
            return header('location: index.php?classe=Consulta&metodo=create');
        }
        if($procedimento_aux == null) {
            $_SESSION['mensagem'] = "Procedimento não encontrado";
            return header('location: index.php?classe=Consulta&metodo=create');
        } else {
            if($procedimento_aux->getSexo() != "A" && $procedimento_aux->getSexo() != $paciente_aux->getSexo()) {
                $_SESSION['mensagem'] = "Procedimento não disponível para o sexo desse paciente";
                $_SESSION['procedimento_nome'] = "";
                $_SESSION['procedimento_codigo'] = "";
                return header('location: index.php?classe=Consulta&metodo=create');
            }
            if($paciente_aux->getIdade() < $procedimento_aux->getIdade_minima() || $paciente_aux->getIdade() > $procedimento_aux->getIdade_maxima()) {
                $_SESSION['mensagem'] = "Paciente não atende a idade mínima ou máxima do procedimento";
                $_SESSION['procedimento_nome'] = "";
                $_SESSION['procedimento_codigo'] = "";
                return header('location: index.php?classe=Consulta&metodo=create');
            }
            
        }
        $medico_aux = $this->medicoModel->getByCpfAndNome($medico, $medico_view);
        if($medico_aux == null) {
            $_SESSION['mensagem'] = "Médico não encontrado";
            $_SESSION['medico'] = "-1";
            $_SESSION['medico_view'] = "";
            return header('location: index.php?classe=Consulta&metodo=create');
        }
        if(strtotime($data_atendimento) < strtotime(date_format(date_create(), "Y-m-d"))) {
            $_SESSION['mensagem'] = "Data de atendimento inválido";
            $_SESSION['data_atendimento'] = "";
            return header('location: index.php?classe=Consulta&metodo=create');
            
        }
        do {
            $codigo = uniqid();
            $consulta_aux = $this->consultaModel->getByCodigo($codigo);
        } while($consulta_aux != null);
        $consulta = new Consulta();
        $consulta->fill($codigo, $paciente, $procedimento, $medico, $data_atendimento);
        $_SESSION['mensagem'] = $consulta->save();
        return header('location: index.php?classe=Consulta&metodo=index');
        
    }

    public function update() {
        $this->DB->connect();
        $codigo = $this->DB->protect($_POST['codigo']);
        $paciente_view = $this->DB->protect($_POST['paciente-view']);
        $paciente = $this->DB->protect($_POST['paciente']);
        $procedimento = $this->DB->protect($_POST['procedimento']);
        $medico = $this->DB->protect($_POST['medico']);
        $medico_view = $this->DB->protect($_POST['medico_view']);
        $data_atendimento = $this->DB->protect($_POST['data_atendimento']);
        $data_atendimento_atual = $this->DB->protect($_POST['data_atendimento_atual']);
        $this->DB->close();
    
        if(!$this->util->strNoEmptyOrNull($codigo)) {
            $_SESSION['mensagem'] = "Consulta não encontrada";
            return header('location: index.php?classe=Consulta&metodo=editar&codigo='.$codigo);
        }
        else if(!$this->util->strNoEmptyOrNull($paciente)) {
            $_SESSION['mensagem'] = "Escolha um paciente";
            return header('location: index.php?classe=Consulta&metodo=editar&codigo='.$codigo);
        }
        else if(!$this->util->strNoEmptyOrNull($procedimento)){
            $_SESSION['mensagem'] = "Informe o precedimento";
            return header('location: index.php?classe=Consulta&metodo=editar&codigo='.$codigo);
        }
        else if(!$this->util->strNoEmptyOrNull($medico)){
            $_SESSION['mensagem'] = "Escolha um médico";
            return header('location: index.php?classe=Consulta&metodo=editar&codigo='.$codigo);
        }
        else if(!$this->util->strNoEmptyOrNull($data_atendimento)){
            $_SESSION['mensagem'] = "Informe a data de atendimento";
            return header('location: index.php?classe=Consulta&metodo=editar&codigo='.$codigo);
        } else {
            $paciente_aux = $this->pacienteModel->getByIdAndNome($paciente, $paciente_view);
            if($paciente_aux == null) {
                $_SESSION['mensagem'] = "Paciente não encontrado";
                return header('location: index.php?classe=Consulta&metodo=editar&codigo='.$codigo);
            }
            $procedimento_aux = $this->procedimentoModel->getByCodigo($procedimento);
            if($procedimento_aux == null) {
                $_SESSION['mensagem'] = "Procedimento não encontrado";
                return header('location: index.php?classe=Consulta&metodo=editar&codigo='.$codigo);
            } else {
                if($procedimento_aux->getSexo() != "A" && $procedimento_aux->getSexo() != $paciente_aux->getSexo()) {
                    $_SESSION['mensagem'] = "Procedimento não disponível para o sexo desse paciente";
                    return header('location: index.php?classe=Consulta&metodo=editar&codigo='.$codigo);
                }
                if($paciente_aux->getIdade() < $procedimento_aux->getIdade_minima() || $paciente_aux->getIdade() > $procedimento_aux->getIdade_maxima()) {
                    $_SESSION['mensagem'] = "Paciente não atende a idade mínima ou máxima do procedimento";
                    return header('location: index.php?classe=Consulta&metodo=editar&codigo='.$codigo);
                }
                
            }
            $medico_aux = $this->medicoModel->getByCpfAndNome($medico, $medico_view);
            if($medico_aux == null) {
                $_SESSION['mensagem'] = "Médico não encontrado";
                return header('location: index.php?classe=Consulta&metodo=editar&codigo='.$codigo);
            }
            if(strtotime($data_atendimento) < strtotime(date_format(date_create(), "Y-m-d")) && $data_atendimento != $data_atendimento_atual) {
                $_SESSION['mensagem'] = "Data de atendimento inválido";
                return header('location: index.php?classe=Consulta&metodo=editar&codigo='.$codigo);
                
            }
            $consulta = $this->consultaModel->getByCodigo($codigo);
            $consulta->setPaciente($paciente);
            $consulta->setProcedimento($procedimento);
            $consulta->setMedico($medico);
            $consulta->setData_atendimento($data_atendimento);
            $_SESSION['mensagem'] = $consulta->update();
            return header('location: index.php?classe=Consulta&metodo=index');
        
        }
    }

    public function delete() {
        $consulta = $this->consultaModel->getByCodigo($_POST['codigo']);
        $_SESSION['mensagem'] = $consulta->destroy();
        return header('location: index.php?classe=Consulta&metodo=index');
    }

    public function searchPaciente() {
        if(isset($_POST['search_paciente'])) {

            $nome = $_POST['search_paciente'];
            $pacientes = $this->pacienteModel->getLike($nome);
            echo "
            <ul class='sear'>
                <li><a><strong>Nome | Cartão SUS</strong></a></li>";
                if(empty($pacientes)) {
                    echo "<li onclick=\"fill_paciente(',')\" ><a>Nenhum paciente encontrado</a></li>";
                } else {
                    foreach ($pacientes as $paciente) {
                        echo "<li onclick=\"fill_paciente('".$paciente->getId()."','".$paciente->getNome()."')\">
                        <a>".$paciente->getNome()."  ".$paciente->getCartao_sus()."</a>
                    </li>";
                    }
                }
            echo "</ul>";
        }
        

    }

    public function searchMedico() {
        if(isset($_POST['search_medico'])) {

            $nome = $_POST['search_medico'];
            $medicos = $this->medicoModel->getLike($nome);
            echo "
            <ul class='sear'>
                <li ><a><strong>Nome | CPF</strong></a></li>";
                if(empty($medicos)) {
                    echo "<li onclick=\"fill_medico(',')\" ><a>Nenhum médico encontrado</a></li>";
                } else {
                    foreach ($medicos as $medico) {
                        echo "<li onclick=\"fill_medico('".$medico->getCpf()."','".$medico->getNome()."')\">
                        <a>".$medico->getNome()."  ".$medico->getCpf()."</a>
                    </li>";
                    }
                }
            echo "</ul>";
        }
        

    }




}
?>

