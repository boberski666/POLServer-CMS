<?php
class NewsModel extends Model {
    public function __construct() {
        parent::__construct('news', function() {
        	$inst = R::xdispense( 'news' );
			$inst->published = date('Y-m-d G:i:s');
			$inst->author = '';
			$inst->title = '';

			R::store( $inst );
            R::wipe( 'news' );
        });
    }
    
    public function loadAllNewsASC() {
        //$news = parent::loadAll();
        $news = parent::loadByQuery('ORDER BY published ASC',[]);
        
        foreach ($news as &$value) {
            $sub = new SubnewsModel();
            $value['elements'] = $sub->loadSubnews($value->id);
        }
        
        return $news;
    }
    
    public function loadAllNewsDESC() {
        //$news = parent::loadAll();
        $news = parent::loadByQuery('ORDER BY published DESC',[]);
        
        foreach ($news as &$value) {
            $sub = new SubnewsModel();
            $value['elements'] = $sub->loadSubnews($value->id);
        }
        
        return $news;
    }
    
}