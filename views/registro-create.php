<?php
include_once 'base/header.php';
include_once 'base/mensagem.php';

?>

<div class="row">
    <div >
        <h3> Novo Registro </h3>
        <form action="index.php" method="POST">
            <input type="hidden" name="classe" value="RegistroAtendimento"/>
            <input type="hidden" name="metodo" value="save"/>
            <div class="mg-top" >
                <label for="codigo_agendamento">Código do Agendamento <span class="obrigatorio">*</span></label>
                <input type="text"  name="codigo_agendamento" autocomplete="off" id="search-codigo_agendamento" <?php if(isset($_SESSION['codigo_agendamento'])) echo "value='".$_SESSION['codigo_agendamento']."'";?>/>
                <div id="mostra-codigo_agendamento"></div>
            </div>
            
            <div class="mg-top">
                <label for="situacao">Situação <span class="obrigatorio">*</span></label>
                <select name="situacao" id="situacao">
                    <option value="<?php if(isset($_SESSION['situacao'])) echo $_SESSION['situacao'];?>" <?php if(isset($_SESSION['situacao'])){ echo ($_SESSION['situacao'] != "")? "hidden":"" ;}?> selected="<?php if(isset($_SESSION['situacao'])) echo $_SESSION['situacao'];?>"><?php if(isset($_SESSION['situacao'])) echo ($_SESSION['situacao'] == "")? "-":$_SESSION['situacao'];?></option>
                    <option value="1-Paciente Atendido">1-Paciente Atendido</option>
                    <option value="2-Paciente Faltou">2-Paciente Faltou</option>
                    <option value="3-Medico Faltou">3-Medico Faltou</option>
                </select> 
            </div>

            <div class="mg-top">
                <label for="data_efetiva_atendimento">Data Efetiva do Atendimento</label>
                <input type="date" name="data_efetiva_atendimento" autocomplete="off" id="data_efetiva_atendimento" <?php if(isset($_SESSION['data_efetiva_atendimento'])) echo "value='".$_SESSION['data_efetiva_atendimento']."'";?>/>
            </div>

            <div class="mg-top" >
                <label for="obs">Observação</label>
                <input type="text" autocomplete="off" name="obs" id="obs" <?php if(isset($_SESSION['obs'])) echo "value='".$_SESSION['obs']."'";?>/>  
            </div>


            <input type="submit" name="btn_cadastrar" value="Cadastrar"/>
            <a href="index.php?classe=RegistroAtendimento&metodo=index" class="btn-voltar"> Voltar</a>
        </form>
    </div>
</div>

<?php
include_once 'base/footer.php';
?>
