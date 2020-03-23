<?php
include_once 'base/header.php';
include_once 'base/mensagem.php';
$procedimentos = $_REQUEST['procedimentos'];
session_unset();
?>

<div class="row">
    <div>
        <div class="md-col">
            <a href="index.php?classe=Procedimento&metodo=create" class="btn dir ">Adicionar Procedimento</a>
            <h3> Procedimentos</h3>
        </div>
        <div class="md-col">
        <table>
            <tbody>
                <tr>
                    <th>Codigo:</th>
                    <th>Nome:</th>
                    <th>Idade Mínima:</th>
                    <th>Idade Máxima:</th>
                    <th>Sexo:</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                    if(empty($procedimentos)) {?>
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

                    foreach($procedimentos as $procedimento) {
                ?>
                <tr>
                    <td><a class='selecao' href="index.php?classe=Procedimento&metodo=read&codigo=<?php echo $procedimento->getCodigo();?>"><?php echo $procedimento->getCodigo(); ?></a></td>
                    <td><?php echo $procedimento->getNome(); ?></td>
                    <td><?php echo $procedimento->getIdade_minima(); ?></td>
                    <td><?php echo $procedimento->getIdade_maxima(); ?></td>
                    <td><?php echo $procedimento->getSexo(); ?></td>


                    <td class="edi"><a href="index.php?classe=Procedimento&metodo=editar&codigo=<?php echo $procedimento->getCodigo();?>" class="btn-edit">Editar</a>
                    <button onclick="document.getElementById('verificar<?php echo $procedimento->getCodigo();?>').style.display='block'">Deletar</button></td>
                    <td></td>

 
                    <div id="verificar<?php echo $procedimento->getCodigo();?>" class="modal">
                    <div class="modal-content">
                        <form  action='index.php' method='POST'>
                            <div class="container">
                                <h1>AVISO!</h1>
                                <p>Tem certeza que deseja excluir esse procedimento?</p>
                                <div class="clearfix">
                                    <input type='hidden' name='classe' value="Procedimento" />
                                    <input type='hidden' name='metodo' value="delete" />
                                    <input type='hidden' name='codigo' value="<?php echo $procedimento->getCodigo(); ?>" />
                                    <input type='submit' name='btn_deletar' value="Confirmar"/>
                                    <button type="button" onclick="document.getElementById('verificar<?php echo $procedimento->getCodigo();?>').style.display='none'" class="cancelbtn">Cancelar</button>
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