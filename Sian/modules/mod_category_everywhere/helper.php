<?php
defined( '_JEXEC' ) or die;
class modCategoryEverywhereHelper{
    static function getCategories($params){
        $db = JFactory::getDBO();
        $query="SELECT a.id, a.name, a.parent, a.params, jm.path FROM #__zoo_category a JOIN joo_menu jm ON a.alias = jm.alias WHERE a.published=1 AND a.application_id=1";
        if ($params->get('tutte')!='1'){
            $query.=" AND a.parent=".$params->get('categoria');
        }
        $db->setQuery($query);
        $categorie = $db->loadObjectList();
        //var_dump($categorie);exit();
    return $categorie;
    }

}
?>