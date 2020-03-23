<?php
include_once 'base/header.php';
include_once 'base/mensagem.php';
$procedimentos = $_REQUEST['procedimentos'];
$consulta = $_REQUEST['consulta'];
session_unset();
?>

<div class="row">
    <div>
        <h3> Editar Consulta </h3>
        <form action="index.php" method="POST">
            <input type="hidden" name='classe' value='Consulta'/>
            <input type="hidden" name='metodo' value='update'/>
            <div class="mg-top" >
                <label for="codigo">Código <span class="obrigatorio">*</span></label>
                <input type='text'  name="codigo" id="codigo" value='<?php echo $consulta->getCodigo();?>' readonly/>
            </div>
            <div class="mg-top" >
                <label for="paciente">Paciente <span class="obrigatorio">*</span></label>
                <input type="text" name="paciente-view" autocomplete="off" id="search-paciente" value='<?php echo $consulta->getPaciente()->getNome();?>'/>
                <input type="hidden" name="paciente" id="search-paciente-hidden" value='<?php echo $consulta->getPaciente()->getId();?>'/>  
                <div id="mostra-paciente"></div>
            </div>
            <div class="mg-top" >
                <label for="procedimento">Procedimeto <span class="obrigatorio">*</span></label>
                <select name="procedimento" id="procedimento">
                    <option value="<?php echo $consulta->getProcedimento()->getCodigo();?>" selected="<?php echo $consulta->getProcedimento()->getCodigo();?>" hidden><?php echo $consulta->getProcedimento()->getNome();?></option>
                    <?php foreach($procedimentos as $procedimento) { 
                        echo "<option value=\"".$procedimento->getCodigo()."\">#".$procedimento->getCodigo()." ".$procedimento->getNome()."</option>";
                    }?>
                </select> 
            </div>
            <div class="mg-top">
                <label for="medico">Médico <span class="obrigatorio">*</span></label>
                <input type="text" name="medico_view" autocomplete="off" id="search-medico" value='<?php echo $consulta->getMedico()->getNome();?>' />
                <input type="hidden" name="medico" id="search-medico-hidden" value='<?php echo $consulta->getMedico()->getCpf();?>'/>  
                <div id="mostra-medico"></div>
            </div>
            <div class="mg-top" >
                <label for="data_atendimento">Data da consulta <span class="obrigatorio">*</span></label>
                <input type="date" name="data_atendimento" id="data_atendimento" value='<?php echo $consulta->getData_atendimento();?>'/>
                <input type="hidden" name="data_atendimento_atual" id="data_atendimento" value='<?php echo $consulta->getData_atendimento();?>'/>
            </div>

            <input type="submit" name="btn_atualizar" value="Atualizar"/>
            <a href="index.php?classe=Consulta&metodo=index" class="btn-voltar"> Voltar</a>
        </form>
    </div>
</div>

<?php

include_once 'base/footer.php';
?>
