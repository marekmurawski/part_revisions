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
    public $updated_by_name;


    public function beforeSave() {
    // apply filter to save is generated result in the database
	$this->updated_on = date('Y-m-d H:i:s');
        $this->updated_by_id = AuthUser::getId();
        $this->updated_by_name = AuthUser::getUserName();
	
        if ( ! empty($this->filter_id))
            $this->content_html = Filter::get($this->filter_id)->apply($this->content);
        else
            $this->content_html = $this->content;

        return true;
    }

    public static function findByPageId($id) {
        return self::findAllFrom('PartRevision', 'page_id='.(int)$id.' ORDER BY updated_on DESC'); 
    }

    public static function findByPageIdAndName($id,$name) {
        return self::findAllFrom('PartRevision', 'page_id=? AND name=? ORDER BY updated_on DESC', array($id, $name)); 
    }
    
    public static function findExistingNamesByPageId($id) {
	$existingParts = PagePart::findByPageId($id);
	Record::findAllFrom('PagePart', 'page_id='.(int)$id.' ORDER BY id');

	$sql = 'SELECT name FROM '.self::tableNameFromClassName('PagePart').' WHERE page_id=? ORDER BY id ASC';
        $stmt = self::$__CONN__->prepare($sql);
        $stmt->execute(array($id));

        self::logQuery($sql);

        $existingParts = array();
        while ($object = $stmt->fetch())
            $existingParts[] = $object['name'];
	
        return $existingParts;
    }	    

    public static function findNamesByPageId($id) {
	$sql = 'SELECT DISTINCT name FROM '.self::tableNameFromClassName('PartRevision').' WHERE page_id=? ORDER BY name ASC';

        $stmt = self::$__CONN__->prepare($sql);
        $stmt->execute(array($id));

        self::logQuery($sql);

        $savedParts = array();
        while ($object = $stmt->fetch())
            $savedParts[] = $object['name'];

        return $savedParts;
    }
    
    public static function deleteByPageId($id) {
	    self::deleteWhere('PartRevision', 'page_id='.(int)$id);
    }

    public static function deleteById($id) {
	    self::deleteWhere('PartRevision', 'id='.(int)$id);
    }
    
} // end PagePart class