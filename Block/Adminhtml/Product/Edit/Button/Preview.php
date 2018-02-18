<?php
/**
 * AGM Preview product and category Plugin
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * It is available on the World Wide Web at:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   AGM Preview product and category Plugin
 * @package    AGM_Preview
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Preview button
 */
namespace AGM\Preview\Block\Adminhtml\Product\Edit\Button;

use Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic;

class Preview extends Generic
{
	/**
     * @var \Magento\Framework\Url
     */
    protected $_url;
	
	/**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
	
	/**
     * @var dataHelper
     */
    protected $dataHelper;
	
	/**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Url $url
	 * @param \Magento\Framework\Registry $registry
	 * @param \AGM\Preview\Helper\Data $dataHelper
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Url $url,
		\Magento\Framework\Registry $registry,
		\AGM\Preview\Helper\Data $dataHelper
    ) {
        $this->_url = $url;
		$this->_coreRegistry = $registry;
		$this->dataHelper = $dataHelper;
    }
	
    /**
     * Preview button
     *
     * @var Data
     */
    public function getButtonData()
    {
		if ($this->dataHelper->allowExtension() && $this->dataHelper->getGeneralConfig("preview_product"))
		{
			$product = $this->_coreRegistry->registry('current_product');
			if($product->isVisibleInCatalog() && $product->isVisibleInSiteVisibility() && ($product->getStatus() == 1))
			{
				$productId 	= $product->getId();
				$previewURL = $this->_url->getUrl('catalog/product/view', ['id' => $productId, '_nosid' => false, '_query' => ['___store' => "admin"]]);

				return 
				[
					'label' 	=> __('Preview'),
					'on_click' 	=> 'window.open(\'' . $previewURL . '\')',
					'class'		=>	'action- scalable',
					'sort_order' => 5,
				];
			}
		}
    }
}