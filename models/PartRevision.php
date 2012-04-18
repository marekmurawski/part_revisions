<?php

/**
 * class PagePartRevision
 */
class PartRevision extends Record {
    const TABLE_NAME = 'page_part_revision';

    public $name = 'body';
    public $filter_id = '';
    public $content = '';
    public $content_html = '';
    public $page_id = 0;
    public $updated_on;
    public $updated_by_id;


    public function beforeSave() {
    // apply filter to save is generated result in the database
	$this->updated_on = date('Y-m-d H:i:s');
        $this->updated_by_id = AuthUser::getId();
	
        if ( ! empty($this->filter_id))
            $this->content_html = Filter::get($this->filter_id)->apply($this->content);
        else
            $this->content_html = $this->content;

        return true;
    }

    public static function findByPageId($id) {
        return self::findAllFrom(self::tableNameFromClassName('PartRevision'), 'page_id='.(int)$id.' ORDER BY id');
    }

    public static function deleteByPageId($id) {
        return self::$__CONN__->exec('DELETE FROM '.self::tableNameFromClassName('PartRevision').' WHERE page_id='.(int)$id) === false ? false: true;
    }

} // end PagePart class