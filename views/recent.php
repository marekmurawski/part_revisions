<?php
if (!defined('IN_CMS')) { exit(); }
?>
<h1><?php echo __('Recent Part Revisions'); ?></h1>
<div id="pr-recent-list" style="margin: 1em auto; padding: 0.1em;">
		<?php
		use_helper('Pagination');
		$listLimit = 20;
		$listCount = Record::countFrom('PartRevision');
		$listOffset = ($page_number-1) * $listLimit;
		($listOffset>0) ? $offsetQuery = ' OFFSET '.$listOffset : $offsetQuery = '';
		$partRevisions = Record::findAllFrom('PartRevision', '1=1 ORDER BY updated_on DESC LIMIT ' . $listLimit . $offsetQuery);
		$pagination = new Pagination(array(
		'base_url'		=> get_url('plugin/part_revisions/recent/'),
		'total_rows'         => $listCount, // Total number of items (database results)
		'per_page'           => $listLimit, // Max number of items you want shown per page
		'num_links'          => 3, // Number of "digit" links to show before/after the currently viewed page
		'cur_page'           => $page_number, // The current page being viewed
		));
		?>
	<div class ="pagination">
		<?php
		echo __('Total') . ': ' . $listCount . ' ' . __('revisions');
		echo $pagination->createLinks();
		?>
	</div>
<table id="part_revisions_list">
	<thead>
		<td class="page_id">P. id</td>
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
		echo '<tr class="' .  even_odd() . '">';
		echo '<td class="page_id"><a href="' . get_url('/page/edit') . '/' . (int)$partRevision->page_id . '#part_revisions_tabcontents">' . (int)$partRevision->page_id . '</a></td>' . 
		     '<td class="name">' . $partRevision->name . '</td>' . 
		     '<td class="updated_by">' . $partRevision->updated_by_name . '</td>' . 
		     '<td class="size">' . $partRevision->size . '</td>' .
		     '<td class="filter">' . $partRevision->filter_id . '</td>' .
		     '<td class="date">' . DateDifference::getString(new DateTime($partRevision->updated_on)) . '</td>' . 
		     '<td class="actions">' . // actions below
			'<div class="actions_wrapper">' . 
			'<a href="' . get_url('plugin/part_revisions/delete') . '/' . (int)$partRevision->id . '/0"><img src="' . PLUGINS_URI.'part_revisions/icons/delete-16.png' . '" alt="'.__('delete THIS revision'). '" title="'.__('delete THIS revision').'"></a> ' .
			'<a href="#" class="preview_revision" rel="'.(int)$partRevision->id.'"><img src="' . PLUGINS_URI.'part_revisions/icons/magnifier-zoom.png' . '" alt="'.__('preview revision'). '" title="'.__('preview this revision').'"></a> ' .
			//'<a href="#" class="diff_revision" rel="'.(int)$partRevision->id.'"><img src="' . PLUGINS_URI.'part_revisions/icons/diff-16.png' . '" alt="'.__('show differences'). '" title="'.__('show differences').'"></a> ' .
			'</div>' .
		     '</td>'; 
		echo '</tr>';
	}
	} else {
		echo '<tr><td class="name" colspan="7"><em>' . __('No saved page part revisions yet.') . '</em></td></tr>';
	}
	
?>	
	</tbody>
</table>
	<div class ="pagination">
		<?php
		echo __('Total') . ': ' . $listCount . ' ' . __('revisions');
		echo $pagination->createLinks();
		?>
	</div>	
</div>

<div id="boxes">
<?php
                    echo new View('../../plugins/part_revisions/views/editpage/popup_part_preview', array(
                            'page_id' => 0,
                    )); 
?>
</div>
<script type="text/javascript">
// <![CDATA[
    $(document).ready(function() {
        // Make all modal dialogs draggable
        $("#boxes .window").draggable({
            addClasses: false,
            containment: 'window',
            scroll: false,
            handle: '.titlebar'
        })

        //if close button is clicked
        $('#boxes .window .close').click(function (e) {
            //Cancel the link behavior
            e.preventDefault();
            $('#mask, .window').hide();
        });

    });
// ]]>
</script>