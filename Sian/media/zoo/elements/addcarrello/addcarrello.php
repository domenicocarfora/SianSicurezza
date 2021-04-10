<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

/*
	Class: ElementRating
		The rating element class
*/
class ElementAddcarrello extends Element {


	/*
		Function: hasValue
			Checks if the element's value is set.

	   Parameters:
			$params - render parameter

		Returns:
			Boolean - true, on success
	*/
	public function hasValue($params = array()) {
		return true;
	}

    public function getSearchData() {

        $value=$this->get('value','');
        return (empty($value) ? null : $value);
    }

	

	/*
	   Function: edit
	       Renders the edit form field.

	   Returns:
	       String - html
	*/
    public function edit() {
        if (!empty($this->_item)) {
            return $this->app->html->_('select.booleanlist', $this->getControlName('value'), $this->get('value'),true);
        }
    }


    /*
        Function: render
            Renders the element.

       Parameters:
            $params - render parameter

        Returns:
            String - html
    */
	public function render($params = array()) {
        if (!empty($this->_item)) {
            if ($this->get('value')=='1'){
            return " <div><input type='number' id='quantitymodal' name='quantity' value='1'/><br>
 <button id='aggiungicarrello' class='btn btn-primary'>Aggiungi al carrello</button></div>

<script type='application/javascript'>

function addcarrello(id_prodotto,quantita){

            jQuery.ajax({
                url: '". JURI::base()."index.php?option=com_carrello_api&task=addItem&Itemid='+id_prodotto+'&quantita='+quantita,
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                    alert('Il prodotto è stato aggiunto al carrello')
                    location.reload();
                    }else{
                    alert('Non è stato possibile aggiungere il prodotto al carrello')
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log({
                        text: errorThrown.message,type:'error'
                    });
                }
            });

        }
        
        jQuery('#aggiungicarrello').click(function() {
            quantita=jQuery('#quantitymodal').val();
             id_prodotto=".$this->_item->id.";
             addcarrello(id_prodotto,quantita);
        });
        
</script>
";/*
            return "
<span id='aggiungicarrello'><a class='btn btn-primary' href='#modaladd' role='button' data-toggle='modal'>Aggiungi al carrello</a></span>
<div id='modaladd' class='panel' style='display: none;'>
<div class='modal-content'>
        <div class='modal-body'>
        <span>Inserisci la quantità</span>
        <input type='number' id='quantitymodal' name='quantity' value='1'/>
<button id='addcarrello' class='btn btn-primary'>Aggiungi al carrello</button>
</div>
</div>
</div>

<script type='text/javascript'>

function addcarrello(id_prodotto,quantita){

            jQuery.ajax({
                url: '". JURI::base()."index.php?option=com_carrello_api&task=addItem&Itemid='+id_prodotto+'&quantita='+quantita,
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                    alert('Il prodotto è stato aggiunto al carrello')
                    }else{
                        console.log(data);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log({
                        text: errorThrown.message,type:'error'
                    });
                }
            });

        }
        
        jQuery('#addcarrello').click(function() {
            quantita=jQuery('#quantitymodal').val();
             id_prodotto=".$this->_item->id.";
             addcarrello(id_prodotto,quantita);
        });
        
</script>
"; */

        }else{
                return "<div id='nondisponibile'>Prodotto attualmente non disponibile</div>";
            }
        }
	}



}