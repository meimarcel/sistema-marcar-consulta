<?php
include_once 'base/header.php';
include_once 'base/mensagem.php';
$pacientes = $_REQUEST['pacientes'];
session_unset();
?>

<div class="row">
    <div>
        <div class="md-col">
            <a href="index.php?classe=Paciente&metodo=create" class="btn dir ">Adicionar Paciente</a>
            <h3> Pacientes</h3>
        </div>
        <div class="md-col">
        <table>
            <tbody>
                <tr>
                    <th>Nome:</th>
                    <th>Cartão SUS:</th>
                    <th>Data de Nascimento:</th>
                    <th>Idade:</th>
                    <th>Sexo:</th>
                    <th>Endereco:</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                    if(empty($pacientes)) {?>
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>

                    <?php } else {

                    foreach($pacientes as $paciente) {
                ?>
                <tr>
                    <td><a class='selecao' href="index.php?classe=Paciente&metodo=read&id=<?php echo $paciente->getId();?>"><?php echo $paciente->getNome(); ?></a></td>
                    <td><?php echo $paciente->getCartao_sus(); ?></td>
                    <td><?php echo date_format(date_create($paciente->getData_nascimento()), "d/m/Y"); ?></td>
                    <td><?php echo $paciente->getIdade(); ?></td>
                    <td><?php echo $paciente->getSexo(); ?></td>
                    <td class='drop'><div class="dropdown">
                            <?php echo substr($paciente->getEndereco(),0, 50)."..."; ?>
                            <div class='dropdown-content'>
                                <p><?php echo $paciente->getEndereco();?></p>
                            </div>
                        </div>
                    </td>


                    <td class="edi"><a href="index.php?classe=Paciente&metodo=editar&id=<?php echo $paciente->getId();?>" class="btn-edit">Editar</a>
                    <button onclick="document.getElementById('verificar<?php echo $paciente->getId();?>').style.display='block'">Deletar</button></td>
                    <td></td>

 
                    <div id="verificar<?php echo $paciente->getId();?>" class="modal">
                    <div class="modal-content">
                        <form  action='index.php' method='POST'>
                            <div class="container">
                                <h1>AVISO!</h1>
                                <p>Tem certeza que deseja excluir esse paciente?</p>
                                <div class="clearfix">
                                    <input type='hidden' name='classe' value="Paciente" />
                                    <input type='hidden' name='metodo' value="delete" />
                                    <input type='hidden' name='id' value="<?php echo $paciente->getId(); ?>" />
                                    <input type='submit' name='btn_deletar' value="Confirmar"/>
                                    <button type="button" onclick="document.getElementById('verificar<?php echo $paciente->getId();?>').style.display='none'" class="cancelbtn">Cancelar</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </tr>
                <?php }
                }?>
            </tbody>
        </table>
        </div>
    </div>
</div>

<?php
include_once 'base/footer.php';
?>