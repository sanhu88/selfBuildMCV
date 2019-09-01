<form action="" method="get">
	<input type="text" name="keyword" value="<?php echo $keyword ?>">
	<input type="submit" name="" value="搜一下">
</form>

<p><a href="/item/manage">新建</a></p>

<table>
	<tr>
		<th>ID</th>
		<th>内容</th>
		<th>操作</th>
	</tr>

	<?php foreach ($items as $item): ?>
		<tr>
			<td><?php echo $item['id'] ?></td>
			<td><?php echo $item['item_name'] ?></td>
			<td>
				<a href="/item/manage/<?php echo $itme['id'] ?>">编辑</a>
				<a href="/item/delete/<?php echo $itme['id'] ?>">删除</a>
			</td>
		</tr>

	<?php endforeach ?>

	</table>