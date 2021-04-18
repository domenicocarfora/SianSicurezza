<?php
/*
Plugin Name:    EUCookieDirectiveLite
Edition:        Lite Edition
Plugin URI:     http://www.channeldigital.co.uk
Description:    A plugin to display a notification to the user about the usage of cookies on the site. It allows the site admin to easily conform with the 
                <a href='http://www.ico.gov.uk/news/latest_news/2011/must-try-harder-on-cookies-compliance-says-ico-13122011.aspx'>EU Cookie Directive</a>.
Version:        1.1.3
Author:         Channel Digital
Author URI:     http://www.channeldigital.co.uk
License			GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html

Copyright (C) 2015, Channel Digital
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, 
THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE 
LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; 
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * Joomla! EU Cookie Directive plugin
 *
 * @package        Joomla
 * @subpackage    System
 */
class  plgSystemEUCookieDirectiveLite extends JPlugin
{
    /**
     * Constructor
     *
     * For php4 compatability we must not use the __constructor as a constructor for plugins
     * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
     * This causes problems with cross-referencing necessary for the observer design pattern.
     *
     * @access    protected
     * @param    object $subject The object to observe
     * @param     array  $config  An array that holds the plugin configuration
     * @since    1.0
     */
    function plgSystemEUCookieDirectiveLite(& $subject, $config)
    {
        parent::__construct($subject, $config);
    
    }

    /**
    * Start the output
    *
    */
    function onAfterRender()
    {
        
        global $mainframe, $database;
        
        //get Params
        $message = $this->params->get('warningMessage', '');
        $privacyLink = $this->params->get('detailsUrl', 'index.php');
        $width = $this->params->get('width', '0');
		$p_policy = JText::sprintf("Cookie Policy");
		$testo_accetta = JText::sprintf("Clicca su ACCETTO per acconsentire all’uso dei cookie e poter continuare ad utilizzare questo sito.");
		$button_accetta = JText::sprintf("Accetto");
		$style_css = $this->params->get("style_css");
		
        //deal with the width options
        if ($width == "0") {
            $width = "100%";
        } else {
            $width = $width . "px";
        }

        $document    = JFactory::getDocument();
        $doctype    = $document->getType();
        $app = JFactory::getApplication();
		
        $ICON_FOLDER = JURI::root() . 'plugins/system/EUCookieDirectiveLite/EUCookieDirectiveLite/images/';        
        
        if ( $app->getClientId() === 0 ) {
            
            $strOutputHTML = "";

            $style = '<style>'.$style_css.'</style>';
        
            $hide = "\n".'<style type="text/css">
                    div#cookieMessageContainer{display:none}
                </style>'."\n";
                
            //Define paths for portability
            //$SCRIPTS_FOLDER = JURI::root() . 'plugins/system/EUCookieDirective/';
            $SCRIPTS_FOLDER = JURI::root() . 'plugins/system/EUCookieDirectiveLite/EUCookieDirectiveLite/';
            $cookiescript = '<script type="text/javascript" src="' . $SCRIPTS_FOLDER . 'EUCookieDirective.js"></script>'."\n";
            
            $strOutputHTML = "";
            $strOutputHTML .= '<div id="outer" style="width:100%">';
            $strOutputHTML .= '<div id="cookieMessageContainer" style="width:' . $width . ';">';
            $strOutputHTML .= '<table width="100%">';
            $strOutputHTML .= '<tr>';
            $strOutputHTML .= '<td>';
            $strOutputHTML .= '<div id="cookieMessageText" style="padding:15px 10px 0 15px;">';
            $strOutputHTML .= '<p style="color:#fff;">' . $message . ' <a id="cookieMessageDetailsLink" class="" style="color:#fff;" href="' . $privacyLink . '">'.$p_policy.'</a>.</p>';
            $strOutputHTML .= '</div>';
            $strOutputHTML .= '</td>';
            $strOutputHTML .= '</tr>';
            $strOutputHTML .= '<tr>';
            $strOutputHTML .= '<td align="center">&nbsp;&nbsp;';
            $strOutputHTML .= '<DIV class="accept"><span class="cookieMessageText">'.$testo_accetta.'</span></DIV></label> ';			
            $strOutputHTML .= '<div border="0" class="BNT-button BNT-button--default BNT-button--neg" id="continue_button" onclick="SetCookie(\'cookieAcceptanceCookie\',\'accepted\',9999);">'.$button_accetta.'</div>';
            $strOutputHTML .= '</td>';
            $strOutputHTML .= '</tr>';
            $strOutputHTML .= '</table>';
            $strOutputHTML .= '</div>';
            $strOutputHTML .= '</div>';

            //Only write the HTML Output if the cookie has not been set as "accepted"
            if(!isset($_COOKIE['cookieAcceptanceCookie']) || (isset($_COOKIE['cookieAcceptanceCookie']) && $_COOKIE['cookieAcceptanceCookie'] != "accepted") )
            { 
                
                $body = JResponse::getBody();
                $body = str_replace('</head>', $style.'</head>', $body);
                $body = str_replace('</body>', $strOutputHTML.$cookiescript.'</body>', $body);
                JResponse::setBody($body);
            }
            elseif($_COOKIE['cookieAcceptanceCookie'] == "accepted") {
                $body = JResponse::getBody();
                $body = str_replace('</head>', $hide.'</head>', $body);
                JResponse::setBody($body);
            }
        }
    }
}