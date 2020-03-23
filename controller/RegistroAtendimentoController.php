<?php
// require_once 'utils/db_connection.php';
// require_once 'utils/util.php';
// require_once 'model/RegistroAtendimento.php';
// require_once "model/Consulta.php";

class RegistroAtendimentoController {

    private $DB;
    private $util;
    private $registroAtendimentoModel;
    private $consultaModel;

    public function __construct() {
        $this->DB = new DataBase();
        $this->util = new Utils();
        $this->registroAtendimentoModel = new RegistroAtendimento();
        $this->consultaModel = new Consulta();

    }

    public function index() {
        $registros = $this->registroAtendimentoModel->listAll();
        $_REQUEST['registros'] = $registros;
        require_once "views/registro-menu.php";
    }


    public function create() {
        require_once "views/registro-create.php";
    }

    public function editar() {
        $registro = $this->registroAtendimentoModel->getById($_GET['id']);
        $_REQUEST['registro'] = $registro;
        require_once "views/registro-editar.php";
    }

    public function read() {
        $registro = $this->registroAtendimentoModel->getById($_GET['id']);
        $_REQUEST['registro'] = $registro;
        require_once "views/registro-read.php";
    }

    public function save() {
        $this->DB->connect();
        $codigo_agendamento = $this->DB->protect($_POST['codigo_agendamento']);
        $situacao = $this->DB->protect($_POST['situacao']);
        $data_efetiva_atendimento = $this->DB->protect($_POST['data_efetiva_atendimento']);
        $obs = $this->DB->protect($_POST['obs']);
        $this->DB->close();
        $_SESSION['codigo_agendamento'] = $codigo_agendamento;
        $_SESSION['situacao'] = $situacao;
        $_SESSION['data_efetiva_atendimento'] = $data_efetiva_atendimento;
        $_SESSION['obs'] = $obs;
    
        if(!$this->util->strNoEmptyOrNull($codigo_agendamento)) {
            $_SESSION['mensagem'] = "Campo código de agendamento vazio";
            return header("location: index.php?classe=RegistroAtendimento&metodo=create");
        }

        else if(!$this->util->strNoEmptyOrNull($situacao)) {
            $_SESSION['mensagem'] = "Selecione a situação do registro";
            return header("location: index.php?classe=RegistroAtendimento&metodo=create");
        } else {
            $consulta = $this->consultaModel->getByCodigo($codigo_agendamento);
            if($consulta == null) {
                $_SESSION['mensagem'] = "Consulta Inexistente";
                $_SESSION['codigo_atendimento'] = "";
                return header("location: index.php?classe=RegistroAtendimento&metodo=create");
            }
            if($data_efetiva_atendimento != "") {
                if($data_efetiva_atendimento != $consulta->getData_atendimento()) {
                    if(!$this->util->strNoEmptyOrNull($obs)) {
                        $_SESSION['mensagem'] = "O campo observação precisa ser preenchido";
                        return header("location: index.php?classe=RegistroAtendimento&metodo=create");
                    }
                }
            }
            $registro = new RegistroAtendimento();
            $registro->fill($codigo_agendamento, $situacao, $data_efetiva_atendimento, $obs);
            $_SESSION['mensagem'] = $registro->save();
            return header("location: index.php?classe=RegistroAtendimento&metodo=index");
        
        }
    }

    public function update() {
        $this->DB->connect();
        $codigo_agendamento = $this->DB->protect($_POST['codigo_agendamento']);
        $situacao = $this->DB->protect($_POST['situacao']);
        $data_efetiva_atendimento = $this->DB->protect($_POST['data_efetiva_atendimento']);
        $obs = $this->DB->protect($_POST['obs']);
        $id = $this->DB->protect($_POST['id']);
        $this->DB->close();
    
        if(!$this->util->strNoEmptyOrNull($codigo_agendamento)) {
            $_SESSION['mensagem'] = "Campo código de atendimento vazio";
            return header('location: index.php?classe=RegistroAtendimento&metodo=editar&id='.$id);
        }

        else if(!$this->util->strNoEmptyOrNull($situacao)) {
            $_SESSION['mensagem'] = "Selecione a situação do registro";
            return header('location: index.php?classe=RegistroAtendimento&metodo=editar&id='.$id);
        } else {
            $consulta = $this->consultaModel->getByCodigo($codigo_agendamento);
            if($consulta == null) {
                $_SESSION['mensagem'] = "Consulta Inexistente";
                return header('location: index.php?classe=RegistroAtendimento&metodo=editar&id='.$id);
            }
            if($data_efetiva_atendimento != "") {
                if($data_efetiva_atendimento != $consulta->getData_atendimento()) {
                    if(!$this->util->strNoEmptyOrNull($obs)) {
                        $_SESSION['mensagem'] = "O campo observação precisa ser preenchido";
                        return header('location: index.php?classe=RegistroAtendimento&metodo=editar&id='.$id);
                    }
                }
            }

            $registro = $this->registroAtendimentoModel->getById($id);
            $registro->setCodigo_agendamento($codigo_agendamento);
            $registro->setSituacao($situacao);
            $registro->setData_efetiva_atendimento($data_efetiva_atendimento);
            $registro->setObs($obs);
            $_SESSION['mensagem'] = $registro->update();
            return header('location: index.php?classe=RegistroAtendimento&metodo=index');
        
        }
    }

    public function delete() {
        $registro = $this->registroAtendimentoModel->getById($_POST['id']);
        $_SESSION['mensagem'] = $registro->destroy();
        return header("location: index.php?classe=RegistroAtendimento&metodo=index");
    }

    public function search() {
        if (isset($_POST['search'])) {

            $codigo = $_POST['search'];
            $consultas = $this->consultaModel->getLike($codigo);
            echo "
            <ul class='sear'>
                <li ><a><strong>Código de Agendamento</strong></a></li>";
                if(empty($consultas)) {
                    echo "<li onclick=\"fill_codigo_agendamento('')\" ><a>Nenhum Código de agendamento encontrado</a></li>";
                } else {
                    foreach ($consultas as $consulta) {
                        echo "<li onclick=\"fill_codigo_agendamento('".$consulta->getCodigo()."')\">
                            <a>".$consulta->getCodigo()."</a>
                        </li>";
                    }
                }
            echo "</ul>";
        }
        

    }



}
?>

