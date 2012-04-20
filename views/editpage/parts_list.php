<?php
if (!isset($partNames)) {$partNames = PartRevision::findNamesByPageId($page_id);};
if (!isset($existingParts)) {$existingParts = PartRevision::findExistingNamesByPageId($page_id);}
if (!isset($deletedParts)) {$deletedParts = array_diff($partNames, $existingParts);}
//print_r($page_id);
//print_r($part_name_to_show);
?>
<?php if (isset($part_name_to_show) && $part_name_to_show!==''): ?>
<p><strong><?php echo $part_name_to_show; ?></strong></p>
<?php else: ?>
<p><strong>all part revisions</strong></p>
<?php endif; ?>

<table id="part_revisions_list">
	<thead>
		<td class="name">Name</td>
		<td class="updated_by">Updated by</td>
		<td class="size">Size</td>
		<td class="filter">Filter</td>
		<td class="date">Date</td>
		<td class="actions">Actions</td>
	</thead>
	<tbody>
<?php
if (isset($part_name_to_show) && $part_name_to_show!=='') {
$partRevisions = PartRevision::findByPageIdAndName($page_id,$part_name_to_show);
} else {
$partRevisions = PartRevision::findByPageId($page_id);
}
	if (count($partRevisions)>0) {
	foreach ($partRevisions as $partRevision) {
		(in_array($partRevision->name, $deletedParts)) ? $delClass = ' deleted' : $delClass = '';
		echo '<tr class="' .  even_odd() . $delClass . '">';
		echo '<td class="name">' . $partRevision->name . '</td>' . 
		     '<td class="updated_by">' . $partRevision->updated_by_name . '</td>' . 
		     '<td class="size">' . $partRevision->size . '</td>' .
		     '<td class="filter">' . $partRevision->filter_id . '</td>' .
		     '<td class="date">' . $partRevision->updated_on . '</td>' . 
		     '<td class="actions">' . // actions below
			'<div class="actions_wrapper">' . 
			'<a href="' . get_url('plugin/part_revisions/delete') . '/' . (int)$partRevision->id . '/' . (int)$page_id . '"><img src="' . ICONS_URI.'delete-16.png' . '" alt="'.__('delete revision'). '" title="'.__('delete revision').'"></a> ' .
			'<a href="#" class="preview_revision" rel="'.(int)$partRevision->id.'"><img src="' . PLUGINS_URI.'part_revisions/icons/magnifier-zoom.png' . '" alt="'.__('preview revision'). '" title="'.__('preview revision').'"></a> ' .
			'<a href="#" class="diff_revision" rel="'.(int)$partRevision->id.'"><img src="' . PLUGINS_URI.'part_revisions/icons/diff-16.png' . '" alt="'.__('show differences'). '" title="'.__('show differences').'"></a> ' .
			'<a href="#" class="restore_revision" rel="'.(int)$partRevision->id.'"><img src="' . ICONS_URI.'open-16.png' . '" alt="'.__('restore revision'). '" title="'.__('restore revision').'"></a> ' .
			'</div>' .		  
		     '</td>'; 
		echo '</tr>';
	}
	} else {
		//echo '<tr><td class="name" colspan="6"><em>No saved revisions for ' . $part_name_to_show . '</em></td></tr>';
	}
	
?>	
	</tbody>
</table>