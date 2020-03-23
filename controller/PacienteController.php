<?php 
// require_once 'utils/db_connection.php';
// require_once 'utils/util.php';
// require_once 'model/Paciente.php';

class PacienteController {
    private $DB;
    private $util;
    private $pacienteModel;

    public function __construct() {
        $this->DB = new DataBase();
        $this->util = new Utils();
        $this->pacienteModel = new Paciente();
    }

    public function index() {
        $pacientes = $this->pacienteModel->listAll();
        $_REQUEST['pacientes'] = $pacientes;
        require_once "views/paciente-menu.php";
    }


    public function create() {
        require_once "views/paciente-create.php";
    }

    public function editar() {
        $paciente = $this->pacienteModel->getById($_GET['id']);
        $_REQUEST['paciente'] = $paciente;
        require_once "views/paciente-editar.php";
    }

    public function read() {
        $paciente = $this->pacienteModel->getById($_GET['id']);
        $_REQUEST['paciente'] = $paciente;
        require_once "views/paciente-read.php";
    }

    public function save() {
        $this->DB->connect();
        $nome = $this->DB->protect($_POST['nome']);
        $cartao_sus = $this->DB->protect($_POST['cartao_sus']);
        $data_nascimento = $this->DB->protect($_POST['data_nascimento']);
        $idade = $this->DB->protect($_POST['idade']);
        $sexo = $this->DB->protect($_POST['sexo']);
        $endereco = $this->DB->protect($_POST['endereco']);
        $this->DB->close();
        $_SESSION['nome'] = $nome;
        $_SESSION['cartao_sus'] = $cartao_sus;
        $_SESSION['data_nascimento'] = $data_nascimento;
        $_SESSION['idade'] = $idade;
        $_SESSION['sexo'] = $sexo;
        $_SESSION['endereco'] = $endereco;
    
        if(!$this->util->strNoEmptyOrNull($nome)) {
            $_SESSION['mensagem'] = "Campo nome vazio";
            return header("location: index.php?classe=Paciente&metodo=create");
        }
        else if(!$this->util->isSUS($cartao_sus)) {
            $_SESSION['mensagem'] = "Número do SUS iválido";
            $_SESSION['cartao_sus'] = "";
            return header("location: index.php?classe=Paciente&metodo=create");
        }
        else if(!$this->util->strNoEmptyOrNull($data_nascimento)){
            $_SESSION['mensagem'] = "Data de nascimento não informado";
            return header("location: index.php?classe=Paciente&metodo=create");
        }
        else if(!$this->util->strNoEmptyOrNull($idade) || !$this->util->isIdade($idade)){
            $_SESSION['mensagem'] = "Idade não informado ou  inválido";
            $_SESSION['idade'] = "";
            return header("location: index.php?classe=Paciente&metodo=create");
        }
        else if(!$this->util->strNoEmptyOrNull($sexo)){
            $_SESSION['mensagem'] = "Sexo não informado";
            $_SESSION['sexo'] = "";
            return header("location: index.php?classe=Paciente&metodo=create");
        } else {
            if(strtotime($data_nascimento) > strtotime(date_format(date_create(), "Y-m-d"))) {
                $_SESSION['mensagem'] = "Data de nascimento inválido";
                return header("location: index.php?classe=Paciente&metodo=create");
            }
            $paciente = new Paciente();
            $paciente->fill($nome, $cartao_sus,$data_nascimento,$idade,$sexo,$endereco);
            $_SESSION['mensagem'] = $paciente->save();
            if($_SESSION['mensagem'] == "JA_CADASTRADO") {
                $_SESSION['mensagem'] = "Número do SUS já cadastrado";
                return header("location: index.php?classe=Paciente&metodo=create");
            }
            return header("location: index.php?classe=Paciente&metodo=index");
        
        }
    }

    public function update() {
        $this->DB->connect();
        $id = $this->DB->protect($_POST['id']);
        $nome = $this->DB->protect($_POST['nome']);
        $cartao_sus = $this->DB->protect($_POST['cartao_sus']);
        $data_nascimento = $this->DB->protect($_POST['data_nascimento']);
        $idade = $this->DB->protect($_POST['idade']);
        $sexo = $this->DB->protect($_POST['sexo']);
        $endereco = $this->DB->protect($_POST['endereco']);
        $this->DB->close();
        
        if(!$this->util->strNoEmptyOrNull($id)) {
            $_SESSION['mensagem'] = "Paciente não encontrado";
            return header("location: index.php?classe=Paciente&metodo=editar&id=".$id);
        }
        
        if(!$this->util->strNoEmptyOrNull($nome)) {
            $_SESSION['mensagem'] = "Campo nome vazio";
            return header("location: index.php?classe=Paciente&metodo=editar&id=".$id);
        }
        else if(!$this->util->isSUS($cartao_sus)) {
            $_SESSION['mensagem'] = "Número do SUS iválido";
            return header("location: index.php?classe=Paciente&metodo=editar&id=".$id);
        }
        else if(!$this->util->strNoEmptyOrNull($data_nascimento)){
            $_SESSION['mensagem'] = "Data de nascimento não informado";
            return header("location: index.php?classe=Paciente&metodo=editar&id=".$id);
        }
        else if(!$this->util->strNoEmptyOrNull($idade) || !$this->util->isIdade($idade)){
            $_SESSION['mensagem'] = "Idade não informado";
            return header("location: index.php?classe=Paciente&metodo=editar&id=".$id);
        }
        else if(!$this->util->strNoEmptyOrNull($sexo)){
            $_SESSION['mensagem'] = "Sexo não informado";
            return header("location: index.php?classe=Paciente&metodo=editar&id=".$id);
        } else {
            if(strtotime($data_nascimento) > strtotime(date_format(date_create(), "Y-m-d"))) {
                $_SESSION['mensagem'] = "Data de nascimento inválido";
                return header("location: index.php?classe=Paciente&metodo=editar&id=".$id);
            }
            $paciente = $this->pacienteModel->getById($id);
            $paciente->setNome($nome);
            $paciente->setCartao_sus($cartao_sus);
            $paciente->setData_nascimento($data_nascimento);
            $paciente->setIdade($idade);
            $paciente->setSexo($sexo);
            $paciente->setEndereco($endereco);
            $_SESSION['mensagem'] = $paciente->update();
            if($_SESSION['mensagem'] == "JA_CADASTRADO") {
                $_SESSION['mensagem'] = "Número do SUS já cadastrado";
                return header("location: index.php?classe=Paciente&metodo=editar&id=".$id);
            }
            return header("location: index.php?classe=Paciente&metodo=index");
        
        }
    }

    public function delete() {
        $paciente = $this->pacienteModel->getById($_POST['id']);
        $_SESSION['mensagem'] = $paciente->destroy();
        return header("location: index.php?classe=Paciente&metodo=index");
    }


}

?>