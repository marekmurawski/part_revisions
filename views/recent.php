<?php
if (!defined('IN_CMS')) { exit(); }


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
?>
<h1><?php echo __('Recent Part Revisions'); ?></h1>
<div>
<?php
echo new View('../../plugins/part_revisions/views/recent_list', array(
		));
?>
</div>