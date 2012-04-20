<div id="pr-recent-list" style="margin: 1em auto; padding: 0.1em;">
<table id="part_revisions_list">
	<thead>
		<td class="page_id">Page id</td>
		<td class="name">Name</td>
		<td class="updated_by">Updated by</td>
		<td class="size">Size</td>
		<td class="filter">Filter</td>
		<td class="date">Date</td>
		<td class="actions">Actions</td>
	</thead>
	<tbody>
<?php
$partRevisions = PartRevision::findAllFrom('PartRevision', '1=1 ORDER BY updated_on DESC');

	if (count($partRevisions)>0) {
	foreach ($partRevisions as $partRevision) {
		echo '<tr class="' .  even_odd() . '">';
		echo '<td class="page_id">' . $partRevision->page_id . '</td>' . 
		     '<td class="name">' . $partRevision->name . '</td>' . 
		     '<td class="updated_by">' . $partRevision->updated_by_name . '</td>' . 
		     '<td class="size">' . $partRevision->size . '</td>' .
		     '<td class="filter">' . $partRevision->filter_id . '</td>' .
		     '<td class="date">' . $partRevision->updated_on . '</td>' . 
		     '<td class="actions">' . // actions below
			'<div class="actions_wrapper">' . 
			'<a href="' . get_url('plugin/part_revisions/delete') . '/' . (int)$partRevision->id . '/0"><img src="' . ICONS_URI.'delete-16.png' . '"></a> ' .
			'<a href="#" class="preview_revision" rel="'.(int)$partRevision->id.'"><img src="' . PLUGINS_URI.'part_revisions/icons/magnifier-zoom.png' . '"></a> ' .
			'<a href="#" class="diff_revision" rel="'.(int)$partRevision->id.'"><img src="' . PLUGINS_URI.'part_revisions/icons/diff-16.png' . '" alt="'.__('show differences'). '" title="'.__('show differences').'"></a> ' .
			'</div>' .
		     '</td>'; 
		echo '</tr>';
	}
	} else {
		echo '<tr><td class="name" colspan="6"><em>No saved page part revisions yet.</em></td></tr>';
	}
	
?>	
	</tbody>
</table>
</div>
<div id="boxes">
<?php
                    echo new View('../../plugins/part_revisions/views/editpage/popup_part_preview', array(
                            'page_id' => 0,
                    )); 
?>
</div>
