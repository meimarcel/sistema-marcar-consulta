<?php
include_once 'base/header.php';
include_once 'base/mensagem.php';
?>

<div class="row">
    <div >
        <h3> Novo Paciente </h3>
        <form action="index.php" method="POST">
            <input type="hidden" name="classe" value="Paciente" />  
            <input type="hidden" name="metodo" value="save" />  
            <div class="mg-top" >
                <label for="nome">Nome <span class="obrigatorio">*</span></label>
                <input type="text" autocomplete="off" name="nome" id="nome" <?php if(isset($_SESSION['nome'])) echo "value='".$_SESSION['nome']."'";?>/>  
            </div>
            <div class="mg-top" >
                <label for="cartao_sus">Cartão SUS <span class="obrigatorio">*</span></label>
                <input type="text" name="cartao_sus" autocomplete="off" maxlength="15" id="cartao_sus"<?php if(isset($_SESSION['cartao_sus'])) echo "value='".$_SESSION['cartao_sus']."'";?> />  
            </div>
            <div class="mg-top" >
                <label for="data_nascimento">Data de nascimento <span class="obrigatorio">*</span></label>
                <input type="date" name="data_nascimento" id="data_nascimento" <?php if(isset($_SESSION['data_nascimento'])) echo "value='".$_SESSION['data_nascimento']."'";?>/>  
            </div>

            <div class="mg-top">
                <label for="idade">Idade <span class="obrigatorio">*</span></label>
                <input type="text" name="idade" autocomplete="off" id="idade" <?php if(isset($_SESSION['idade'])) echo "value='".$_SESSION['idade']."'";?>/>
            </div>

            <div class="mg-top">
                <label for="sexo">Sexo <span class="obrigatorio">*</span></label>
                <select name="sexo" id="sexo">
                    <option value="<?php if(isset($_SESSION['sexo'])) echo $_SESSION['sexo'];?>" selected="<?php if(isset($_SESSION['sexo'])) echo $_SESSION['sexo']; else echo "selected"?>" <?php if(isset($_SESSION['sexo'])){ echo ($_SESSION['sexo'] != "")? "hidden":"";}?>><?php if(isset($_SESSION['sexo'])) {echo ($_SESSION['sexo'] == "")? "-":$_SESSION['sexo'];} else echo "-"?></option>
                    <option value="M">M</option>
                    <option value="F">F</option>
                </select>
            </div>

            <div class="mg-top">
                <label for="endereco">Endereco</label>
                <input type="text" name="endereco" autocomplete="off" id="endereco" <?php if(isset($_SESSION['endereco'])) echo "value='".$_SESSION['endereco']."'";?>/>
            </div>


            <input type="submit" name="btn_cadastrar" value="Cadastrar"/>
            <a href="index.php?classe=Paciente&metodo=index" class="btn-voltar"> Voltar</a>
        </form>
    </div>
</div>

<?php
include_once 'base/footer.php';
?>
