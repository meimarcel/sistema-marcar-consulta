<?php
    include_once 'base/header.php';
    include_once 'base/mensagem.php';
    $registro = $_REQUEST['registro'];
    session_unset();
?>

<div class="row">
    <div>
        <h3 > Registro de Atendimento </h3>
            <div class="mg-top" >
                <label><strong>Código de Atendimento: </strong><?php echo $registro->getCodigo_agendamento();?></label>
            </div>
            <div class="mg-top" >
                <label><strong>Situação: </strong><?php echo $registro->getSituacao();?></label>
            </div>
            <div class="mg-top" >
                <label><strong>Data efetiva do atendimento: </strong><?php echo ($registro->getData_efetiva_atendimento() == null)? "-":date_format(date_create($registro->getData_efetiva_atendimento()), "d/m/Y"); ?></label>
            </div>

            <div class="mg-top">
                <label><strong>Observação: </strong><?php echo ($registro->getObs() == null)? "-":$registro->getObs(); ?></label>
            </div>

            <div class="mg-t">
                <a href="index.php?classe=RegistroAtendimento&metodo=index" class="btn-voltar"> Voltar</a>
            </div>
    </div>
</div>

<?php
include_once 'base/footer.php';
?>
