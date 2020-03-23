<?php
    include_once 'base/header.php';
    include_once 'base/mensagem.php';
    $procedimento = $_REQUEST['procedimento'];
    session_unset();
?>

<div class="row">
    <div>
        <h3 class="light"> Editar Procedimento </h3>
        <form action="index.php" method="POST">
            <input type="hidden" name='classe' value='Procedimento'/>
            <input type="hidden" name='metodo' value='update'/>
            <div class="mg-top" >
                <label for="codigo">Codigo <span class="obrigatorio">*</span></label>
                <input type="text" name="codigo" autocomplete="off" id="codigo" value='<?php echo $procedimento->getCodigo();?>' readonly/>  
            </div>
            <div class="mg-top" >
                <label for="nome">Nome <span class="obrigatorio">*</span></label>
                <input type="text" name="nome" autocomplete="off" id="nome" value='<?php echo $procedimento->getNome();?>'/>  
            </div>
            <div class="mg-top" >
                <label for="idade_minima">Idade Mínima <span class="obrigatorio">*</span></label>
                <input type="text" name="idade_minima" id="idade_minima" value='<?php echo $procedimento->getIdade_minima();?>'/>  
            </div>

            <div class="mg-top">
                <label for="idade_maxima">Idade Máxima<span class="obrigatorio">*</span></label>
                <input type="text" name="idade_maxima" id="idade_maxima" autocomplete="off" value='<?php echo $procedimento->getIdade_maxima();?>'/>
            </div>

            <div class="mg-top">
                <label for="sexo">Sexo <span class="obrigatorio">*</span></label>
                <select name="sexo" id="sexo">
                    <option selected="<?php echo $procedimento->getSexo();?>" hidden><?php echo $procedimento->getSexo();?></option>
                    <option value="M">M</option>
                    <option value="F">F</option>
                    <option value="A">A</option>
                </select>
            </div>

            <input type="submit" name="btn_atualizar" value="Atualizar" class="btn_cadastrar" />
            <a href="index.php?classe=Procedimento&metodo=index" class="btn-voltar"> Voltar</a>
        </form>
    </div>
</div>

<?php
include_once 'base/footer.php';
?>
