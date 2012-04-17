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
$success = true;

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

if ($success) {
	Flash::set('success', __('Successfully activated Part Revisions plugin!'));
	if (isset($infoMessages)) {
		Flash::set('info',implode('<br/>', $infoMessages));
	}
} else {
	Flash::set('error', __('A problems occured while activating Part Revisions plugin:') . '<br/>' .
	  implode('<br/>', $errorMessages));
}

exit();