<?php

/* Security measure */
if (!defined('IN_CMS')) {
	exit();
}

/**
 * Restrict PHP Plugin for Wolf CMS.
 * Provides PHP code restriction in page parts based on roles and/or permissions
 * 
 * 
 * @package Plugins
 * @subpackage restrict_php
 *
 * @author Marek Murawski <http://marekmurawski.pl>
 * @copyright Marek Murawski, 2012
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
Plugin::setInfos(array(
		'id' => 'part_revisions',
		'title' => __('Page part revisions'),
		'description' => __('Page part revision history'),
		'version' => '0.0.1',
		'license' => 'GPL',
		'author' => 'Marek Murawski',
		'website' => 'http://www.marekmurawski.pl/',
		//'update_url' => 'http://www.wolfcms.org/plugin-versions.xml',
		'require_wolf_version' => '0.7.5'
));

Plugin::addController('part_revisions', __('Part Revisions'), 'administrator', true);

Observer::observe('part_edit_before_save', 'restrict_php_part');
Observer::observe('part_add_before_save', 'restrict_php_part');

Observer::observe('page_edit_after_save', 'show_part_revisions_edit_error');
Observer::observe('page_add_after_save', 'show_part_revisions_add_error');


function show_part_revisions_edit_error($page) {
	if ($restr_parts = Flash::get('php_restricted_parts')) {
		Flash::set('error', __("You CAN'T edit") . '<br/><strong>' .
		  implode('<br/>', $restr_parts) . '</strong><br/>' .
		  __('page parts because they contain PHP code.') . '<br/>' .
		  __('Contact site administrator if you need to edit PHP code in page parts.')
		);
	Flash::set('info', __('Some page parts were not updated due to "PHP edit" permission restrictions!'));	
	}

	return $page;
}

function show_part_revisions_add_error($page) {
	if ($restr_parts = Flash::get('php_restricted_parts')) {
		Flash::set('error', __("You CAN'T add PHP code into page parts. The following parts were cleared:") . '<br/><strong>' .
		  implode('<br/>', $restr_parts) . '</strong><br/>' .
		  __('Contact site administrator if you need to edit PHP code in page parts.')
		);
	Flash::set('info', __('Some page parts were not updated due to "PHP edit" permission restrictions!'));	
	}

	return $page;
}


function save_old_part(&$part) {
	$oldpart = PagePart::findByIdFrom('PagePart', $part->id);
	$codeFound = FALSE;

	$codeFound = (has_php_code($part->content) || has_php_code($oldpart->content));

	if ($codeFound) {
		if ($oldpart->content !== $part->content) { // the content has changed
			if (!AuthUser::hasPermission('edit_parts_php')) {
				$restrParts = Flash::get('php_restricted_parts');
				$restrParts[] = $part->name;
				Flash::setNow('php_restricted_parts', $restrParts);
				$part->content = $oldpart->content; //set original page part content
			}
		}
	}
	return $part;
}
