<?php
include_once 'base/header.php';
include_once 'base/mensagem.php';
$consultas = $_REQUEST['consultas'];
session_unset();
?>

<div class="row">
    <div>
        <div class="md-col">
            <a href="index.php?classe=Consulta&metodo=create" class="btn dir ">Marcar Consulta</a>
            <h3> Consultas</h3>
        </div>
        <div class="md-col">
        <table>
            <tbody>
                <tr>
                    <th>Código:</th>
                    <th>Paciente:</th>
                    <th>Procedimento:</th>
                    <th>Médico:</th>
                    <th>Data de Atendimento:</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                    if(empty($consultas)) {?>
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>

                    <?php } else {

                    foreach($consultas as $consulta) {
                ?>
                <tr>
                    <td><a class="selecao" href="index.php?classe=Consulta&metodo=read&codigo=<?php echo $consulta->getCodigo(); ?>"><?php echo $consulta->getCodigo(); ?></a></td>
                    <td><?php echo $consulta->getPaciente(); ?></td>
                    <td><?php echo $consulta->getProcedimento(); ?></td>
                    <td><?php echo $consulta->getMedico(); ?></td>
                    <td><?php echo date_format(date_create($consulta->getData_atendimento()), "d/m/Y"); ?></td>

                    <td class="edi"><a href="index.php?classe=Consulta&metodo=editar&codigo=<?php echo $consulta->getCodigo();?>" class="btn-edit">Editar</a>
                    <button onclick="document.getElementById('verificar<?php echo $consulta->getCodigo();?>').style.display='block'">Deletar</button></td>
                    <td></td>

 
                    <div id="verificar<?php echo $consulta->getCodigo();?>" class="modal">
                    <div class="modal-content">
                        <form  action='index.php' method='POST'>
                            <div class="container">
                                <h1>AVISO!</h1>
                                <p>Tem certeza que deseja excluir essa consulta?</p>
                                <div class="clearfix">
                                    <input type="hidden" name="classe" value="Consulta"/>
                                    <input type="hidden" name="metodo" value="delete"/>
                                    <input type='hidden' name='codigo' value="<?php echo $consulta->getCodigo(); ?>" />
                                    <input type='submit' name='btn_deletar' value="Confirmar"/>
                                    <button type="button" onclick="document.getElementById('verificar<?php echo $consulta->getCodigo();?>').style.display='none'" class="cancelbtn">Cancelar</button>
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