<?php
defined('_JEXEC') or die;
?>
<div class="row">
<div class="category container">
    <?php
    foreach ($categorie as $categoria){
        $parametri=json_decode($categoria->params,true);
        echo "<div class='col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 imgcat'>";
        echo "<a href='".JURI::root(). $categoria->path."'>";
        echo "<span class='catname'><b>$categoria->name</b></span>";
        echo "<img class='catlogo' src='". JURI::root().$parametri['content.image']. "' alt='$categoria->name' title='$categoria->name'>";
        echo "</a>";
        echo "</div>";}
    ?>

</div>
</div>
