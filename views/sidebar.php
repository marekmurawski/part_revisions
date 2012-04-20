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
<div class="box">
    <p class="button">
        <a href="<?php echo get_url('plugin/part_revisions/recent'); ?>">
            <img src="<?php echo PLUGINS_URI.'part_revisions/icons/page-32.png'; ?>" align="middle" title="<?php echo __('Recent Part Revisions'); ?>" alt="<?php echo __('Recent Part Revisions'); ?>" />
            <?php echo __('Recent Part Revisions'); ?>
        </a>
    </p>

    <p class="button">
        <a href="<?php echo get_url('plugin/part_revisions/purgeall'); ?>">
            <img src="<?php echo PLUGINS_URI.'part_revisions/icons/delete-folder-32.png'; ?>" align="middle" title="<?php echo __('Purge all page parts'); ?>" alt="<?php echo __('Purge all page parts'); ?>" />
            <?php echo __('Purge all page parts'); ?>
        </a>
    </p>
    
    <p class="button">
	<a href="<?php echo get_url('plugin/part_revisions/documentation'); ?>">
            <img src="<?php echo PLUGINS_URI.'part_revisions/icons/help-32.png'; ?>" align="middle" title="<?php echo __('Documentation'); ?>" alt="<?php echo __('Documentation'); ?>" />
            <?php echo __('Documentation'); ?>
        </a>	    
    </p>
</div>