<?php
/**
 * @package Helix Ultimate Framework
 * @author ltheme https://www.ltheme.com
 * @copyright Copyright (c) 2010 - 2018 ltheme
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined ('_JEXEC') or die();

?>
<?php if ($this->error) : ?>
	<div class="error">
		<?php echo $this->escape($this->error); ?>
	</div>
<?php endif; ?>
