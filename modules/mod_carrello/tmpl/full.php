<?php
defined('_JEXEC') or die;
?>

<div id="itemcarrello">

            <?php if(count($carrello)>0){
                echo "<div><table id='listcarrello'>
        <tr class='carr_head' style=''><td></td><td><b>Nome prodotto</b></td><td><b>Quantità</b></td><td></td></tr>";
                foreach ($carrello as $item){
                    echo "<tr class='carr_itm' id='shopitem-".$item->id_prodotto."' style='height: 50px'>
<td><span><img class='img_carrello' src=".$item->immagine."></span></td>
<td><span class='name_carr'>".$item->name."</span></td>   
<td><span> <input class='quantity quantity_full' data-id_prod=".$item->id_prodotto." value=".$item->quantita." type='number' id='quantity' name='quantity'/></span> </td>  
<td><span class='butt_rem_carr'><img class='removebuttonfull remove button' src='images/icone/elimina.svg' aria-label=rimuovi data-id='".$item->id_prodotto."'></span></td></tr>";
                };
                echo "</div>";
            }else{
                echo "<span><b>Il tuo carrello è vuoto</b></span>";
            } ?>
    </table>
</div></div>
<div class="text_code"><em>Aggiungi un prodotto al carrello tramite il suo codice</em></div>
<div class="add_item_carr">
    <input class='prod_name inp_carr' placeholder="Inserisci nome prodotto" type='text' id='prod_name' name='prod_name'/>
    <input class='prod_quant quantity_full inp_carr' value="1" type='number' id='prod_quant' name='prod_quant'/>
    <input id="add_prod" class="btn btn-primary inp_carr" type="submit" value="Aggiungi prodotto"/>
</div>

<div class="text_desc">Richiedi il tuo preventivo e riceverai lo sconto a te riservato.</div>
    <div class="text_desc_no_marg">Ti risponderemo nel minor tempo possibile.</div>
<div class="send"><p style="display: flex;"><input id="send" class="btn btn-primary" type="submit" value="Richiesta preventivo"/></p></div>

<script type="text/javascript">

    jQuery(document).ready(function($) {


        function removeItem(id_prodotto){

            jQuery.ajax({
                url: '<?php echo JURI::base() ?>index.php?option=com_carrello_api&task=removeItem&Itemid='+id_prodotto,
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    console.log($('#shopitem-'+id_prodotto));
                    if (data.success) {
                        $('#shopitem-'+id_prodotto).remove();
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

        function updateItem(id_prodotto,quantita){

            jQuery.ajax({
                url: '<?php echo JURI::base() ?>index.php?option=com_carrello_api&task=updatequantita&Itemid='+id_prodotto+'&quantita='+quantita,
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                    }else{
                        alert('Errore nel cambiare la quantità');
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log({
                        text: errorThrown.message,type:'error'
                    });
                }
            });

        }

        function sendcarrello(){

            jQuery.ajax({
                url: '<?php echo JURI::base() ?>index.php?option=com_carrello_api&task=inviacarrello',
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        alert("Richiesta di preventivo correttamente inviato");
                        location.reload();
                    }else{
                        alert(data.message);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log({
                        text: errorThrown.message,type:'error'
                    });
                }
            });

        }

        function addItem(name,quantita){

            jQuery.ajax({
                url: '<?php echo JURI::base() ?>index.php?option=com_carrello_api&task=additem&Itemname='+name+'&quantita='+quantita,
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        alert('Prodotto aggiunto con successo al carrello');
                        location.reload();
                    }else{
                        alert('Non è stato possibile aggiungere il prodotto al carrello');
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log({
                        text: errorThrown.message,type:'error'
                    });
                }
            });

        }

        jQuery('.remove').click(function() {
                id_prodotto=($(this).data('id'));
                removeItem(id_prodotto);
        });

        jQuery('.quantity').change(function() {
            quantita=this.value;
             id_prodotto=($(this).data('id_prod'));
             updateItem(id_prodotto,quantita);
        });

        jQuery('#add_prod').click(function() {
            jQuery('#add_prod').addClass('disabled');
            quantita=jQuery('#prod_quant').val();
            name=jQuery('#prod_name').val();
            addItem(name,quantita);
            jQuery('#add_prod').removeClass('disabled');
        });

        jQuery('#send').click(function() {
            sendcarrello();
        });

    });

</script>