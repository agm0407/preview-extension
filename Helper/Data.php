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
namespace AGM\Preview\Helper;

use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	const XML_PATH = 'agm_preview/';
	
	/**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
	protected $_storeManager;
	
	/**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		\Magento\Store\Model\StoreManagerInterface $storeManager
	) 
	{
		$this->_storeManager = $storeManager;
		parent::__construct($context);
	}
	
	public function getConfigValue($field, $storeId = null)
	{
		return $this->scopeConfig->getValue(
			$field, ScopeInterface::SCOPE_STORE, $storeId
		);
	}
	
	public function allowExtension()
	{
		return $this->getConfigValue(self::XML_PATH .'general/enable_preview', $this->getStoreId());
	}

	public function getGeneralConfig($code)
	{
		return $this->getConfigValue(self::XML_PATH .'general/'. $code, $this->getStoreId());
	}
	
	/**
     * Get store identifier
     *
     * @return  int
     */
    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }
}