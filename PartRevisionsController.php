<?php
/* Security measure */
if (!defined('IN_CMS')) {
	exit();
}

class PartRevisionsController extends PluginController {
	
	const VIEW_FOLDER = "../../plugins/part_revisions/views/";
	
	public function __construct() {
//		AuthUser::load();
//		if (!(AuthUser::isLoggedIn())) {
//		redirect(get_url('login'));
//		}
//
//		if (!AuthUser::hasPermission('admin_view')) {
//		redirect(URL_PUBLIC);
//		}

		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/part_revisions/views/sidebar'));
	}

	public function purgebypage($id) {
		PartRevision::deleteByPageId($id);
		Flash::set('success',__('All page part revisions for page id :id deleted!', array(':id'=>$id)));
		redirect(get_url('page/edit/'.$id));
	}

	public function purgeall() {
		PartRevision::deleteWhere('PartRevision', '1=1');
		Flash::set('success',__('All page part revisions in ALL pages deleted!'));
		redirect(get_url('plugin/part_revisions/documentation'));
	}
	
	public function preview($id) {
		$part = PartRevision::findOneFrom('PartRevision','id='.$id);
		echo htmlentities($part->content);
	}

	public function diff($id) {
		AutoLoader::addFile('SimpleDiff',PLUGINS_ROOT.'/part_revisions/lib/SimpleDiff.php');
		AutoLoader::load('SimpleDiff');
		$old = PartRevision::findOneFrom('PartRevision','id='.(int)$id);
		$new = PagePart::findOneFrom('PagePart', 'page_id=? AND name=?', array($old->page_id,$old->name));
		echo nl2br(SimpleDiff::htmlDiff(htmlentities($old->content),htmlentities($new->content)));
	}
	
	public function getlist() {
		echo new View('../../plugins/part_revisions/views/editpage/parts_list', array(
			'page_id'           => $_POST['page_id'],
			'part_name_to_show' => $_POST['name'],
		));
	}	
	
	public function delete($id,$page_id) { // @todo: IN AJAX $page_id will be obsolete
		PartRevision::deleteById($id);
		Flash::set('success',__('Deleted part revision [id - :id]!', array(':id'=>$id)));
		($page_id!=0) ? redirect(get_url('page/edit/'.$page_id)) : redirect(get_url('plugin/part_revisions/recent'));
	}
	
	public function documentation() {
		// Check for localized documentation or fallback to the default english and display notice
		$lang = ( $user = AuthUser::getRecord() ) ? strtolower($user->language) : 'en';

		if (!file_exists(PLUGINS_ROOT . DS . 'page_part_revisions'.DS.'views'.DS.'documentation'.DS. $lang . '.php')) {
			$this->display('part_revisions'.DS.'views'.DS.'documentation'.DS.$lang);
			}
	}
	
	function index() {
		redirect(get_url('plugin/part_revisions/recent'));
	}	

	function recent() {
		$this->display('part_revisions/views/recent', array(
			));
	}
	
	public static function Callback_view_page_edit_tab_links($page) {
                    echo '<li class="tab"><a href="#'.PR_CSS_ID.'_tabcontents">'. __('Part revisions') . '</a></li>';
	}
        
	public static function Callback_view_page_edit_tabs(& $page) {
                    echo new View(self::VIEW_FOLDER.'editpage/tabcontents', array(
                            'page_id' => $page->id,
                    )); 
	}	

	public static function Callback_view_page_edit_popup($page) {
                    echo new View(self::VIEW_FOLDER.'editpage/popup_part_preview', array(
                            'page_id' => $page->id,
                    )); 
	}	
}