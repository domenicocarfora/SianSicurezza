<?php
	/*
	*
	*/

	if (! class_exists('JFactory') ) {
		define( 'DS', DIRECTORY_SEPARATOR );
		$rootFolder = explode(DS,dirname(__FILE__));
		$currentfolderlevel = 2;

		array_splice($rootFolder,-$currentfolderlevel);

		$base_folder = implode(DS,$rootFolder);


		if(is_dir($base_folder.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'joomla'))
		{
			define( '_JEXEC', 1 );
			define('JPATH_BASE',implode(DS,$rootFolder));

			// Recuperiamo l'istanza del framework joomla
			require_once ( JPATH_BASE .DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'defines.php' );
			require_once ( JPATH_BASE .DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'framework.php' );

			$mainframe =& JFactory::getApplication('site');
			$mainframe->initialise();

			$action = RestUtils::getAction($_SERVER['REQUEST_URI']);

			$GLOBALS['async'] = true;

			$uid = JRequest::getVar('user_id');
			$cid = JRequest::getVar('content_id');
			//$type = JRequest::getVar('type');

//			if(JFactory::getUser()->guest){
//            			die('Access Denied');
//        		}

        		if(JFactory::getUser()->id !== $uid){
            			// disable followItem ajax on other users
            			die('Access Denied');
        		}

			switch ($action)
			{
				case 'addItem':
					return addItem($uid,$cid);
					break;
				case 'removeItem':
					return removeItem($uid,$cid);
					break;
				default:
					return RestUtils::sendResponse(405);
			}
		}
	}


	function addItem($uid,$cid){
		if (!empty($uid) && !empty($cid)) {
            //controllo se l'utente ha già un carrello attivo
			$db = JFactory::getDbo();
			$query="SELECT id FROM #__carrello WHERE id_user=".$uid." AND inviato=0;";
            $id_carrello=$db->loadResult($query);

            //se il carrello non esiste ne creo uno e recupero l'id del nuovo
            if (!$id_carrello){
                $querycreatecarrello="INSERT INTO #__carrello (id_user,data_creazione) VALUES(".$uid.",'".date('d-m-Y')."');";
                $db->setQuery($querycreatecarrello);
                $db->execute();
                $query="SELECT id FROM #__carrello WHERE id_user=".$uid." AND inviato=0;";
                $id_carrello=$db->loadResult($query);
            }

            $query = "INSERT INTO #__carrello_prodotto (id_prodotto,id_carrello,quantita) VALUES($cid,$id_carrello,1) ON DUPLICATE KEY UPDATE quantita = quantita + 1;";
			$db->setQuery($query);
			$db->execute();
			if ($db->getErrorNum()) {
				echo json_encode(array(
					"success" => false,
					"error" => "MYSQL:".$db->getErrorMsg(true)
				));
			}else{
				echo json_encode(array(
					"success" => true,
					"error" => false
				));
			}
		}else{
			echo json_encode(array(
				"success" => false,
				"error" => "sono necessari sia l'id utente che l'id del contenuto"
			));
		}
	}


	function removeItem($uid,$cid){
		if (!empty($uid) && !empty($cid)) {
			$db = JFactory::getDbo();

            $query="SELECT id FROM #__carrello WHERE id_user=".$uid." AND inviato=0;";
            $id_carrello=$db->loadResult($query);

			$query = "DELETE FROM `#__follow_users`
				WHERE id_prodotto = $cid
				AND id_carrello = $id_carrello";

			$db->setQuery($query);
			$db->execute();
			if ($db->getErrorNum()) {
				echo json_encode(array(
					"success" => false,
					"error" => "MYSQL:".$db->getErrorMsg(true)
				));
			}else{
				echo json_encode(array(
					"success" => true,
					"following" => false,
					"error" => false
				));
			}
		}else{
			echo json_encode(array(
				"success" => false,
				"error" => "sono necessari sia l'id utente che l'id del contenuto"
			));
		}
	}

