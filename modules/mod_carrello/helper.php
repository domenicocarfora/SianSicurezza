<?php
defined( '_JEXEC' ) or die;
class modCarrelloHelper{
    static function getcarrello($params){

        $user=JFactory::getUser();
        $db = JFactory::getDBO();

        $query="SELECT zi.name,cp.quantita,cp.id_prodotto,cp.id_carrello,
                REPLACE(JSON_EXTRACT(JSON_EXTRACT(zi.elements,'$.\"c26feca6-b2d4-47eb-a74d-b067aaae5b90\"'),'$.\"file\"'),'\"','') as immagine
                FROM #__zoo_item zi
                JOIN #__carrello_prodotto cp on zi.id=cp.id_prodotto
                JOIN #__carrello c on cp.id_carrello=c.id 
                WHERE zi.state=1 and cp.quantita<>0 and c.inviato=0 and c.id_user=".$user->id;
       // var_dump($query);exit();

        $db->setQuery($query);
        $carrello = $db->loadObjectList();

        return $carrello;
    }


}
?>