<?php

/* Security measure */
if ( !defined('IN_CMS') ) {
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
$success       = true;
$infoMessages  = array( );
$errorMessages = array( );
$PDO           = Record::getConnection();
$driver        = strtolower($PDO->getAttribute(Record::ATTR_DRIVER_NAME));

if ( $driver == 'mysql' ) {
    if ( !Permission::findByName('part_revisions_manage') ) {
        $perm = new Permission(array( 'name' => 'part_revisions_manage' ));
        if ( !$perm->save() ) {
            $success         = false;
            $errorMessages[] = __('Could not create part_revisions_manage permission!');
        }
        else
            $infoMessages[]  = 'Created part_revisions_manage permission!';
    } else {
        $infoMessages[] = 'part_revisions_manage permission already exists!';
    }

    // setup the table
    $sql = "CREATE TABLE IF NOT EXISTS `" . TABLE_PREFIX . "page_part_revision` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(100) DEFAULT NULL,
	`filter_id` varchar(25) DEFAULT NULL,
	`content` longtext,
	`content_html` longtext,
	`page_id` int(11) unsigned DEFAULT NULL,
	`updated_on` datetime NOT NULL,
	`updated_by_id` int(11) NOT NULL,
	`updated_by_name` varchar(100) NOT NULL,
	`size` int(11) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

    if ( $PDO->exec($sql) === false ) {
        $success         = false;
        $errorMessages[] = '<pre>' . print_r($PDO->errorInfo(), true) . '</pre>';
    }

    if ( $success ) {
        Flash::set('success', __('Successfully activated Part Revisions plugin!'));
        if ( !empty($infoMessages) ) {
            Flash::set('info', implode('<br/>', $infoMessages));
        }
    } else {
        Flash::set('error', __('A problems occured while activating Part Revisions plugin:') . '<br/>' .
                    implode('<br/>', $errorMessages));
    }
    Flash::set('success', __('Successfully activated Part Revisions plugin!'));

    exit();
} // endif $driver==('mysql')
else {
    Flash::set('error', __('This plugin works in MySQL only (for now)!'));
    exit();
}
