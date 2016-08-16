<?php
/**
 * @package     Droideforms.Module
 * @subpackage  droideforms
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author 		André Luiz Pereira <[<andre@next4.com.br>]>
 */

defined('_JEXEC') or die;

JLoader::register('LibrarieExemplo', JPATH_LIBRARIES . '/librarie-exemplo.php');
$HelperItens = new LibrarieExemplo();

$lista = $HelperItens->getListProduct();

?>




<div class="uk-grid uk-margin-large-top">
  <div class="uk-width-medium-1-3">
    <?php echo $module->content; ?>
  </div>
  <div class="uk-width-medium-2-3">

 <form id="<?=$params->get('id_form');?>" class="uk-form" method="POST" action="" data-extension="<?=$idmodule; ?>" data-droidevalid='<?=($validacao)?$validacao:''; ?>' >

       <div data-uk-grid-margin="" class="uk-grid uk-grid-width-1-1">
           <div class="uk-row-first"><input type="text" class="uk-width-1-1" placeholder="Nome completo" kl_virtual_keyboard_secure_input="on"></div>
           <div class="uk-grid-margin uk-row-first"><input type="tel" class="uk-width-1-1" placeholder="Telefone" kl_virtual_keyboard_secure_input="on"></div>
           <div class="uk-grid-margin uk-row-first"><input type="email" class="uk-width-1-1" placeholder="Endereço de email"></div>
           <div class="uk-grid-margin uk-row-first"><textarea class="uk-width-1-1" placeholder="Sua mensagem" rows="4"></textarea></div>

          <?php if ($lista): ?>
            <div class="uk-grid-margin uk-row-first">
              <table class="uk-table uk-table-striped uk-table-hover">
                <thead>
                  <tr>
                      <th>Nome do produto</th>
                      <th class="uk-text-center">Quantidade</th>
                      <th class="uk-text-center">Remover</th>
                  </tr>
                 </thead>
                 <tbody>
                   <?php foreach ($lista as $k => $produto): ?>
                     <tr>
                         <td><?=$produto['title']; ?></td>
                         <td class="uk-width-2-10 uk-text-center">
                           <a class="uk-button uk-button-primary uk-button-mini" data-droidecart="<?=$produto['id']?>" href="#"><i class="uk-icon-plus"></i></a>
                           <span class="uk-margin-small-left uk-margin-small-right total-droidecart"><?=$produto['qtde']; ?></span>
                           <a class="uk-button uk-button-danger uk-button-mini" data-subdroidecart="<?=$produto['id']?>" href="#"><i class="uk-icon-minus"></i></a>
                         </td>
                         <td class="uk-width-2-10 uk-text-center">

                           <a class="uk-button uk-button-danger uk-button-mini" data-deldroidecart="<?=$produto['id']?>" href="#"><i class="uk-icon-remove"></i></a>
                         </td>
                     </tr>
                   <?php endforeach; ?>

                </tbody>
              </table>
            </div>

          <?php endif; ?>
          <div class="uk-grid-margin uk-row-first"><button class="uk-button uk-button-large uk-button-primary"><i class="uk-icon-send"></i> Enviar Mensagem</button></div>
       </div>

    </form>
  </div>
</div>
<script type="text/javascript">
var j = jQuery.noConflict();

j(document).ready(function(){
// my custm class
sendDroideForms.alert_class = 'uk-alert uk-alert-';
//my cystom load
 sendDroideForms.divLoad = function(){
  return "<p class='uk-text-center'><i class='uk-icon-spinner uk-icon-spin'></i></p>";
 };

 // my custom alert
 // sendDroideForms.alert = function(type, addtext){
 //   j(sendDroideForms.id_form+'_alert').remove();
 //   j(sendDroideForms.id_form).before(
 //     j('<div/>',{
 //           id: sendDroideForms.id_form.replace('#', '')+'_alert',
 //           class:sendDroideForms.alert_class+type,
 //           html: addtext
 //       })
 //     );
 // };
});
</script>
