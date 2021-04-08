<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.modellist');
class Item_everywhere_apiModelItems extends JModelList
{
    /**
     * Constructor
     *
     * @param    array          An optional associative array of configuration settings
     *
     * @see      JController
     * @since    1.6
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
    }

    public function getItems()
    {
        $categories=json_decode(JFactory::getApplication()->input->json->getRaw())->cat;
        $last=json_decode(JFactory::getApplication()->input->json->getRaw())->last;
        $query = self::getItemsByCategoryQuery($categories);
        $db = JFactory::getDbo();
        $db->setQuery($query);
        $ids = $db->loadColumn();
        if (!empty($ids)){
        $items= self::getByIds($ids,$last);
        echo json_encode($items);
        exit();}else {
            echo json_encode(array("msg"=>"no items"));exit();
        }

    }

    static function getByIds($ids,$last=0){
        $db = JFactory::getDBO();
        $query="SELECT DISTINCT jzi.id,jzi.name,jzi.alias,
                REPLACE(JSON_EXTRACT(JSON_EXTRACT(jzi.elements,'$.\"c26feca6-b2d4-47eb-a74d-b067aaae5b90\"'),'$.\"file\"'),'\"','') as immagine,
                REPLACE(JSON_EXTRACT(JSON_EXTRACT(JSON_EXTRACT(elements,'$.\"08795744-c2dc-4a68-8252-4e21c4c4c774\"'),'$.\"0\"'),'$.\"value\"'),'\"','') as sottotitolo,
                REPLACE(JSON_EXTRACT(JSON_EXTRACT(JSON_EXTRACT(elements,'$.\"e59e537d-79f3-46d6-8c98-1ef606d98eba\"'),'$.\"0\"'),'$.\"value\"'),'\"','') as short_desc
                FROM #__zoo_item jzi
                WHERE jzi.application_id=1 AND (publish_down IS NULL OR publish_down>sysdate()) AND jzi.id in (".implode(',', $ids).") ORDER BY jzi.id LIMIT ".$last.",10;";

        $db->setQuery($query);
        $items = $db->loadObjectList();
        $items_def=array();
        foreach ($items as $item){
            $item->short_desc=str_replace('\r\n',' ',$item->short_desc);
            $items_def[]=$item;
        }
        return $items_def;
    }


    static function getItemsByCategoryQuery($categories = array()){
        $query="select item_id, group_concat(category_id) cats from joo_zoo_category_item group by item_id having";
        foreach ($categories as $cat){
            $query.=" cats like '%".$cat."%' and";
        }
        $query=substr($query,0,-4);
        return $query;
    }
}