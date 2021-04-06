<?php
defined('_JEXEC') or die;
echo "<div id='filtri' class='container'>";
foreach ($filter as $filtro){
    echo "<select class='col-xs-12 col-sm-6 col-md-4 col-lg-2 col-xl-2 filter' id='$filtro->name'>";
    echo "<option value='none'>$filtro->name</option>";
    foreach ($filtro->soon as $soon)
        echo "<option value='$soon->id'>$soon->name</option>";
    echo "</select>";
}
echo "</div><br>";
echo "<div><span id='apply_filter' class='btn btn-primary'>Applica filtri</span></div>";
echo "</br><hr>";
echo "<div id='loading' style='display:block;'><img src=".JUri::base()."images/gifs/wait.gif></div>";
echo "<div id='container_items'></div>";
echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>";
echo "<script type='application/javascript'>

jQuery( document ).ready(function() {
 getitems();
jQuery('#apply_filter').click(function() {
    jQuery('#container_items').empty();
     jQuery('#loading').css('display', 'block');
             getitems();
        });
});



function getitems() {
    var filtri=jQuery('select.filter');     
           var filters=[];
           filters.push(".$cat_madre.");
            jQuery.each(filtri,function(){
                if ($( this ).val() != 'none'){
               filters.push(parseInt($( this ).val()));}
            });
            jQuery.ajax({
                url: 'index.php?option=com_item_everywhere_api&task=items.getItems',
                data: JSON.stringify({cat: filters}),
                dataType: 'json',
                method: 'POST',
                contentType: 'application/json',
                success: function (data) {
                    if (data['msg']){
                        var test='<div id=\"no_items\">Nessun elemento trovato</div>';
                    }else{
                        var test= '<id class=\"items_list\">';
                    data.forEach (function(item,index) {
                      test+= '<div class=\"items_ls item-'+
                      item['id'] + '\" id=\"item-' + 
                      item['id'] + '\"><a class=\"no-before\" href=\"".JUri::base()."component/zoo/item/' + 
                      item['alias'] + '\"><div class=\"img_item\"><img class=\"prodotto_immagine\" src=\"".JUri::base()."' + 
                      item['immagine']+'\"></div><div class=\"description\"><div id=\"item_name\"><h1>' + 
                      item['name'] + '</h1></div><div id=\"item_subtitle\"><h3>' + 
                      item['sottotitolo'] + '</h3></div></a><div class=\"short_desc\">'+ item['short_desc'] +'</div></div></div><hr>';
                    })
                    test+='</div>';
                    test+='<ul class=\"pagination\">';
                    for (var i=1; i<=28; i++)
                    test+='<li  class=\"pag_list\"><a class=\"pag_link\" href=\"#\">'+ i +'</a></li>';
                    test+='</ul>';
                    }
                    jQuery('#container_items').append(test);
                },
        complete: function() {
            $('#loading').css('display', 'none');
        }
                })
}
</script>

";
