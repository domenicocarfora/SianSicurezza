<?php
defined( '_JEXEC' ) or die;
class modBrandPartnerHelper{
    static function getPartner($params){
        $db = JFactory::getDBO();

        $query="SELECT * FROM #__brandpartner WHERE state=1";
        if ($params->get('quantita')!='0' && $params->get('quantita')!='' && !$params->get('quantita')){
            $query .= " LIMIT " .$params->get('quantita');
        }
        $db->setQuery($query);
        $partners = $db->loadObjectList();

        return $partners;
    }

}
?>