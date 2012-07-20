<?php
if (!isset($partNames)) {$partNames = PartRevision::findNamesByPageId($page_id);};
if (!isset($existingParts)) {$existingParts = PartRevision::findExistingNamesByPageId($page_id);}
if (!isset($deletedParts)) {$deletedParts = array_diff($partNames, $existingParts);}
//print_r($page_id);
//print_r($part_name_to_show);
if (isset($part_name_to_show) && $part_name_to_show!=='') {
	$partRevisions = PartRevision::findByPageIdAndName($page_id,$part_name_to_show);
	$nameIsDefined = true;
	echo '<p><strong>' . $part_name_to_show . '</strong> ' . __('part revisions') . ' [' . count($partRevisions).' '. __('total') . ']</p>';
} else {
	$partRevisions = PartRevision::findByPageId($page_id);
	$nameIsDefined = false;
	echo '<p><strong>' . __('All part revisions of this page ') . '</strong> [' . count($partRevisions).' '. __('total') . ']</p>';
} 
?>
<div id="parts_list_page_container">
<table id="part_revisions_list">
	<thead>
		<td class="name"><?php echo __('Name'); ?></td>
		<td class="updated_by"><?php echo __('Updated by'); ?></td>
		<td class="size"><?php echo __('Size'); ?></td>
		<td class="filter"><?php echo __('Filter'); ?></td>
		<td class="date"><?php echo __('Date'); ?></td>
		<td class="actions"><?php echo __('Actions'); ?></td>		
	</thead>
	<tbody>
<?php

	if (count($partRevisions)>0) {
	foreach ($partRevisions as $partRevision) {
		$partIsDeleted = in_array($partRevision->name, $deletedParts);
		if ($partIsDeleted) {$delClass = ' deleted';} else {$delClass = '';}
		echo '<tr class="' .  even_odd() . $delClass . '">';
		echo '<td class="name">' . $partRevision->name . '</td>' . 
		     '<td class="updated_by">' . $partRevision->updated_by_name . '</td>' . 
		     '<td class="size">' . $partRevision->size . '</td>' .
		     '<td class="filter">' . $partRevision->filter_id . '</td>' .
		     '<td class="date"><div class="daterelative">' . DateDifference::getString(new DateTime($partRevision->updated_on)) .'</div><div class="dateabsolute">' . $partRevision->updated_on . '</div></td>' . 
		     '<td class="actions">' . // actions below
			'<div class="actions_wrapper">' . 
			'<a href="#" class="preview_revision" rel="'.(int)$partRevision->id.'"><img src="' . PLUGINS_URI.'part_revisions/icons/magnifier-zoom.png' . '" alt="'.__('preview revision'). '" title="'.__('preview this revision').'"></a> ';
			if (! $partIsDeleted) { // show diff button for existing parts
				echo	'<a href="#" class="diff_revision" rel="'.(int)$partRevision->id.'"><img src="' . PLUGINS_URI.'part_revisions/icons/diff-16.png' . '" alt="'.__('show diff to current'). '" title="'.__('show diff to current').'"></a> ';
			}
			echo '<a href="' . get_url('plugin/part_revisions/delete') . '/' . (int)$partRevision->id . '/' . (int)$page_id . '"><img src="' . PLUGINS_URI.'part_revisions/icons/delete-16.png' . '" alt="'.__('delete THIS revision'). '" title="'.__('delete THIS revision').'"></a> ';
			echo	'<a href="' . get_url('plugin/part_revisions/revert') . '/' . (int)$partRevision->id . '" class="revert_revision"><img src="' . PLUGINS_URI.'part_revisions/icons/revert-16.png' . '" alt="'.__('revert this revision'). '" title="'.__('revert revision').'"></a> ';
			if ($nameIsDefined && (count($partRevisions)>1)) { // show button to cut off older revisions		
				echo	'<a href="' . get_url('plugin/part_revisions/deleteolder') . '/' . (int)$partRevision->id . '/' . (int)$page_id . '"><img src="' . PLUGINS_URI.'part_revisions/icons/deleteolder-16.png' . '" alt="'.__('delete all OLDER revisions'). '" title="'.__('delete all OLDER revisions').'"></a> ';
			}
		echo 	'</div>' .		  
		     '</td>'; 
		echo '</tr>';
	}
	} else {
		echo '<tr><td class="name" colspan="6"><em>'. __('No saved revisions yet. Try editing some parts!') . '</em></td></tr>';
	}
	
?>	
	</tbody>
</table>
</div>