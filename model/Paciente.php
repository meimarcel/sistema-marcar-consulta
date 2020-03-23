<?php
class Paciente {

    private $id;
    private $nome;
    private $cartao_sus;
    private $data_nascimento;
    private $idade;
    private $sexo;
    private $endereco;
    private $DB;

    public function __construct() {
        $this->DB = new DataBase();   
    }

    public function fill($nome, $cartao_sus, $data_nascimento, $idade, $sexo, $endereco) {
        $this->nome = $nome;
        $this->cartao_sus = $cartao_sus;
        $this->data_nascimento = $data_nascimento;
        $this->idade = $idade;
        $this->sexo = $sexo;
        $this->endereco = $endereco;
    }

    public function getId() {
        return $this->id;
    }

    private function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getCartao_sus() {
        return $this->cartao_sus;
    }
    public function setCartao_sus($cartao_sus) {
        $this->cartao_sus = $cartao_sus;
    }
    public function getData_nascimento() {
        return $this->data_nascimento;
    }
    public function setData_nascimento($data_nascimento) {
        $this->data_nascimento = $data_nascimento;
    }
    public function getIdade() {
        return $this->idade;
    }
    public function setIdade($idade) {
        $this->idade = $idade;
    }
    public function getSexo() {
        return $this->sexo;
    }
    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }
    public function getEndereco() {
        return $this->endereco;
    }
    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }


    public function save() {
        $this->DB->connect();
        $sql = "SELECT * FROM paciente WHERE cartao_sus = '$this->cartao_sus';";
        $resultado = mysqli_query($this->DB->connection, $sql);
        if(mysqli_num_rows($resultado) > 0) {
            return "JA_CADASTRADO";
        }
        $sql = "INSERT INTO paciente(nome, cartao_sus, data_nascimento, idade, sexo, endereco) VALUES ('$this->nome', '$this->cartao_sus', '$this->data_nascimento', '$this->idade', '$this->sexo', '$this->endereco');";
        if(mysqli_query($this->DB->connection, $sql)) {
            $this->DB->close();
            return "Paciente cadastrado com sucesso";
        } else {
            $this->DB->close();
            return "Erro ao cadastrar";
        }
        
    }

    public function update() {
        $this->DB->connect();
        $sql = "SELECT * FROM paciente WHERE cartao_sus = '$this->cartao_sus' AND id != '$this->id';";
        $resultado = mysqli_query($this->DB->connection, $sql);
        if(mysqli_num_rows($resultado) > 0) {
            return "JA_CADASTRADO";
        }
        $sql = "UPDATE paciente SET nome='$this->nome', cartao_sus='$this->cartao_sus', data_nascimento='$this->data_nascimento', idade='$this->idade', sexo='$this->sexo', endereco='$this->endereco' WHERE id = '$this->id';";
        if(mysqli_query($this->DB->connection, $sql)) {
            $this->DB->close();
            return "Paciente atualizado com sucesso";
        } else {
            $this->DB->close();
            return "Erro ao atualizar";
        }
        
    }

    public function destroy() {
        $this->DB->connect();
        $sql = "DELETE FROM paciente WHERE id = '$this->id';";

        if(mysqli_query($this->DB->connection, $sql)) {
            $this->DB->close();
            return "Paciente deletado com sucesso!";  
        } else {
            $error = mysqli_errno($this->DB->connection);
            $this->DB->close();
            if($error == "1451") {
                $error = "Não foi possível deletar: ESTE PACIENTE PERTENCE A UMA CONSULTA";
            } else {
                $error = "Erro ao deletar";
            }
            return $error;
        }
        
    }

    public function listAll() {
        $this->DB->connect();
        $sql = "SELECT * FROM paciente ORDER BY nome;";
        $resultado = mysqli_query($this->DB->connection, $sql);

        $pacientes = [];
        if(mysqli_num_rows($resultado) > 0) {
            while($dados = mysqli_fetch_array($resultado)) {
                $paciente = new Paciente();
                $paciente->fill($dados['nome'],$dados['cartao_sus'],$dados['data_nascimento'],$dados['idade'],$dados['sexo'],$dados['endereco']);
                $paciente->setId($dados['id']);
                $pacientes[] = $paciente;
            }
        }
        $this->DB->close();
        return $pacientes;
    }

    public function getById($id) {
        $this->DB->connect();
        $sql = "SELECT * FROM paciente WHERE id = '$id'";
        $resultado = mysqli_query($this->DB->connection, $sql);
        if(mysqli_num_rows($resultado) > 0) {
            $dados = mysqli_fetch_array($resultado);
            $paciente = new Paciente();
            $paciente->fill($dados['nome'],$dados['cartao_sus'],$dados['data_nascimento'],$dados['idade'],$dados['sexo'],$dados['endereco']);
            $paciente->setId($dados['id']);
            $this->DB->close();
            return $paciente; 
        } else {
            $this->DB->close();
            return null;
        }
    }

    public function getByIdAndNome($id, $nome) {
        $this->DB->connect();
        $sql = "SELECT * FROM paciente WHERE id = '$id'AND nome = '$nome';";;
        $resultado = mysqli_query($this->DB->connection, $sql);
        if(mysqli_num_rows($resultado) > 0) {
            $dados = mysqli_fetch_array($resultado);
            $paciente = new Paciente();
            $paciente->fill($dados['nome'],$dados['cartao_sus'],$dados['data_nascimento'],$dados['idade'],$dados['sexo'],$dados['endereco']);
            $paciente->setId($dados['id']);
            $this->DB->close();
            return $paciente; 
        } else {
            $this->DB->close();
            return null;
        }
    }

    public function getLike($nome) {
        $this->DB->connect();
        $sql = "SELECT * FROM paciente WHERE nome LIKE '%$nome%' ORDER BY nome;";
        $resultado = mysqli_query($this->DB->connection, $sql);
        $pacientes = [];
        if(mysqli_num_rows($resultado) > 0) {
            while($dados = mysqli_fetch_array($resultado)) {
                $paciente = new Paciente();
                $paciente->fill($dados['nome'],$dados['cartao_sus'],$dados['data_nascimento'],$dados['idade'],$dados['sexo'],$dados['endereco']);
                $paciente->setId($dados['id']);
                $pacientes[] = $paciente; 
            }
        }
        $this->DB->close();
        return $pacientes;
    }


 




}


?>