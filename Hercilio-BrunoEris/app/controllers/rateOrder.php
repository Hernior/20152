<?php
include_once("DBConnect.php");
include_once("session_user.php");
?>
<a class="btn btn-default link_ajax" href="orders.php">Voltar</a>
<form class="form-inline" method="post" action="../../controllers/rateOrderConfirm.php" id="formOrder">
<div class="form-group">
  <label for="sel1">Avaliação (Nº do Pedido: <?php echo $_GET['order']?>)</label>
  <input type="hidden" name="order" value="<?php echo $_GET['order']?>">
  <select name="rate" class="form-control" form="formOrder">
    <option value="1">★☆☆☆☆</option>
    <option value="2">★★☆☆☆</option>
    <option value="3">★★★☆☆</option>
    <option value="4">★★★★☆</option>
    <option value="5">★★★★★</option>
  </select>
</div>
<button type="submit" class="btn btn-primary">Avaliar</button>
</form>
<script src="../../assets/js/jquery.form.min.js"></script>
<script src="../../assets/js/form.js"></script>
