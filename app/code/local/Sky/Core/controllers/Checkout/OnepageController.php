<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade SolrBridge to newer
 * versions in the future.
 *
 * @category    Sky
 * @package     Sky_Core
 * @author      Sky Team
 * @copyright   Copyright (c) 2016-2017 Sky Team
 */
if (Mage::helper ( 'skycore' )->isEnabled ()) {
 require_once Mage::getModuleDir ( 'controllers', 'Mage_Checkout' ) . DS . 'OnepageController.php';
 class Sky_Core_Checkout_OnepageController extends Mage_Checkout_OnepageController {
 
  public function saveBillingAction() {
   parent::saveBillingAction ();
   if ($this->getRequest ()->isPost ()) {
    $this->checkAndSetShippingMethod ();
   }
  }
  public function saveShippingAction() {
   parent::saveShippingAction ();
   if ($this->getRequest ()->isPost ()) {
    $this->checkAndSetShippingMethod ();
   }
  }
  
  protected function checkAndSetShippingMethod() {
   if (Mage::helper ( 'skycore' )->isEnabled ()) {
    $result = Mage::helper ( 'core' )->jsonDecode ( $this->getResponse ()->getBody () );
    if (! isset ( $result ['error'] ) && isset ( $result ['goto_section'] ) && $result ['goto_section'] == 'shipping_method') {
     $code = $this->_getShippingCode ();
     if (is_null ( $code )) {
      $result = array (
        'error' => 1,
        'message' => array (
          'fds' 
        ) 
      );
     } else {
      $result = $this->getOnepage ()->saveShippingMethod ( $code );
      if (! $result) {
       Mage::dispatchEvent ( 'checkout_controller_onepage_save_shipping_method', array (
         'request' => $this->getRequest (),
         'quote' => $this->getOnepage ()->getQuote () 
       ) );
       $this->getOnepage ()->getQuote ()->getShippingAddress ()->collectTotals ()->save ();
       $result ['goto_section'] = 'payment';
       $result ['allow_sections'] = array (
         'shipping' 
       );
       $result ['update_section'] = array (
         'name' => 'payment-method',
         'html' => $this->_getPaymentMethodsHtml () 
       );
      }
     }
     $this->getResponse ()->setBody ( Mage::helper ( 'core' )->jsonEncode ( $result ) );
    }
   }
  }
  
  protected function _getPaymentMethodsHtml() {
   $layout = $this->getLayout ();
   $update = $layout->getUpdate ();
   $update->setCacheId ( 'LAYOUT_' . Mage::app ()->getStore ()->getId () . md5 ( 'checkout_onepage_paymentmethod' ) );
   $update->load ( 'checkout_onepage_paymentmethod' );
   $layout->generateXml ();
   $layout->generateBlocks ();
   $output = $layout->getOutput ();
   return $output;
  }
  
  protected function _getShippingCode() {
   $code = 'freeshipping_freeshipping';
   return $code;
  }
 }
 
} else {
}

