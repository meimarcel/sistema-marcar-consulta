<?php
include_once 'base/header.php';
include_once 'base/mensagem.php';
$registro = $_REQUEST["registro"];
session_unset();
?>

<div class="row">
    <div >
        <h3> Novo Registro </h3>
        <form action="index.php" method="POST">
            <input type="hidden" name="classe" value="RegistroAtendimento"/>
            <input type="hidden" name="metodo" value="update"/>
            <input type="hidden" name='id' value='<?php echo $registro->getId();?>'/>
            <div class="mg-top" >
                <label for="codigo_agendamento">Código do Agendamento <span class="obrigatorio">*</span></label>
                <input type="text"  name="codigo_agendamento" autocomplete="off" id="search-codigo_agendamento" value='<?php echo $registro->getCodigo_agendamento();?>' />
                <div id="mostra-codigo_agendamento"></div>
            </div>

            <div class="mg-top">
                <label for="situacao">Situação <span class="obrigatorio">*</span></label>
                <select name="situacao" id="situacao">
                    <option value="<?php echo $registro->getSituacao();?>" selected="<?php echo $registro->getSituacao();?>" hidden><?php echo $registro->getSituacao();?></option>
                    <option value="1-Paciente Atendido">1-Paciente Atendido</option>
                    <option value="2-Paciente Faltou">2-Paciente Faltou</option>
                    <option value="3-Medico Faltou">3-Medico Faltou</option>
                </select> 
            </div>

            <div class="mg-top">
                <label for="data_efetiva_atendimento">Data Efetiva do Atendimento</label>
                <input type="date" name="data_efetiva_atendimento" autocomplete="off" id="data_efetiva_atendimento" value='<?php echo $registro->getData_efetiva_atendimento();?>'/>
            </div>

            <div class="mg-top" >
                <label for="obs">Observação</label>
                <input type="text" autocomplete="off" name="obs" id="obs" value='<?php echo $registro->getObs();?>'/>  
            </div>


            <input type="submit" name="btn_atualizar" value="Atualizar"/>
            <a href="index.php?classe=RegistroAtendimento&metodo=index" class="btn-voltar"> Voltar</a>
        </form>
    </div>
</div>

<?php
include_once 'base/footer.php';
?>
