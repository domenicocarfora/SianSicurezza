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
        $query = self::getItemsByCategoryQuery($categories);
        $db = JFactory::getDbo();
        $db->setQuery($query, 0);
        $ids = $db->loadColumn();
        if (!empty($ids)){
        $items= self::getByIds($ids);
        echo json_encode($items);
        exit();}else {
            echo json_encode(array("msg"=>"no items"));exit();
        }

    }

    static function getByIds($ids){
        $db = JFactory::getDBO();
        $query="SELECT DISTINCT jzi.id,jzi.name,jzi.alias,
                REPLACE(JSON_EXTRACT(JSON_EXTRACT(jzi.elements,'$.\"c26feca6-b2d4-47eb-a74d-b067aaae5b90\"'),'$.\"file\"'),'\"','') as immagine,
                REPLACE(JSON_EXTRACT(JSON_EXTRACT(JSON_EXTRACT(elements,'$.\"08795744-c2dc-4a68-8252-4e21c4c4c774\"'),'$.\"0\"'),'$.\"value\"'),'\"','') as sottotitolo
                FROM #__zoo_item jzi
                WHERE jzi.application_id=1 AND (publish_down IS NULL OR publish_down>sysdate()) AND jzi.id in (".implode(',', $ids).");";

        $db->setQuery($query);
        $items = $db->loadObjectList();
        return $items;
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