<?php
    include_once 'base/header.php';
    include_once 'base/mensagem.php';
    $medico = $_REQUEST['medico'];
    session_unset();
?>

<div class="row">
    <div>
        <h3 class="light"> Editar Médico </h3>
        <form action="index.php" method="POST">
            <input type="hidden" name='classe' value='Medico'/>
            <input type="hidden" name='metodo' value='update'/>
            <div class="mg-top">
                <label for="cpf">CPF <span class="obrigatorio">*</span></label>
                <input type="text" name="cpf" autocomplete="off" id="cpf" maxlength="11" value='<?php echo  $medico->getCpf();?>' readonly/>
            </div>
            <div class="mg-top">
                <label for="nome">Nome <span class="obrigatorio">*</span></label>
                <input type="text" name="nome" autocomplete="off" id="nome"  value='<?php echo $medico->getNome();?>'/> 
            </div>
            <input type="submit" name="btn_atualizar" value="Atualizar" class="btn_cadastrar" />
            <a href="index.php?classe=Medico&metodo=index" class="btn-voltar"> Voltar</a>
        </form>
    </div>
</div>

<?php
include_once 'base/footer.php';
?>
