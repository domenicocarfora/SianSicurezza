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
echo "<div id='container_items'></div>";
echo "<div id='loading' style='display:block;'><img src=".JUri::base()."images/gifs/wait.gif></div>";
echo "<div class='pagination' style='display:none;'><a class='pag_list'>Mostra Altro</a></div>";
echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>";
echo "<script type='application/javascript'>

jQuery( document ).ready(function() {
 getitems();
jQuery('#apply_filter').click(function() {
    jQuery('#container_items').empty();
     jQuery('#loading').css('display', 'block');
             getitems();
     jQuery('.pagination').css('display', 'block');
        });

jQuery(document).on('click','.pag_list', function() {
    jQuery('#loading').css('display', 'block');
             moreItems();
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
            if(jQuery('.items_list > div').length==0){
                var x=0;
            }else{
            var x=jQuery('.items_list > div').last().attr('id').split('-')[1];
            jQuery('#container_items').empty();
            }
            jQuery.ajax({
                url: 'index.php?option=com_item_everywhere_api&task=items.getItems',
                data: JSON.stringify({cat: filters, last: x}),
                dataType: 'json',
                method: 'POST',
                contentType: 'application/json',
                success: function (data) {
                    if (data=='' || !data){
                        var test='<div id=\"no_items\">Nessun elemento trovato</div>';
                    }else{
                        var test= '<div class=\"items_list\">';
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
                    }
                    jQuery('#container_items').append(test);
                    jQuery('.pagination').css('display', 'block');
                },
        complete: function() {
            $('#loading').css('display', 'none');
        }
                })
}

function moreItems() {
    var filtri=jQuery('select.filter');     
           var filters=[];
           filters.push(".$cat_madre.");
            jQuery.each(filtri,function(){
                if ($( this ).val() != 'none'){
               filters.push(parseInt($( this ).val()));}
            });
            if(jQuery('.items_list > div').length==0){
                var x=0;
            }else{
            var x=jQuery('.items_list > div').last().attr('id').split('-')[1];
            }
            jQuery.ajax({
                url: 'index.php?option=com_item_everywhere_api&task=items.getItems',
                data: JSON.stringify({cat: filters, last: x}),
                dataType: 'json',
                method: 'POST',
                contentType: 'application/json',
                success: function (data) {
                    if (data=='' || !data){
                        var test='<div id=\"no_items\">Non ci sono nuovi elementi</div>';
                        $('.pagination').css('display', 'none');
                    }else{
                        var test='';
                    data.forEach (function(item,index) {
                      test+= '<div class=\"items_ls item-'+
                      item['id'] + '\" id=\"item-' + 
                      item['id'] + '\"><a class=\"no-before\" href=\"".JUri::base()."component/zoo/item/' + 
                      item['alias'] + '\"><div class=\"img_item\"><img class=\"prodotto_immagine\" src=\"".JUri::base()."' + 
                      item['immagine']+'\"></div><div class=\"description\"><div id=\"item_name\"><h1>' + 
                      item['name'] + '</h1></div><div id=\"item_subtitle\"><h3>' + 
                      item['sottotitolo'] + '</h3></div></a><div class=\"short_desc\">'+ item['short_desc'] +'</div></div></div><hr>';
                    })
                    }
                    jQuery('.items_list').append(test);
                },
        complete: function() {
            $('#loading').css('display', 'none');
        }
                })
}

</script>
";
