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
class Sky_Core_Block_Onepage extends Mage_Checkout_Block_Onepage {

    public function getSteps(){
    $steps = array ();
    if (! $this->isCustomerLoggedIn ()) {
    $steps ['login'] = $this->getCheckout ()->getStepData ( 'login' );
    }
    $stepCodes = array (
    'billing',
    'shipping',
    'payment',
    'review' 
    );
    foreach ( $stepCodes as $step ) {
    $steps [$step] = $this->getCheckout ()->getStepData ( $step );
    }
    return $steps;
    }

}