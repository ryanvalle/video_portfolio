<?php
	$pages = get_page_type_ids(-1);
?>

<section>
	<div class="constrain content-list">
		<table>
			<thead>
				<tr>
					<th>Page Type</th>
					<th>Edit</th>
				</tr>
			</thead>
			<tbody>
				<?php while($page = $pages->fetch_assoc())
					{ ?>
					<tr>
						<td><?php echo $page['title']; ?></td>
						<td><a href="/_admin/page_edit?id=<?php echo $page['id']; ?>">Edit</a></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</section>