<?php 
// require_once 'utils/db_connection.php';
// require_once 'utils/util.php';
// require_once 'model/Medico.php';
// require_once "config/autoload.php";

class MedicoController {
    private $DB;
    private $util;
    private $medicoModel;
    public function __construct() {
        $this->DB = new DataBase();
        $this->util = new Utils();
        $this->medicoModel = new Medico();
    }

    public function index() {
        $medicos = $this->medicoModel->listAll();
        $_REQUEST['medicos'] = $medicos;
        require_once "views/medico-menu.php";
    }


    public function create() {
        require_once "views/medico-create.php";
    }

    public function editar() {
        $medico = $this->medicoModel->getByCpf($_GET['cpf']);
        $_REQUEST['medico'] = $medico;
        require_once "views/medico-editar.php";
    }

    public function read() {
        $medico = $this->medicoModel->getByCpf($_GET['cpf']);
        $_REQUEST['medico'] = $medico;
        require_once "views/medico-read.php";
    }

    public function save() {
        $this->DB->connect();
        $nome = $this->DB->protect($_POST['nome']);
        $cpf = $this->DB->protect($_POST['cpf']);
        $this->DB->close();
        $_SESSION['nome'] = $nome;
        $_SESSION['cpf'] = $cpf;
    
        if(!$this->util->isCPF($cpf)) {
            $_SESSION['mensagem'] = "CPF iválido";
            $_SESSION['cpf'] = $cpf;
            return header('location: index.php?classe=Medico&metodo=create');
        }

        else if(!$this->util->strNoEmptyOrNull($nome)) {
            $_SESSION['mensagem'] = "Campo nome vazio";
            return header('location: index.php?classe=Medico&metodo=create');
        } else {
            $medico = new Medico();
            $medico->fill($cpf, $nome);
            $_SESSION['mensagem'] = $medico->save();
            if($_SESSION['mensagem'] == "JA_CADASTRADO") {
                $_SESSION['mensagem'] = "Cpf já cadastrado";
                return header('location: index.php?classe=Medico&metodo=create');
            }
            return header("location: index.php?classe=Medico&metodo=index");
        
        }
    }

    public function update() {
        $this->DB->connect();
        $nome = $this->DB->protect($_POST['nome']);
        $cpf = $this->DB->protect($_POST['cpf']);
        $this->DB->close();
        
        if(!$this->util->strNoEmptyOrNull($nome)) {
            $_SESSION['mensagem'] = "Campo nome vazio";
            return header('location: index.php?classe=Medico&metodo=editar&cpf='.$cpf);
        }
        else if(!$this->util->isCPF($cpf)) {
            $_SESSION['mensagem'] = "CPF iválido";
            return header('location: index.php?classe=Medico&metodo=editar&cpf='.$cpf);
        } else {
            $medico = $this->medicoModel->getByCpf($cpf);
            $medico->setNome($nome);
            $_SESSION['mensagem'] = $medico->update();
            return header('location: index.php?classe=Medico&metodo=index');
        
        }
    }

    public function delete() {
        $medico = $this->medicoModel->getByCpf($_POST['cpf']);
        $_SESSION['mensagem'] = $medico->destroy();
        return header("location: index.php?classe=Medico&metodo=index");
    }


}

?>