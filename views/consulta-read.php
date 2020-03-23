<?php
include_once 'base/header.php';
include_once 'base/mensagem.php';
$consulta = $_REQUEST['consulta'];
session_unset();
?>

<div class="row">
    <div>
        <h3> Consulta </h3>
            
            <div class="mg-top" >
                <label><strong>Código: </strong> <?php echo $consulta->getCodigo();?></label>
            </div>
            <div class="mg-top" >
                <label><strong>Paciente: </strong> <?php echo $consulta->getPaciente()->getNome();?></label>
                <div id="mostra-paciente"></div>
            </div>
            <div class="mg-top" >
                <label><strong>Procedimeto: </strong> <?php echo $consulta->getProcedimento()->getNome();?></label>
            </div>
            <div class="mg-top">
                <label><strong>Médico: </strong> <?php echo $consulta->getMedico()->getNome();?></label>
            </div>
            <div class="mg-top" >
                <label><strong>Data da consulta: </strong><?php echo date_format(date_create($consulta->getData_atendimento()), "d/m/Y");?></label>
            </div>
            <div class="mg-t">
                <a href="index.php?classe=Consulta&metodo=index" class="btn-voltar"> Voltar</a>
            </div>

    </div>
</div>

<?php

include_once 'base/footer.php';
?>
