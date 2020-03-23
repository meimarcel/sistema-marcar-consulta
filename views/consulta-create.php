<?php
include_once 'base/header.php';
include_once 'base/mensagem.php';
$procedimentos = $_REQUEST['procedimentos'];

?>

<div class="row">
    <div >
        <h3> Nova Consulta </h3>
        <form action="index.php" method="POST">
            <input type="hidden" name="classe"  value="Consulta"/>
            <input type="hidden" name="metodo"  value="save"/>
            <div class="mg-top" >
                <label for="paciente">Paciente <span class="obrigatorio">*</span></label>
                <input type="text"  name="paciente-view" autocomplete="off" id="search-paciente" <?php if(isset($_SESSION['paciente_view'])) echo "value='".$_SESSION['paciente_view']."'";?>/>
                <input type="hidden" name="paciente" id="search-paciente-hidden" value="<?php if(isset($_SESSION['paciente'])) echo $_SESSION['paciente']; else echo "-1";?>"/>  
                <div id="mostra-paciente"></div>
            </div>
            <div class="mg-top" >
                <label for="procedimento">Procedimeto<span class="obrigatorio">*</span></label>
                <select name="procedimento" id="procedimento">
                    <option value="<?php if(isset($_SESSION['procedimento_codigo'])) echo $_SESSION['procedimento_codigo'];?>"<?php if(isset($_SESSION['precedimento_codigo'])){ echo ($_SESSION['procedimento_codigo'] != "")? "hidden":"";}?> selected="<?php if(isset($_SESSION['procedimento_codigo'])) echo $_SESSION['procedimento_codigo']; else echo"selected"?>"><?php if(isset($_SESSION['procedimento_nome'])) {echo ($_SESSION['procedimento_nome'] == "")? "-":$_SESSION['procedimento_nome']; }else echo "-";?></option>
                    <?php foreach($procedimentos as $procedimento) { 
                        echo "<option value=\"".$procedimento->getCodigo()."\">#".$procedimento->getCodigo()." ".$procedimento->getNome()."</option>";
                    }?>
                </select> 
            </div>
            <div class="mg-top">
                <label for="medico">Médico <span class="obrigatorio">*</span></label>
                <input type="text" name="medico_view" autocomplete="off" id="search-medico" <?php if(isset($_SESSION['medico_view'])) echo "value='".$_SESSION['medico_view']."'";?>/>
                <input type="hidden" name="medico" id="search-medico-hidden" value="<?php if(isset($_SESSION['medico'])) echo $_SESSION['medico']; else echo "-1";?>"/>  
                <div id="mostra-medico"></div>
            </div>
            <div class="mg-top" >
                <label for="data_atendimento">Data da consulta <span class="obrigatorio">*</span></label>
                <input type="date" name="data_atendimento" id="data_atendimento" <?php if(isset($_SESSION['data_atendimento'])) echo "value='".$_SESSION['data_atendimento']."'";?>/>
            </div>

            <input type="submit" name="btn_cadastrar" value="Cadastrar"/>
            <a href="index.php?classe=Consulta&metodo=index" class="btn-voltar"> Voltar</a>
        </form>
    </div>
</div>

<?php

include_once 'base/footer.php';
?>
