<?php
if (!defined('IN_CMS')) {
	exit();
}
?>

<h1><?php echo __('Documentation'); ?></h1>

<h2>Restrict PHP plugin</h2>
<div>
	<p>
		This plugin provides way to restrict certain users or group of users (roles) from creating and editing PHP code in page parts. Essentially it checks for existence of PHP opening tags
		in page part content while saving the page part data.
	</p>
	<p>
		When Restrict PHP plugin is enabled a new permission <strong>edit_parts_php</strong> and a new role <strong>Php Editor</strong> is added. 
		Users having administrator role can <strong>always</strong> edit and create PHP code. By default the plugin also assigns the <strong>edit_parts_php</strong> permission
		to developer role (if it exists).
	</p>
	<p>
		A side effect of this plugin is ability to make page parts containing php code read only for unauthorised users. 
		You just put any php code into part contents and users without <strong>edit_parts_php</strong> permission won't be able to alter this page part. 
	</p>
	<p>
		Unauthorised users <strong>can't delete</strong> page-parts containing PHP code (new in 0.0.2).
	</p>
	<h3>
		How to restrict PHP code in page parts?
	</h3>
	<p>
		You only need to enable the plugin. By default <strong>only administrators and developers</strong> can edit PHP code. This means that for example all users having only the standard Editor role are
		<strong>not allowed to</strong>:
	</p>
	<ul style="list-style-position: inside; list-style-type: disc; margin-left: 1em;">
		<li>add PHP code blocks into page part content</li>
		<li>edit page parts which already contain PHP code (created by administrator or developer).</li>
	</ul>
	<h3>
		How to allow <em>certain</em> users to edit PHP code?
	</h3>
	<p>
		A specific user can be granted PHP editing permission in two ways:
	</p>
	<ul style="list-style-position: inside; list-style-type: disc; margin-left: 1em;">
		<li>by assigning <strong>Editor Php</strong> role to a selected user individually in standard Wolf Users administration tab</li>
		<li>by assigning <strong>edit_parts_php</strong> permission to an existing role using <strong>Roles Manager</strong> plugin by andrewmman (found in Wolf CMS repository)</li>
	</ul>
</div>