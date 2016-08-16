/**
 * Eventos para manipulação do carrinho via ajax
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author     André Luiz Pereira <[<and4563@gmail.com.br>]>
 */


jQuery(function($){

  /*
   * Adiciona recurto de evento o type pode ser addproduct, removeproduct
  */
  function actionEvents(droidecart, produto,type){

    htmlbutton = '';

    $.ajax({
      type: "POST",
      url: "index.php?option=com_ajax&plugin=droide_cart&format=json&invoke="+type,
      data:{product:produto},
      beforeSend:function(){
        htmlbutton = droidecart.html();
        droidecart.html('<i class="uk-icon-spinner uk-icon-spin"></i>');
      },
      success:function(data)
      {
        //console.log(data);
        if(data.success){
          if(type == 'removeproduct'){
            if(data.data[0] == 1){
                droidecart.parent('td').parent('tr').remove();
            }
          }else{
            droidecart.html(htmlbutton);
            if(type == 'subtrair'){
                droidecart.prev('.total-droidecart').html(data.data[0]);
            }else{
              droidecart.next('.total-droidecart').html(data.data[0]);
            }

          }


        }

      },
      error:function( jqXHR , textStatus,errorThrown){
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
      }
    });

  }

$(document).on('click','[data-deldroidecart]',function(e){
  e.preventDefault();
  droidecart = $(this);
  produto = droidecart.data('deldroidecart');
  actionEvents(droidecart, produto,'removeproduct');
}); // end click

$(document).on('click','[data-droidecart]',function(e){
  e.preventDefault();
  droidecart = $(this);
  produto = droidecart.data('droidecart');
  actionEvents(droidecart, produto,'addproduct');
}); // end click

$(document).on('click','[data-subdroidecart]',function(e){
  e.preventDefault();
  droidecart = $(this);
  produto = droidecart.data('subdroidecart');
  actionEvents(droidecart, produto,'subtrair');
}); // end click



}); // end jQuery
