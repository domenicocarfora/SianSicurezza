<?php
defined('_JEXEC') or die;
$user= JFactory::getUser();
if ($user){
echo "<div class='active_user'>CIAO <a href='".JUri::base()."/profilo'>".$user->name."</a></div>";
}