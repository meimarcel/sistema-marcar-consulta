<?php 
    include_once 'base/header.php';
    include_once 'base/mensagem.php';
    $medico = $_REQUEST['medico'];
    session_unset();
?>

<div class="row">
    <div>
        <h3> Médico </h3>

            <div class="mg-top">
                <label for="cpf"><strong>CPF: </strong><?php echo $medico->getCpf();?></label>
            </div>
            <div class="mg-top">
                <label><strong>Nome: </strong><?php echo $medico->getNome();?></label>
            </div>

            
            <div class="mg-t">
                <a href="index.php?classe=Medico&metodo=index" class="btn-voltar"> Voltar</a>
            </div>
    </div>
</div>


<?php
include_once 'base/footer.php';
?>