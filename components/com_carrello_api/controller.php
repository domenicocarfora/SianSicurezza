<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Carrello_api
 * @author      <>
 * @copyright  
 * @license    
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

use \Joomla\CMS\Factory;

/**
 * Class Carrello_apiController
 *
 * @since  1.6
 */
class Carrello_apiController extends \Joomla\CMS\MVC\Controller\BaseController
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean $cachable  If true, the view output will be cached
	 * @param   mixed   $urlparams An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController   This object to support chaining.
	 *
	 * @since    1.5
     * @throws Exception
	 */
	public function display($cachable = false, $urlparams = false)
	{
        $app  = Factory::getApplication();
        $view = $app->input->getCmd('view', '//XXX_DEFAULT_VIEW_XXX');
		$app->input->set('view', $view);

		parent::display($cachable, $urlparams);

		return $this;
	}

	public function updatequantita(){
        $uid=Factory::getUser()->id;
        $cid=(int) Factory::getApplication()->input->get('Itemid');
        $quantita=(int) Factory::getApplication()->input->get('quantita');
        if (empty($quantita) || $quantita=='')
        {$quantita=0;}
        if (!empty($uid) && !empty($cid)) {
            //controllo se l'utente ha già un carrello attivo
            $db = JFactory::getDbo();
            $querycarrello="SELECT id FROM #__carrello WHERE id_user=".$uid." AND inviato=0;";
            $id_carrello=$db->setQuery($querycarrello)->loadResult();
            //se il carrello non esiste ne creo uno e recupero l'id del nuovo
            if (!$id_carrello){
                $querycreatecarrello="INSERT INTO #__carrello (id_user,data_creazione) VALUES(".$uid.",'".date('d-m-Y')."');";
                $db->setQuery($querycreatecarrello);
                $db->execute();
                $query="SELECT id FROM #__carrello WHERE id_user=".$uid." AND inviato=0;";
                $id_carrello=$db->loadResult($query);
            }

            $query = "UPDATE #__carrello_prodotto SET quantita=$quantita WHERE id_prodotto=$cid AND id_carrello=$id_carrello;";
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
        exit();
    }

    public function inviacarrello(){
        $uid=Factory::getUser()->id;
        $db = JFactory::getDbo();
        $querycarrello="SELECT id FROM #__carrello WHERE id_user=".$uid." AND inviato=0;";
        $id_carrello=$db->setQuery($querycarrello)->loadResult();
        if (!empty($uid) && !empty($id_carrello)) {

            $queryitemcarrello="SELECT zi.name,cp.quantita FROM #__zoo_item zi
                JOIN #__carrello_prodotto cp ON zi.id=cp.id_prodotto
                JOIN #__carrello c ON cp.id_carrello=c.id 
                WHERE cp.quantita<>0 and c.id=$id_carrello AND c.id_user=".$uid;

            $db->setQuery($queryitemcarrello);
            $itemcarrello = $db->loadAssocList();
            if ($this->sendcarrello($itemcarrello,$id_carrello)){

            $query = "UPDATE #__carrello SET inviato=1, data_invio='".date('Y-m-d')."' WHERE id=$id_carrello;";
            $db->setQuery($query);}else {
                echo json_encode(array(
                    "success" => false,
                    "error" => "Errore nell'invio dell'email"
                ));
            }
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
        exit();
    }


   public function addItem(){
       $db = JFactory::getDbo();
	    $uid=Factory::getUser()->id;
	    $cid=(int) Factory::getApplication()->input->get('Itemid');
       $name=Factory::getApplication()->input->get('Itemname');
       $quantita=(int) Factory::getApplication()->input->get('quantita');
       if ($name!=null || $name!=''){
           $query = "SELECT id FROM #__zoo_item WHERE name='".$name."' AND state=1;";
           $cid=$db->setQuery($query)->loadResult();
       }
        if (!empty($uid) && !empty($cid)) {
            //controllo se l'utente ha già un carrello attivo
            $querycarrello="SELECT id FROM #__carrello WHERE id_user=".$uid." AND inviato=0;";
            $id_carrello=$db->setQuery($querycarrello)->loadResult();
            //se il carrello non esiste ne creo uno e recupero l'id del nuovo
            if (!$id_carrello){
                $querycreatecarrello="INSERT INTO #__carrello (id_user,data_creazione) VALUES(".$uid.",'".date('d-m-Y')."');";
                $db->setQuery($querycreatecarrello);
                $db->execute();
                $query="SELECT id FROM #__carrello WHERE id_user=".$uid." AND inviato=0;";
                $id_carrello=$db->setQuery($query)->loadResult();
            }
            $query = "INSERT INTO #__carrello_prodotto (id_prodotto,id_carrello,quantita) VALUES($cid,$id_carrello,$quantita) ON DUPLICATE KEY UPDATE quantita = quantita + $quantita;";
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
        exit();
    }


    public function removeItem(){
        $uid=Factory::getUser()->id;
        $cid=(int) Factory::getApplication()->input->get('Itemid');

        if (!empty($uid) && !empty($cid)) {
            $db = JFactory::getDbo();

            $query="SELECT id FROM #__carrello WHERE id_user=".$uid." AND inviato=0;";
            $id_carrello=$db->setQuery($query)->loadResult();

            $query = "DELETE FROM #__carrello_prodotto
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
                    "error" => false
                ));
            }
        }else{
            echo json_encode(array(
                "success" => false,
                "error" => "sono necessari sia l'id utente che l'id del contenuto"
            ));
        }
        exit();
    }


public function sendcarrello($itemcarrello,$id_carrello){
    $config = JFactory::getConfig();
    $mail = JFactory::getMailer();
    $sender = array(
        $config->get('mailfrom'),
        $config->get('fromname')
    );
    $user=Factory::getUser();
    $body="L'utente ".$user->name." ha richiesto un preventivo per i seguenti prodotti: <br>";
    $pathfile= JPATH_BASE."/ordini_csv/".$id_carrello.".csv";
    $fp = fopen($pathfile, 'w');
    $firstRow=true;
    foreach ($itemcarrello as $result){
        if($firstRow){
            $header[0]="Cod.";$header[1]="Q.tà";
            fputcsv($fp, $header);
            $firstRow=false;
        }
        fputcsv($fp, $result);
    }
    fclose($fp);
    foreach ($itemcarrello as $oggetto){
        $body.=$oggetto['name']." Quantità: ".$oggetto['quantita']." <br>";
    }
    $body.="L'id del carrello è: ".$id_carrello;
    $body.=" <br>L'email dell'utente è: ".$user->email;
    $mail->SMTPAuth = false;
    $mail->isHTML(true);
    $mail->setSender($sender);
    $to=explode(";", "commerciale@siansicurezza.it");
    $mail->addAttachment($pathfile);
    $mail->addRecipient($to);
    $mail->setBody($body);
    $mail->setSubject("Richiesta preventivo");
    try {
        $x=$mail->Send();
        } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
        return false;
    }
    return true;
}

}
