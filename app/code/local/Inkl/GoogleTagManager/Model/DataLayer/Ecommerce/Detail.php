<?php

use Inkl\GoogleTagManager\GoogleTagManager;

class Inkl_GoogleTagManager_Model_DataLayer_Ecommerce_Detail
{

	/**
	 * @param GoogleTagManager $googleTagManager
	 */
	public function handle(GoogleTagManager $googleTagManager)
	{
		if (!$this->isEnabled() || !Mage::helper('inkl_googletagmanager/route')->isProduct())
		{
			return;
		}
		$product = $this->getProduct();

		$ecommerce = [
			'detail' => [
				'actionField' => [],
				'products' => [[
					'id' => $product->getSku(),
					'name' => $product->getName(),
					'price' => round(Mage::helper('tax')->getPrice($product, $product->getFinalPrice(), false ), 2),
				]]
			]
		];

		$googleTagManager->addDataLayerVariable('ecommerce', $ecommerce, 'ecommerce_detail');
	}

	private function getProduct()
	{
		return Mage::registry('current_product');
	}


	private function isEnabled()
	{
		return Mage::helper('inkl_googletagmanager/config_dataLayer_ecommerce')->isDetailEnabled();
	}

}
