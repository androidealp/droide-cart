<?php
/********************************* DROIDE CART *********************************
********************************************************************************
**********************    _______             _______         ****************
**********************    |@|@|@|@|           |@|@|@|@|         ****************
**********************    |@|@|@|@|   _____   |@|@|@|@|         ****************
**********************    |@|@|@|@| /\_T_T_/\ |@|@|@|@|         ****************
**********************    |@|@|@|@||/\ T T /\||@|@|@|@|         ****************
**********************    ~/T~~T~||~\/~T~\/~||~T~~T\~         ****************
**********************     \|__|_| \(-(O)-)/ |_|__|/         ****************
**********************     _| _|    \\8_8//    |_ |_         ****************
**********************    |(@)]   /~~[_____]~~\   [(@)|         ****************
**********************      ~   (  |       |  )     ~         ****************
**********************         [~` ]       [ '~]         ****************
**********************         |~~|         |~~|         ****************
**********************         |  |         |  |         ****************
**********************        _<\/>_       _<\/>_         ****************
**********************       /_====_\     /_====_\         ****************
******************************************************************************
 * @package     Droide_cart.Module
 * @subpackage  droide_cart
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author 		André Luiz Pereira <[<and4563@gmail.com>]>
 */

defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgAjaxDroide_cart extends JPlugin
{


  public $list_invoque = [
    'products'=>'products',
    'btproduct'=>'btproduct',
    'addproduct'=>'addproduct',
    'removeproduct'=>'removeproduct',
    'subtrair'=>'subtrair'
  ];

  public $cookies = [];


	function onAjaxDroide_cart()
	{

    $app = JFactory::getApplication();
		//$doc = JFactory::getDocument();
		$input = $app->input;
		$invoke  = $input->get('invoke',0,'STRING');
    $post = $input->post->get('product',0,'INTERGER');
    $this->cookies = $input->cookie;
    $return = '';
    if(isset($this->list_invoque[$invoke])){
      switch ($invoke) {
        case 'products':
          $return = $this->getProducts();
          break;
        case 'btproduct':
          $return = $this->getCartBtProduct();
          break;
        case 'addproduct':
          $return = $this->AddProduct($post);
          break;
          case 'removeproduct':
          $return = $this->RemoveProduct($post);
          break;
          case 'subtrair':
          $return = $this->RemoveItemProduct($post);
          break;
        default:
           $return = 'Acesso negado!';
          break;
      } // /switch

    } // /if

    return $return;

	} // /onAjaxDroideCart
  private function RemoveItemProduct($post){
    $quantidade = 1;
    $maincookie = $this->cookies->get('droide-cart','{}', $filter = 'string');

    $valores = json_decode($maincookie,true);
    $retorno = 1;
    if($maincookie && isset($valores[$post]) ){
      if($valores[$post] > 1){
          $valores[$post] -= $quantidade;
          $retorno = $valores[$post];
          $this->cookies->set('droide-cart',json_encode($valores), 0,'/');
      }
    }

    return $retorno;
  }
  private function RemoveProduct($post)
  {
    $quantidade = 1;
    $maincookie = $this->cookies->get('droide-cart','{}', $filter = 'string');
    $valores = json_decode($maincookie,true);
    $return = 0;
    if($maincookie && isset($valores[$post])){
      unset($valores[$post]);
      $this->cookies->set('droide-cart',json_encode($valores), 0,'/');
      $return = 1;
    }
    return $return;
  }
  private function AddProduct($post)
  {
    $quantidade = 1;
    $maincookie = $this->cookies->get('droide-cart','{}', $filter = 'string');
    $valores = [];
    if($maincookie){
      $valores = json_decode($maincookie,true);
    }

    if(isset($valores[$post])){
      $valores[$post] += $quantidade;
      $quantidade = $valores[$post];
    }else{
      $valores[$post] = $quantidade;
    }

    $this->cookies->set('droide-cart',json_encode($valores), 0,'/');

    return $quantidade;


  }

  private function ClearCookie()
  {
    $this->cookies->set('droide-cart', null, time() - 1);
  }

  private function getProducts()
  {
    return 'lista de produtos adicionados';
  }

  private function getCartBtProduct()
  {
    return 'retorno de botoes para os produtos';
  }


} // /plgAjaxDroideCart
