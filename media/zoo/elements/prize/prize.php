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
class ElementPrize extends Element {


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
            return $this->app->html->_('control.text', $this->getControlName('prezzo'), $this->get('prezzo'), 'size="60"');
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
            return "<span class='prize'>€ ".$this->get('prezzo')."</span><br>
            <span class='adviseprize'>* Prezzo di listino da scontare</span>";
        }
	}



}