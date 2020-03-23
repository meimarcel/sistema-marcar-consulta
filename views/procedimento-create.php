<?php
include_once 'base/header.php';
include_once 'base/mensagem.php';
?>

<div class="row">
    <div >
        <h3> Novo Procedimento </h3>
        <form action="index.php" method="POST">
            <input type="hidden" name="classe" value="Procedimento" />  
            <input type="hidden" name="metodo" value="save" />  
            <div class="mg-top" >
                <label for="codigo">Codigo <span class="obrigatorio">*</span></label>
                <input type="text" autocomplete="off" maxlength="9" name="codigo" id="codigo" <?php if(isset($_SESSION['codigo'])) echo "value='".$_SESSION['codigo']."'";?>/>  
            </div>
            <div class="mg-top" >
                <label for="nome">Nome <span class="obrigatorio">*</span></label>
                <input type="text" name="nome" autocomplete="off" id="nome" <?php if(isset($_SESSION['nome'])) echo "value='".$_SESSION['nome']."'";?>/>  
            </div>
            <div class="mg-top" >
                <label for="idade_minima">Idade Mínima <span class="obrigatorio">*</span></label>
                <input type="text" name="idade_minima" id="idade_minima" <?php if(isset($_SESSION['idade_minima'])) echo "value='".$_SESSION['idade_minima']."'";?>/>  
            </div>

            <div class="mg-top">
                <label for="idade_maxima">Idade Máxima <span class="obrigatorio">*</span></label>
                <input type="text" name="idade_maxima" autocomplete="off" id="idade_maxima" <?php if(isset($_SESSION['idade_maxima'])) echo "value='".$_SESSION['idade_maxima']."'";?> />
            </div>

            <div class="mg-top">
                <label for="sexo">Sexo <span class="obrigatorio">*</span></label>
                <select name="sexo" id="sexo">
                    <option value="<?php if(isset($_SESSION['sexo'])) echo $_SESSION['sexo'];?>" selected="<?php if(isset($_SESSION['nome'])) echo $_SESSION['nome']; else echo "selected"?>" <?php if(isset($_SESSION['sexo'])){ echo ($_SESSION['sexo'] != "")? "hidden":"";}?>><?php if(isset($_SESSION['sexo'])){ echo ($_SESSION['sexo'] == "")? "-":$_SESSION['sexo'];} else echo "-"?></option>
                    <option value="M">M</option>
                    <option value="F">F</option>
                    <option value="A">A</option>
                </select>
            </div>

            <input type="submit" name="btn_cadastrar" value="Cadastrar"/>
            <a href="index.php?classe=Procedimento&metodo=index" class="btn-voltar"> Voltar</a>
        </form>
    </div>
</div>

<?php
include_once 'base/footer.php';
?>
