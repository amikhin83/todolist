<?php 
	include APP_DIR.'views/parts/header.php';

	if(isset($vars['message'])) {
	?>	
		<div class="alert alert-success mt-4" role="alert">
			<?=$vars['message'];?>
		</div>
	<?php
	}
	if(count($vars['items'])) {
		$headers = ['Имя'=>'name','E-mail'=>'email','Текст'=>'','Статус'=>'complete','Изменено'=>''];
		if(isset($vars['admin_mode']) && $vars['admin_mode']==true) {
			$headers = ['&nbsp;'=>''] + $headers;
		}
	?>
	<table class="table mb-4">
		<thead>
			<tr>
				<?php 
					foreach($headers as $header=>$ordering) {
						if($ordering) {
						?>
						<th scope="col">
							<form method="POST" class="ordering">
								<input type="hidden" name="order_field" value="<?=$ordering;?>">
								<?php if($vars['order_field']==$ordering) {
									echo ($vars['order_dir']=="asc"?"&#8593;":"&#8595;");
								}?>
								<a href="javascript:void(0);" onclick="this.parentNode.submit()"><?=$header;?></a>
							</form>
						</th>
						<?php
							} else { 
						?>
						<th scope="col"><?=$header;?></th>
						<?php
						}
					}
				?>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach($vars['items'] as $task) {
				?>
				<tr>
					<?php 
						if(isset($vars['admin_mode']) && $vars['admin_mode']==true) {
					?>
					<td class="col-1 text-center">
						<form action="<?=APP_PATH."main/edit_item/";?>" method="POST" class="editing">
								<input type="hidden" name="edit_id" value="<?=$task['id'];?>">
								<a href="javascript:void(0);" onclick="this.parentNode.submit()">&#9999;</a>
						</form>					
					</td>					
					<?php
						}
					?>
					<td class="col-2"><?=$task['name'];?></td>
					<td class="col-2"><?=$task['email'];?></td>
					<td ><p class="text-break"><?=$task['task'];?><p></td>
						<td class="col-1 text-center"><?=$task['complete']?
							'<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Завершено">&#10003;</span>':
						'<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="В процессе">&#8987;</span>';?></td>
						<td class="col-1 text-center"><?=$task['edited']?'<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Изменено админом">&#128221;':'';?></td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			<?php
				if($vars['last_page']>0) {
					$prevous_link = "#";
					if($vars['current_page']>0) {
						$prevous_link = APP_PATH."main/index/".$vars['current_page']."/";
					}
					$next_link = "#";
					if($vars['current_page']<$vars['last_page']) {
						$next_link = APP_PATH."main/index/".($vars['current_page']+2)."/";
					}
				?>
				<nav aria-label="Page navigation">
					<ul class="pagination">
						<li class="page-item <?=($prevous_link=="#"?"disabled":"")?>">
							<a class="page-link" href="<?=$prevous_link?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<li class="page-item"><a class="page-link <?=($vars['current_page']==0?'active':'');?>" href="<?=APP_PATH;?>">1</a></li>
						<?php
							for($page=1; $page<=$vars['last_page']; $page++) {
							?>
							<li class="page-item"><a class="page-link <?=($vars['current_page']==$page?'active':'');?>" href="<?=(APP_PATH.'main/index/'.($page+1).'/');?>"><?=($page+1);?></a></li>
							<?php
							}
						?>
						<li class="page-item <?=($next_link=="#"?"disabled":"")?>">
							<a class="page-link" href="<?=$next_link?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					</ul>
				</nav>
				<?php
				}
			} else {
			?>
				<div class="alert alert-success mt-4" role="alert">
					Задач пока не добавлено
				</div>
			<?php
			}
			
	include APP_DIR.'views/parts/footer.php';?>
		