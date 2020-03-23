<?php
    include_once 'base/header.php';
    include_once 'base/mensagem.php';
    $procedimento = $_REQUEST['procedimento'];
    session_unset();
?>

<div class="row">
    <div>
        <h3 > Paciente </h3>
            <div class="mg-top" >
                <label><strong>Codigo: </strong><?php echo $procedimento->getCodigo();?></label>
            </div>
            <div class="mg-top" >
                <label><strong>Nome: </strong><?php echo $procedimento->getNome();?></label>
            </div>

            <div class="mg-top">
                <label><strong>Idade Mínima: </strong><?php echo $procedimento->getIdade_minima(); ?></label>
            </div>

            <div class="mg-top">
                <label><strong>Idade Máxima: </strong><?php echo $procedimento->getIdade_maxima();?></label>
            </div>

            <div class="mg-top">
                <label><strong>Sexo: </strong><?php echo $procedimento->getSexo();?></label>
                </select>
            </div>

            <div class="mg-t">
                <a href="index.php?classe=Procedimento&metodo=index" class="btn-voltar"> Voltar</a>
            </div>
    </div>
</div>

<?php
include_once 'base/footer.php';
?>
