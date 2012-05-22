<?php
$partNames = PartRevision::findNamesByPageId($page_id);
$existingParts = PartRevision::findExistingNamesByPageId($page_id);
$deletedParts = array_diff($partNames, $existingParts);
?>
<div id="<?php echo PR_CSS_ID ?>_tabcontents" class="page">
<table>
	<tr>
		<td style="vertical-align: top; width: 200px;">
			<ul>
				<p><strong><?php echo __('Part filtering')?>:</strong></p>
				<li style="margin-bottom: 5px;"><a class="filter_part" href="#" rel=""><?php echo __('show all parts'); ?></a></li>
				<?php
				foreach ($existingParts as $partName):
				?>
				<li><a class="filter_part" href="#" rel="<?php echo $partName; ?>"><?php echo $partName; ?></a></li>
				<?php 
				endforeach;
				?>
				<?php // now the deleted parts
				foreach ($deletedParts as $partName):
				?>
				<li><i><a class="filter_part" href="#" rel="<?php echo $partName; ?>"><?php echo $partName .' '. __('[deleted]'); ?></a></i></li>				
				<?php 
				endforeach;
				?>
			</ul>
			<p style="margin-top: 15px;"><strong><?php echo __('Actions')?>:</strong></p>
			<p>
				<a href="<?php echo get_url('plugin/part_revisions/purgebypage').'/'.(int)$page_id ?>">
				<img style="vertical-align: top; float: left;" src="<?php echo PLUGINS_URI.'part_revisions/icons/delete-folder-32.png'; ?>"/>
				<?php echo __('Purge all revisions of this page');?>
			</a>
			</p>

		</td>
		<td style="vertical-align: top;">
			<div id="part_revisions_container">
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
