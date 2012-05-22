<?php

/* Security measure */
if (!defined('IN_CMS')) {
	exit();
}

/**
 * Part Revisions Plugin for Wolf CMS
 * Provides Page Part revisions history management.
 * 
 * @package Plugins
 * @subpackage part_revisions
 *
 * @author Marek Murawski <http://marekmurawski.pl>
 * @copyright Marek Murawski, 2012
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
Plugin::setInfos(array(
		'id' => 'part_revisions',
		'title' => __('Page Part Revisions'),
		'description' => __('Provides Page Part revisions history management.'),
		'version' => '0.0.2',
		'license' => 'GPL',
		'author' => 'Marek Murawski',
		'website' => 'http://www.marekmurawski.pl/',
		//'update_url' => 'http://www.wolfcms.org/plugin-versions.xml',
		'require_wolf_version' => '0.7.5'
));

/**
 * Root location where Part Revisions is located.
 */
define('PR_ROOT_DIR', CORE_ROOT . '/plugins/part_revisions/');
define('PR_CSS_ID', 'part_revisions');

// Load the Page Part Revision class into the system.
AutoLoader::addFile('PartRevision', PR_ROOT_DIR.'models/PartRevision.php');
AutoLoader::addFolder(PR_ROOT_DIR.'lib');
Plugin::addController('part_revisions', __('Part Revisions'), 'admin_view');  

Observer::observe('part_edit_before_save', 'save_old_part');
Observer::observe('part_add_before_save', 'save_old_part');

Observer::observe('page_edit_after_save', 'show_part_revisions_saved_info'); 

Observer::observe('view_page_edit_tab_links', 'PartRevisionsController::Callback_view_page_edit_tab_links');
Observer::observe('view_page_edit_tabs', 'PartRevisionsController::Callback_view_page_edit_tabs');
Observer::observe('view_page_edit_popup', 'PartRevisionsController::Callback_view_page_edit_popup');

function show_part_revisions_saved_info($page) {
	if ($savedParts = Flash::get('page_revisions_saved_parts')) {
		
	Flash::set('info', __('The following part revisions were saved:') . '<br/>' .
	  implode('<br/>', $savedParts));	
	}

	return $page;
	
}

function save_old_part(&$part) {
	if (isset($part->id)) { // $part->id is set, so it's changed page, not new one
		$oldpart = PagePart::findByIdFrom('PagePart', $part->id);
		//$savedParts = array();
			if ($oldpart->content != $part->content) { // the content has changed
					$partRevision = new PartRevision;
					$partRevision->content		= $oldpart->content;
					$partRevision->content_html	= $oldpart->content_html;
					$partRevision->filter_id	= $oldpart->filter_id;
					$partRevision->name		= $oldpart->name;
					$partRevision->page_id		= $oldpart->page_id;
					$partRevision->save();
					$savedParts = Flash::get('page_revisions_saved_parts');
					$savedParts[] = $oldpart->name;
					Flash::setNow('page_revisions_saved_parts', $savedParts);
			}
	}
	return $part;
}
