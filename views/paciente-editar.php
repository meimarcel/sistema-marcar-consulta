<?php
    include_once 'base/header.php';
    include_once 'base/mensagem.php';
    $paciente = $_REQUEST['paciente'];
    session_unset();
?>

<div class="row">
    <div>
        <h3 class="light"> Editar Paciente </h3>
        <form action="index.php" method="POST">
            <input type="hidden" name='id' value='<?php echo $paciente->getId();?>'/>
            <input type="hidden" name='classe' value='Paciente'/>
            <input type="hidden" name='metodo' value='update'/>
            <div class="mg-top" >
                <label for="nome">Nome <span class="obrigatorio">*</span></label>
                <input type="text" name="nome" autocomplete="off" id="nome" value='<?php echo $paciente->getNome();?>' />  
            </div>
            <div class="mg-top" >
                <label for="cartao_sus">Cartão SUS <span class="obrigatorio">*</span></label>
                <input type="text" name="cartao_sus" autocomplete="off" maxlength="15" id="cartao_sus" value='<?php echo $paciente->getCartao_sus();?>'/>  
            </div>
            <div class="mg-top" >
                <label for="data_nascimento">Data de nascimento <span class="obrigatorio">*</span></label>
                <input type="date" name="data_nascimento" id="data_nascimento" value='<?php echo $paciente->getData_nascimento();?>'/>  
            </div>

            <div class="mg-top">
                <label for="idade">Idade <span class="obrigatorio">*</span></label>
                <input type="text" name="idade" id="idade" autocomplete="off" value='<?php echo $paciente->getIdade();?>'/>
            </div>

            <div class="mg-top">
                <label for="sexo">Sexo <span class="obrigatorio">*</span></label>
                <select name="sexo" id="sexo">
                    <option selected="<?php echo $paciente->getSexo();?>" hidden><?php echo $paciente->getSexo();?></option>
                    <option value="M">M</option>
                    <option value="F">F</option>
                </select>
            </div>

            <div class="mg-top">
                <label for="endereco">Endereco</label>
                <input type="text" name="endereco" id="endereco" autocomplete="off" value='<?php echo $paciente->getEndereco();?>'/>
            </div>

            <input type="submit" name="btn_atualizar" value="Atualizar" class="btn_cadastrar" />
            <a href="index.php?classe=Paciente&metodo=index" class="btn-voltar"> Voltar</a>
        </form>
    </div>
</div>

<?php
include_once 'base/footer.php';
?>
