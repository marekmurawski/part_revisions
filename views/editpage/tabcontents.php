<?php
$partNames = PartRevision::findNamesByPageId($page_id);
$existingParts = PartRevision::findExistingNamesByPageId($page_id);
$deletedParts = array_diff($partNames, $existingParts);
?>
<div id="<?php echo PR_CSS_ID ?>_tabcontents" class="page">
<table>
	<tr>
		<td style="vertical-align: top; width: 200px;">
			<p>
			<select id="part_select">
				<option value="">-- <?php echo __('EXISTING PARTS'); ?> --</option>
				<?php
				foreach ($existingParts as $partName):
				?>
				<option value="<?php echo $partName; ?>"><?php echo $partName; ?></option>
				<?php 
				endforeach;
				?>
				<option value="">-- <?php echo __('DELETED PARTS'); ?> --</option>
				<?php
				foreach ($deletedParts as $partName):
				?>
				<option value="<?php echo $partName; ?>"><?php echo $partName; ?></option>
				<?php 
				endforeach;
				?>
			</select>
			</p>
			<p><a href="<?php echo get_url('plugin/part_revisions/purgebypage').'/'.(int)$page_id ?>"><img src="<?php echo PLUGINS_URI.'part_revisions/icons/delete-folder-32.png'; ?>"/></a></p>
		</td>
		<td style="vertical-align: top;">
			<div id="parts-revisions-list">
			<?php
				echo new View('../../plugins/part_revisions/views/editpage/parts_list', array(
					'page_id'           => $page_id,
					'partNames'	    => $partNames,
					'existingParts'	    => $existingParts,
					'deletedParts'      => $deletedParts,
					'part_name_to_show' => '',
				)); 

			//print_r ($partNames); echo '<br/>';
			//print_r ($existingParts); echo '<br/>';
			//$deletedParts = array_diff($partNames, $existingParts);
			//print_r ($deletedParts); 
			?>
			</div>

			<?php // echo '<pre>' . (htmlentities(print_r($_COOKIE,true))) . '</pre>'; ?>

		</td>
	</tr>
</table>

</div> 
