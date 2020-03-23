<?php
    include_once 'base/header.php';
    include_once 'base/mensagem.php';
    $paciente = $_REQUEST['paciente'];
    session_unset();
?>

<div class="row">
    <div>
        <h3 > Paciente </h3>
            <div class="mg-top" >
                <label><strong>Nome: </strong><?php echo $paciente->getNome();?></label>
            </div>
            <div class="mg-top" >
                <label><strong>Cartão SUS: </strong><?php echo $paciente->getCartao_sus();?></label>
            </div>
            <div class="mg-top" >
                <label><strong>Data de nascimento: </strong><?php echo date_format(date_create($paciente->getData_nascimento()), "d/m/Y"); ?></label>
            </div>

            <div class="mg-top">
                <label><strong>Idade: </strong><?php echo $paciente->getIdade(); ?></label>
            </div>

            <div class="mg-top">
                <label><strong>Sexo: </strong><?php echo $paciente->getSexo();?></label>
                </select>
            </div>

            <div class="mg-top">
                <label><strong>Endereco: </strong><?php echo $paciente->getEndereco();?></label>
            </div>
            <div class="mg-t">
                <a href="index.php?classe=Paciente&metodo=index" class="btn-voltar"> Voltar</a>
            </div>
    </div>
</div>

<?php
include_once 'base/footer.php';
?>
