<?php 
// require_once 'utils/db_connection.php';
// require_once 'utils/util.php';
// require_once 'model/Procedimento.php';

class ProcedimentoController {

    private $DB;
    private $util;
    private $procedimentoModel;

    public function __construct() {
        $this->DB = new DataBase();
        $this->util = new Utils();
        $this->procedimentoModel = new Procedimento();

    }

    public function index() {
        $procedimentos = $this->procedimentoModel->listAll();
        $_REQUEST['procedimentos'] = $procedimentos;
        require_once "views/procedimento-menu.php";
    }


    public function create() {
        require_once "views/procedimento-create.php";
    }

    public function editar() {
        $procedimento = $this->procedimentoModel->getByCodigo($_GET['codigo']);
        $_REQUEST['procedimento'] = $procedimento;
        require_once "views/procedimento-editar.php";
    }

    public function read() {
        $procedimento = $this->procedimentoModel->getByCodigo($_GET['codigo']);
        $_REQUEST['procedimento'] = $procedimento;
        require_once "views/procedimento-read.php";
    }

    public function save() {
        $this->DB->connect();
        $codigo = $this->DB->protect($_POST['codigo']);
        $nome = $this->DB->protect($_POST['nome']);
        $idade_minima = $this->DB->protect($_POST['idade_minima']);
        $idade_maxima = $this->DB->protect($_POST['idade_maxima']);
        $sexo = $this->DB->protect($_POST['sexo']);
        $this->DB->close();
        $_SESSION['codigo'] = $codigo;
        $_SESSION['nome'] = $nome;
        $_SESSION['idade_minima'] = $idade_minima;
        $_SESSION['idade_maxima'] = $idade_maxima;
        $_SESSION['sexo'] = $sexo;
    
        if(!$this->util->isCodigo($codigo)) {
            $_SESSION['mensagem'] = "Codigo iválido";
            $_SESSION['codigo'] = "";
            return header("location: index.php?classe=Procedimento&metodo=create");
        }
        else if(!$this->util->strNoEmptyOrNull($nome)) {
            $_SESSION['mensagem'] = "Campo nome vazio";
            return header("location: index.php?classe=Procedimento&metodo=create");
        }
        else if(!$this->util->strNoEmptyOrNull($idade_minima) || !$this->util->isIdade($idade_minima)){
            $_SESSION['mensagem'] = "Idada mínima invalida ou em branco";
            $_SESSION['idade_minima'] = "";
            return header("location: index.php?classe=Procedimento&metodo=create");
        }
        else if(!$this->util->strNoEmptyOrNull($idade_maxima) || !$this->util->isIdade($idade_maxima)){
            $_SESSION['mensagem'] = "Idada máxima invalida ou em branco";
            $_SESSION['idade_maxima'] = "";
            return header("location: index.php?classe=Procedimento&metodo=create");
        }
        else if(!$this->util->strNoEmptyOrNull($sexo)){
            $_SESSION['mensagem'] = "Sexo não informado";
            return header("location: index.php?classe=Procedimento&metodo=create");
        }
        else if(intval($idade_minima) > intval($idade_maxima)) {
            $_SESSION['mensagem'] = "Idade mínima maior que a idade máxima";
            return header("location: index.php?classe=Procedimento&metodo=create");
        } else {
            $procedimento = new Procedimento();
            $procedimento->fill($codigo, $nome,$idade_minima,$idade_maxima,$sexo);
            $_SESSION['mensagem'] = $procedimento->save();
            if($_SESSION['mensagem'] == "JA_CADASTRADO") {
                $_SESSION['mensagem'] = "Código já cadastrado";
                return header("location: index.php?classe=Procedimento&metodo=create");
            }
            return header("location: index.php?classe=Procedimento&metodo=index");
        
        }
    }

    public function update() {
        $this->DB->connect();
        $codigo = $this->DB->protect($_POST['codigo']);
        $nome = $this->DB->protect($_POST['nome']);
        $idade_minima = $this->DB->protect($_POST['idade_minima']);
        $idade_maxima = $this->DB->protect($_POST['idade_maxima']);
        $sexo = $this->DB->protect($_POST['sexo']);
        $this->DB->close();
        
        if(!$this->util->isCodigo($codigo)) {
            $_SESSION['mensagem'] = "Codigo iválido";
            return header("location: index.php?classe=Procedimento&metodo=editar&codigo=".$codigo);
        }
        else if(!$this->util->strNoEmptyOrNull($nome)) {
            $_SESSION['mensagem'] = "Campo nome vazio";
            return header("location: index.php?classe=Procedimento&metodo=editar&codigo=".$codigo);
        }
        else if(!$this->util->strNoEmptyOrNull($idade_minima) || !$this->util->isIdade($idade_minima)){
            $_SESSION['mensagem'] = "Idada mínima invalida ou em branco";
            return header("location: index.php?classe=Procedimento&metodo=editar&codigo=".$codigo);
        }
        else if(!$this->util->strNoEmptyOrNull($idade_maxima) || !$this->util->isIdade($idade_maxima)){
            $_SESSION['mensagem'] = "Idada máxima invalida ou em branco";
            return header("location: index.php?classe=Procedimento&metodo=editar&codigo=".$codigo);
        }
        else if(!$this->util->strNoEmptyOrNull($sexo)){
            $_SESSION['mensagem'] = "Sexo não informado";
            return header("location: index.php?classe=Procedimento&metodo=editar&codigo=".$codigo);
        } 
        else if(intval($idade_minima) > intval($idade_maxima)) {
            $_SESSION['mensagem'] = "Idade mínima maior que a idade máxima";
            return header("location: index.php?classe=Procedimento&metodo=editar&codigo=".$codigo);
        } else {
            $procedimento = $this->procedimentoModel->getByCodigo($codigo);
            $procedimento->setNome($nome);
            $procedimento->setIdade_minima($idade_minima);
            $procedimento->setIdade_maxima($idade_maxima);
            $procedimento->setSexo($sexo);
            $_SESSION['mensagem'] = $procedimento->update();
            if($_SESSION['mensagem'] == "JA_CADASTRADO") {
                $_SESSION['mensagem'] = "Código já cadastrado";
                return header("location: index.php?classe=Procedimento&metodo=editar&codigo=".$codigo);
            }
            return header("location: index.php?classe=Procedimento&metodo=index");
        
        }
    }

    public function delete() {
        $procedimento = $this->procedimentoModel->getByCodigo($_POST['codigo']);
        $_SESSION['mensagem'] = $procedimento->destroy();
        return header("location: index.php?classe=Procedimento&metodo=index");
    }


}

?>