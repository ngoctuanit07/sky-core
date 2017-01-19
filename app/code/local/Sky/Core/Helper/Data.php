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
class Sky_Core_Helper_Data extends Mage_Core_Helper_Abstract {
 
	public function isEnabled(){
		$status = Mage::getStoreConfig('score/settings/status');		
		return $status;
	}
	
}