<?php
defined( '_JEXEC' ) or die;
class modItemEverywhereHelper{
    static function getItem($params){
        $db = JFactory::getDBO();
        $query="SELECT DISTINCT jzi.id,jzi.name,jzi.alias,
                REPLACE(JSON_EXTRACT(JSON_EXTRACT(jzi.elements,'$.\"c26feca6-b2d4-47eb-a74d-b067aaae5b90\"'),'$.\"file\"'),'\"','') as immagine,
                REPLACE(JSON_EXTRACT(JSON_EXTRACT(JSON_EXTRACT(elements,'$.\"08795744-c2dc-4a68-8252-4e21c4c4c774\"'),'$.\"0\"'),'$.\"value\"'),'\"','') as sottotitolo
                FROM #__zoo_item jzi
                WHERE jzi.application_id=1 AND (publish_down IS NULL OR publish_down>sysdate()) ORDER BY publish_up DESC LIMIT ".(int)$params->get('limit');
        $db->setQuery($query);
        $obj = $db->loadObjectList();
        $items=array();
        foreach ($obj as $item){
            $categoryitem=self::getCategoryItem($item->id);
            $item->categories=$categoryitem;
            $items[]=$item;
        }
    return $items;
    }

    static function getCategoryItem($item){
        $db = JFactory::getDBO();
        $querycategory="SELECT id,name,alias FROM #__zoo_category_item JOIN #__zoo_category ON category_id=id WHERE item_id=".$item;
        $db->setQuery($querycategory);
        $category = $db->loadObjectList();
        return $category;
    }

    static function getFilter($params){
        $filtri= $params->get('filtri');
        $filtrimadre=array();
        foreach ($filtri as $filtro){
            $db = JFactory::getDBO();
            $querycategoryfather="SELECT id,name FROM #__zoo_category WHERE id=".(int)$filtro;
            $db->setQuery($querycategoryfather);
            $categoryfather=$db->loadObject();
            $filtro=$categoryfather;
            $querycategorysoon="SELECT id,name FROM #__zoo_category WHERE parent=".(int)$filtro->id;
            $db->setQuery($querycategorysoon);
            $categorysoon=$db->loadObjectList();
            $filtro->soon=$categorysoon;
            $filtriabilitati[] = $filtro;
        }
        return $filtriabilitati;
    }

}
?>