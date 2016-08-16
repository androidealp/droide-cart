<?php
defined('_JEXEC') or die;
class LibrarieExemplo{

public $extencion = [
  '.jpg',
  '.png',
  '.gif'
];

public function TratarFields($html)
{
  $dom = new DOMDocument;
 $checkbox = "";
 $dom->loadHTML($html);
 $select = $dom->getElementsByTagName('select');
 $contents = $dom->getElementsByTagName('option');
 $getLabel = $dom->getElementsByTagName('label');
 $boxFiltro = [];
 for ($i=0; $i < $contents->length; $i++) {
   $checkbox .= "<li><input type='checkbox' name='".$select->item(0)->getAttribute('name')."' value='".$contents->item($i)->getAttribute('value')."' /> ".$contents->item($i)->textContent.'</li>';
 }

 $boxFiltro = [
    'checkbox'=>$checkbox,
    'label'=>utf8_decode($getLabel->item(0)->textContent)
   ];

 return $boxFiltro;

}

public function getCookiesId($id)
{
  $app = JFactory::getApplication();
  $input = $app->input->cookie;
  $droidecart = $input->get('droide-cart','{}', $filter = 'string');
  $arraycart = json_decode($droidecart,true);
  return isset($arraycart[$id])?$arraycart[$id]:0;
  //return
}

public function getListProduct()
{
  $app = JFactory::getApplication();
  $input = $app->input->cookie;
  $droidecart = $input->get('droide-cart','{}', $filter = 'string');
  $arraycart = json_decode($droidecart,true);

  $items_id = array_keys($arraycart);
  $results = [];
  if($items_id){
    $items_id = implode(',',$items_id);
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select(array('id', 'title'));
    $query->from('#__k2_items');
    $query->where('id in('.$items_id.')');
    $db->setQuery($query);
     $getBD = $db->loadObjectList();

     foreach ($getBD as $k => $k2item) {
       $results[] = [
         'id'=>$k2item->id,
         'title'=>$k2item->title,
         'qtde'=>$arraycart[$k2item->id],
       ];
     }

  }

  return $results;
}

public function GetImagesGallery($directory)
{
  $images = [];
  if(is_dir($directory)){
    foreach ($this->extencion as $k => $ext) {
      $getimages = glob($directory."*".$ext);
      foreach ($getimages as $i => $image) {
        $images[] = $image;
      }
    }
  }
  return $images;
}

public function addScriptFile($script=false, $id_principal='img_01', $id_galery= 'gal1'){
  $document = JFactory::getDocument();
  JHtml::_('jquery.framework');
  //$document->addScript(JURI::base(true).'/templates/next4_itapua/js/jquery-1.8.3.min.js');
  $document->addScript(JURI::base(true).'/templates/next4_itapua/js/jquery.elevatezoom.js');
 if(!$script){
   $script = <<<HTML
   jQuery(function($){
     $('#zoom_01').elevateZoom({
         zoomType: "inner",
     cursor: "crosshair",
     zoomWindowFadeIn: 500,
     zoomWindowFadeOut: 750
        });
    //  $('#{$id_principal}').elevateZoom({gallery:{$id_galery}, cursor: 'pointer', galleryActiveClass: 'active', imageCrossfade: true, loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'});
     //
    //   $('#{$id_principal}').bind("click", function(e) {
    //     var ez =   $('#{$id_principal}').data('elevateZoom');
    //   	$.fancybox(ez.getGalleryList());
    //     return false;
    //   });
   });
HTML;
 }
 //$document->addScriptDeclaration($script);

}


public function getRelativoFabricante($tags)
{
  // [link] => /itapua/index.php/feminino/item/4-rasteira-daily-nobuck-tan-new
  // [printLink] => /itapua/index.php/feminino/item/4-rasteira-daily-nobuck-tan-new?tmpl=component&print=1
  $html = '';
    foreach ($tags as $item => $tag){
      $html .= '<li>';
      $html .= '<a style="width: 100%;height: 100%;position:absolute;z-index: 10;" href="'.$tag->link.'"></a>';
      $html .= '<img class="imagem-slides" src="'.$tag->imageSmall.'"  />'; // imageXSmall,imageSmall, imageMedium, imageLarge, imageLarge, imageXLarge, imageGeneric
      $html .= '</li>';
    }//fim foreach

  return $html;
}


}
