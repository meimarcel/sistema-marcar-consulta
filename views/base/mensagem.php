<?php
if(isset($_SESSION['mensagem'])) {
?>

<div class="mensagem">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <?php echo $_SESSION['mensagem'];?>
</div>

<?php
}
unset($_SESSION['mensagem']);
?>