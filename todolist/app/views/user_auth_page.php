<?php 
	include APP_DIR.'views/parts/header.php';
?>

<main class="form-signin w-50 mt-5 m-auto">
	<?php
		if(isset($vars['errors']) && count($vars['errors'])) foreach($vars['errors'] as $error) { 
		?>
		<div class="alert alert-danger mt-3" role="alert">
			<?=$error;?>
		</div>
		
	<?php } ?>
	<form method="POST">
		<h1 class="h3 mb-4 fw-normal">Вход для администратора</h1>
		
		<div class="form-floating mb-3">
			<input type="login" name="login" class="form-control" id="floatingInput" placeholder="Логин">
			<label for="floatingInput">Логин</label>
		</div>
		<div class="form-floating mb-3">
			<input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Пароль">
			<label for="floatingPassword">Пароль</label>
		</div>
		
		<button class="w-100 btn btn-lg btn-primary" type="submit">Войти</button>
		<input type="hidden" name="csrf_token" value="<?=$vars['csrf_token'];?>">
		
	</form>
</main>

<?php
	include APP_DIR.'views/parts/footer.php';
?>
