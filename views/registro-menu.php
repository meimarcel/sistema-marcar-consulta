<?php
include_once 'base/header.php';
require_once 'model/RegistroAtendimento.php';
$registros = $_REQUEST['registros'];
include_once 'base/mensagem.php';
session_unset();
?>

<div class="row">
    <div>
        <div class="md-col">
            <a href="index.php?classe=RegistroAtendimento&metodo=create" class="btn dir ">Criar Registro</a>
            <h3> Registro de Atendimento</h3>
        </div>
        <div class="md-col">
        <table>
            <tbody>
                <tr>
                    <th>Código do Agendamento:</th>
                    <th>Situação:</th>
                    <th>Data efetiva do atendimento:</th>
                    <th>Observação:</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                    if(empty($registros)) {?>
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>

                    <?php } else {

                    foreach($registros as $registro) {
                ?>
                <tr>
                    <td><a class="selecao" href="index.php?classe=RegistroAtendimento&metodo=read&id=<?php echo $registro->getId();?>"><?php echo $registro->getCodigo_agendamento(); ?></a></td>
                    <td><?php echo $registro->getSituacao(); ?></td>
                    <td><?php echo ($registro->getData_efetiva_atendimento() == null)? "-":date_format(date_create($registro->getData_efetiva_atendimento()), "d/m/Y"); ?></td>
                    <td><?php echo ($registro->getObs() == "")? "-":$registro->getObs(); ?></td>

                    <td class="edi"><a href="index.php?classe=RegistroAtendimento&metodo=editar&id=<?php echo $registro->getId();?>" class="btn-edit">Editar</a>
                    <button onclick="document.getElementById('verificar<?php echo $registro->getId();?>').style.display='block'">Deletar</button></td>
                    <td></td>

 
                    <div id="verificar<?php echo $registro->getId();?>" class="modal">
                    <div class="modal-content">
                        <form  action="index.php" method='POST'>
                            <div class="container">
                                <h1>AVISO!</h1>
                                <p>Tem certeza que deseja excluir esse registro de atendimento?</p>
                                <div class="clearfix">
                                    <input type='hidden' name='classe' value="RegistroAtendimento"/>
                                    <input type='hidden' name='metodo' value="delete"/>
                                    <input type='hidden' name='id' value="<?php echo $registro->getId(); ?>" />
                                    <input type='submit' name='btn_deletar' value="Confirmar"/>
                                    <button type="button" onclick="document.getElementById('verificar<?php echo $registro->getId();?>').style.display='none'" class="cancelbtn">Cancelar</button>
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