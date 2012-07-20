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
            <?php echo __('Recent Revisions'); ?>
        </a>
    </p>

    <p class="button">
        <a href="<?php echo get_url('plugin/part_revisions/purgeall'); ?>">
            <img src="<?php echo PLUGINS_URI.'part_revisions/icons/delete-folder-32.png'; ?>" align="middle" title="<?php echo __('Purge all page parts'); ?>" alt="<?php echo __('Purge all page parts'); ?>" />
            <?php echo __('Purge all Revisions'); ?>
        </a>
    </p>
    
    <p class="button">
	<a href="<?php echo get_url('plugin/part_revisions/documentation'); ?>">
            <img src="<?php echo PLUGINS_URI.'part_revisions/icons/help-32.png'; ?>" align="middle" title="<?php echo __('Documentation'); ?>" alt="<?php echo __('Documentation'); ?>" />
            <?php echo __('Documentation'); ?>
        </a>	    
    </p>
</div>
<div class="box">
	<p>
		<?php echo __('This list shows recently changed Page Parts in the site. Here you can only <b>preview</b> the contents of saved Page Parts or <b>delete</b> it.'); ?>
	</p>
	<p>
		<?php echo __('If you want to manage saved page parts (revert them, compare to current or delete more than one), you need to go to standard Wolf Page editing and use the "Part Revisions" tab there.'); ?>
	</p>
	<p>
		<?php echo __('Alternatively, you can jump to the Page containing Part Revision listed above by clicking page ID in the first column of the list.'); ?>
	</p>
</div>