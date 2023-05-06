<?php include APP_DIR.'views/parts/header.php';?>
<div class="edit_item_box">
	<?php 
		if(count($vars['task']['errors'])) foreach($vars['task']['errors'] as $error) { 
	?>
			<div class="alert alert-danger" role="alert">
				<?=$error;?>
			</div>
		
	<?php 
		} 
		if(isset($vars['task']['message'])) {
	?>	
		<div class="alert alert-success" role="alert">
			<?=$vars['task']['message'];?>
		</div>
	<?php
		}
	?>
	<form method="POST">
	  <div class="form-group">
		<div class="mb-3">
			<label for="email_address">Адрес электронной почты</label>
			<input <?=($vars['task']['id']?' disabled ':'');?> type="email" name="email" value="<?=$vars['task']['email'];?>" class="form-control form-control-lg" id="email_address" placeholder="name@example.com">
		</div>
	  </div>
	  <div class="form-group">
		<div class="mb-3">
			<label for="input_name">Имя</label>
			<input <?=($vars['task']['id']?' disabled ':'');?> type="text" name="name" value="<?=$vars['task']['name'];?>" class="form-control form-control-lg" id="input_name" placeholder="Иван Иванов">
		</div>
	  </div>
	  <div class="form-group">
		  <div class="mb-3">
			<label for="input_task">Текст задачи</label>
			<textarea class="form-control" name="task" id="input_task" rows="3"><?=$vars['task']['task'];?></textarea>
		  </div>
	  </div>
<?php 
	if($vars['task']['id']) {
?>	
	<div class="form-check">
		  <div class="mb-3">
			  <input class="form-check-input" name="complete" type="checkbox" value="1" id="input_complete" <?=($vars['task']['complete']==1?" checked ":"");?>>
			  <label class="form-check-label" for="input_complete">
				Задача завершена
			  </label>
		</div>
	</div>
	<input type="hidden" name="edit_id" value="<?=$vars['task']['id'];?>">
<?php	
	}
?>
	 <div class="form-group">
		<div class="mb-3">
		  <button type="submit" class="btn btn-primary"><?=$vars['task']['id']>0?"Сохранить задачу":"Добавить задачу";?></button>
		  <a href="<?=APP_PATH;?>" class="btn" role="button">Назад к списку задач</a>
		</div>
	  </div>  
	<input type="hidden" name="csrf_token" value="<?=$vars['task']['csrf_token'];?>">
	</form>
</div>
<?php include APP_DIR.'views/parts/footer.php';?>
