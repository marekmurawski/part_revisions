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

$success = true;
$infoMessages = array();
$errorMessages = array();
	$PDO = Record::getConnection();
$driver = strtolower($PDO->getAttribute(Record::ATTR_DRIVER_NAME));

if ($driver == 'mysql') {
	if (!Permission::findByName('part_revisions_manage')) {
		$perm = new Permission(array('name' => 'part_revisions_manage'));
		if (!$perm->save()) {
			$success = false;
			$errorMessages[] = __('Could not create part_revisions_manage permission!');
		} else $infoMessages[] = 'Created part_revisions_manage permission!';
	} else {
		$infoMessages[] = 'part_revisions_manage permission already exists!';
	}

	//if (!Role::findByName('php editor')) {
	//	$role = new Role(array('name' => 'php editor'));
	//	if (!$role->save()) {
	//		$success = false;
	//		$errorMessages[] = __('Could not create Php Editor role!');
	//	} else $infoMessages[] = 'Created Php Editor role!';
	//} else {
	//	$infoMessages[] = 'Php Editor role already exists!';
	//}
	//
	//$perm = Permission::findByName('edit_parts_php');
	//$role = Role::findByName('php editor');
	//if (!($role && $perm)) {
	//	$rp = new RolePermission(array('permission_id' => $perm->id, 'role_id' => $role->id));
	//	if (!$rp->save()) {
	//		$success = false;
	//		$errorMessages[] = __('Could not assign edit_parts_php permission to Php Editor role!');
	//	} else $infoMessages[] = 'Assigned edit_parts_php permission to Php Editor role!';
	//}

	//if ($developerRole = Role::findByName('developer')) {
	//
	//	$perm = Permission::findByName('part_revisions_manage');
	//	$rp = RolePermission::findPermissionsFor($developerRole->id);
	//	if (!RolePermission::findOneFrom('RolePermission', 'role_id=? AND permission_id=?', array($developerRole->id, $perm->id))) {
	//		$rp[] = $perm;
	//		if (!RolePermission::savePermissionsFor($developerRole->id, $rp)) {
	//			$success = false;
	//			$errorMessages[] = __('Could not assign part_revisions_manage permission to Developer role!');
	//		} else $infoMessages[] = 'Assigned part_revisions_manage permission to Developer role!';
	//	}
	//} else {
	//	$infoMessages[] = 'Developer role not found!';
	//}



	// setup the table
	$sql = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."page_part_revision` (
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

	if ($PDO->exec($sql)===false) {$success=false; $errorMessages[]='<pre>' . print_r($PDO->errorInfo(), true) . '</pre>';}

	if ($success) {
		Flash::set('success', __('Successfully activated Part Revisions plugin!'));
		if (! empty($infoMessages)) {
			Flash::set('info',implode('<br/>', $infoMessages));
		}
	} else {
		Flash::set('error', __('A problems occured while activating Part Revisions plugin:') . '<br/>' .
		implode('<br/>', $errorMessages));
	}
	Flash::set('success', __('Successfully activated Part Revisions plugin!'));
	
	exit();

} // endif $driver==('mysql')
else
{
	Flash::set('error', __('This plugin works in MySQL only (for now)!'));
	exit();
}
