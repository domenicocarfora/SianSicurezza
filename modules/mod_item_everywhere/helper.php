<?php
defined( '_JEXEC' ) or die;
class modItemEverywhereHelper{
    static function getItem($params){
        $db = JFactory::getDBO();
        $query="SELECT DISTINCT jzi.id,jzi.name,jzi.alias,
                REPLACE(JSON_EXTRACT(JSON_EXTRACT(jzi.elements,'$.\"c26feca6-b2d4-47eb-a74d-b067aaae5b90\"'),'$.\"file\"'),'\"','') as immagine,
                REPLACE(JSON_EXTRACT(JSON_EXTRACT(JSON_EXTRACT(elements,'$.\"08795744-c2dc-4a68-8252-4e21c4c4c774\"'),'$.\"0\"'),'$.\"value\"'),'\"','') as sottotitolo,
                REPLACE(JSON_EXTRACT(JSON_EXTRACT(JSON_EXTRACT(elements,'$.\"e59e537d-79f3-46d6-8c98-1ef606d98eba\"'),'$.\"0\"'),'$.\"value\"'),'\"','') as short_desc
                FROM #__zoo_item jzi
                WHERE jzi.application_id=1 AND state=1 AND (publish_down IS NULL OR publish_down>sysdate()) AND REPLACE(JSON_EXTRACT(params,'$.\"config.primary_category\"'),'\"','') NOT IN (6,11,12,17,18,21,25,146) ORDER BY id DESC LIMIT ".(int)$params->get('limit');
        $db->setQuery($query);
        $obj = $db->loadObjectList();
    return $obj;
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
            $produttori= $params->get('produttori');
            $ottica= $params->get('ottica');
            $risoluzione= $params->get('risoluzione');
            $codec= $params->get('codec');
            $poe= $params->get('poe');
            $series= $params->get('serie');
            if ($filtro->id == '27'){
                //se filtro è produttori e non sono stati specificati produttori specifici li mostro tutti
                if ($produttori == '' || $produttori == null){
                    $querycategorysoon="SELECT id,name FROM #__zoo_category WHERE parent=".(int)$filtro->id;
                    $db->setQuery($querycategorysoon);
                    $categorysoon=$db->loadObjectList();
                    $filtro->soon=$categorysoon;
                }else{
                foreach ($produttori as $produttore){
                    $querycategorysoon="SELECT id,name FROM #__zoo_category WHERE id=".(int)$produttore;
                    $db->setQuery($querycategorysoon);
                    $categorysoon=$db->loadObject();
                    $filtro->soon[]=$categorysoon;
                }}
            }elseif ($filtro->id == '35'){
                //se filtro è ottica/zoom e non sono stati specificati produttori specifici li mostro tutti
                if ($ottica == '' || $ottica == null){
                    $querycategorysoon="SELECT id,name FROM #__zoo_category WHERE parent=".(int)$filtro->id;
                    $db->setQuery($querycategorysoon);
                    $categorysoon=$db->loadObjectList();
                    $filtro->soon=$categorysoon;
                }else{
                    foreach ($ottica as $ott){
                        $querycategorysoon="SELECT id,name FROM #__zoo_category WHERE id=".(int)$ott;
                        $db->setQuery($querycategorysoon);
                        $categorysoon=$db->loadObject();
                        $filtro->soon[]=$categorysoon;
                    }
            }} elseif ($filtro->id == '58'){
                //se filtro è Risoluzione e non sono stati specificati produttori specifici li mostro tutti
                if ($risoluzione == '' || $risoluzione == null){
                    $querycategorysoon="SELECT id,name FROM #__zoo_category WHERE parent=".(int)$filtro->id;
                    $db->setQuery($querycategorysoon);
                    $categorysoon=$db->loadObjectList();
                    $filtro->soon=$categorysoon;
                }else{
                    foreach ($risoluzione as $ris){
                        $querycategorysoon="SELECT id,name FROM #__zoo_category WHERE id=".(int)$ris;
                        $db->setQuery($querycategorysoon);
                        $categorysoon=$db->loadObject();
                        $filtro->soon[]=$categorysoon;
                    }
                }} elseif ($filtro->id == '102'){
                //se filtro è codec e non sono stati specificati produttori specifici li mostro tutti
                if ($codec == '' || $codec == null){
                    $querycategorysoon="SELECT id,name FROM #__zoo_category WHERE parent=".(int)$filtro->id;
                    $db->setQuery($querycategorysoon);
                    $categorysoon=$db->loadObjectList();
                    $filtro->soon=$categorysoon;
                }else{
                    foreach ($codec as $cod){
                        $querycategorysoon="SELECT id,name FROM #__zoo_category WHERE id=".(int)$cod;
                        $db->setQuery($querycategorysoon);
                        $categorysoon=$db->loadObject();
                        $filtro->soon[]=$categorysoon;
                    }
                }}elseif ($filtro->id == '158'){
                //se filtro è POE e non sono stati specificati produttori specifici li mostro tutti
                if ($poe == '' || $poe == null){
                    $querycategorysoon="SELECT id,name FROM #__zoo_category WHERE parent=".(int)$filtro->id;
                    $db->setQuery($querycategorysoon);
                    $categorysoon=$db->loadObjectList();
                    $filtro->soon=$categorysoon;
                }else{
                    foreach ($poe as $p){
                        $querycategorysoon="SELECT id,name FROM #__zoo_category WHERE id=".(int)$p;
                        $db->setQuery($querycategorysoon);
                        $categorysoon=$db->loadObject();
                        $filtro->soon[]=$categorysoon;
                    }
                }}elseif ($filtro->id == '64'){
                //se filtro è Serie e non sono stati specificati produttori specifici li mostro tutti
                if ($series == '' || $series == null){
                    $querycategorysoon="SELECT id,name FROM #__zoo_category WHERE parent=".(int)$filtro->id;
                    $db->setQuery($querycategorysoon);
                    $categorysoon=$db->loadObjectList();
                    $filtro->soon=$categorysoon;
                }else{
                    foreach ($series as $serie){
                        $querycategorysoon="SELECT id,name FROM #__zoo_category WHERE id=".(int)$serie;
                        $db->setQuery($querycategorysoon);
                        $categorysoon=$db->loadObject();
                        $filtro->soon[]=$categorysoon;
                    }
                }} else{
            $querycategorysoon="SELECT id,name FROM #__zoo_category WHERE parent=".(int)$filtro->id;
            $db->setQuery($querycategorysoon);
            $categorysoon=$db->loadObjectList();
            $filtro->soon=$categorysoon;
            }
            $filtriabilitati[] = $filtro;
        }
        return $filtriabilitati;
    }

}
?>
