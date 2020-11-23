<?php

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class BlankComponentController extends JControllerLegacy
{

	public function display($cachable = false, $urlparams = false)
	{
		JRequest::setVar('view','default'); // force it to be the search view
                $this->testArea();
		return parent::display($cachable, $urlparams);
	}

        public function testArea()
        {
            $myID = JFactory::getUser()->id;
            
            /**
             * Library per
             * LUser
             * LGroup o LAgency
             * LGamification - prize - event - 
             * LQuiz
             * LMenu (dopo)
             * ...
             */
            
            //LTest::doTests();
            
            

        }
        
}
