<?php
include_once 'base/header.php';
include_once 'base/mensagem.php';
$medicos = $_REQUEST['medicos'];
session_unset();
?>

<div class="row">
    <div>
        <div class="md-col">
            <a href="index.php?classe=Medico&metodo=create" class="btn dir ">Adicionar Médico</a>
            <h3> Médicos</h3>
        </div>
        <div class="md-col">
        <table>
            <tbody>
                <tr>
                    <th>Nome:</th>
                    <th>CPF:</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                    if(empty($medicos)) {?>
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>

                    <?php } else {

                    foreach($medicos as $medico) {
                ?>
                <tr>
                    <td><a class='selecao' href="index.php?classe=Medico&metodo=read&cpf=<?php echo $medico->getCpf();?>"><?php echo $medico->getNome(); ?></a></td>
                    <td><?php echo $medico->getCpf(); ?></td>

                    <td class="edi"><a href="index.php?classe=Medico&metodo=editar&cpf=<?php echo $medico->getCpf();?>" class="btn-edit">Editar</a>
                    <button onclick="document.getElementById('verificar<?php echo $medico->getCpf();?>').style.display='block'">Deletar</button></td>
                    <td></td>

 
                    <div id="verificar<?php echo $medico->getCpf();?>" class="modal">
                    <div class="modal-content">
                        <form  action='index.php' method='POST'>
                            <div class="container">
                                <h1>AVISO!</h1>
                                <p>Tem certeza que deseja excluir esse médico?</p>
                                <div class="clearfix">
                                    <input type='hidden' name='classe' value="Medico"/>
                                    <input type='hidden' name='metodo' value="delete"/>
                                    <input type='hidden' name='cpf' value="<?php echo $medico->getCpf(); ?>" />
                                    <input type='submit' name='btn_deletar' value="Confirmar"/>
                                    <button type="button" onclick="document.getElementById('verificar<?php echo $medico->getCpf();?>').style.display='none'" class="cancelbtn">Cancelar</button>
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