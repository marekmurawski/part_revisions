<?php
/* Security measure */
if (!defined('IN_CMS')) {
	exit();
}

class PartRevisionsController extends PluginController {

	public function __construct() {
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/part_revisions/views/sidebar'));
	}

	public function documentation() {
		// Check for localized documentation or fallback to the default english and display notice
		$lang = ( $user = AuthUser::getRecord() ) ? strtolower($user->language) : 'en';

		if (!file_exists(PLUGINS_ROOT . DS . 'page_part_revisions' . DS . 'views/documentation/' . $lang . '.php')) {
			$this->display('part_revisions/views/documentation/en', array('message' => $message));
		}
		else
			$this->display('part_revisions/views/documentation/' . $lang);
	}
	
	function index() {
		redirect(get_url('plugin/part_revisions/documentation'));
	}	

}