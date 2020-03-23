<?php
include_once 'base/header.php';
include_once 'base/mensagem.php';
?>

<div class="row">
    <div >
        <h3> Novo Médico </h3>
        <form action="index.php" method="POST">
            <input type="hidden" autocomplete="off" name="classe" value="Medico" /> 
            <input type="hidden" autocomplete="off" name="metodo" value="save" /> 
            <div class="mg-top">
                <label for="cpf">CPF <span class="obrigatorio">*</span></label>
                <input type="text" autocomplete="off" name="cpf" maxlength="11" id="cpf" <?php if(isset($_SESSION['cpf'])) echo "value='".$_SESSION['cpf']."'";?>/>
            </div>
            
            <div class="mg-top" >
                <label for="nome">Nome <span class="obrigatorio">*</span></label>
                <input type="text" autocomplete="off" name="nome" id="nome" <?php if(isset($_SESSION['nome'])) echo "value='".$_SESSION['nome']."'";?>/>  
            </div>

            

            <input type="submit" name="btn_cadastrar" value="Cadastrar"/>
            <a href="index.php?classe=Medico&metodo=index" class="btn-voltar"> Voltar</a>
        </form>
    </div>
</div>

<?php
include_once 'base/footer.php';
?>
