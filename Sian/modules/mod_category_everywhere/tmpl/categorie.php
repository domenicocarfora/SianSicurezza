<?php
defined('_JEXEC') or die;
?>

<div class="row">

<div class="img_category">
    <?php
    foreach ($categorie as $categoria){
        if ($categoria->parent=='0'){
        $parametri=json_decode($categoria->params,true);
        echo "<div class='col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 imgcat'>";
        echo "<a href='".JURI::root(). $categoria->path."'>";
        echo "<span class='catname'><b>$categoria->name</b></span>";
        echo "<img class='catlogo' src='". JURI::root().$parametri['content.image']. "' alt='$categoria->name'>";
        echo "</a>";
        echo "</div>";}}
    ?>

</div>
</div>
