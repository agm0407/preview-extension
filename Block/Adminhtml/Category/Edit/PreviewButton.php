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

namespace AGM\Preview\Block\Adminhtml\Category\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Catalog\Block\Adminhtml\Category\AbstractCategory;

/**
 * Class PreviewButton
 */
class PreviewButton extends AbstractCategory implements ButtonProviderInterface
{
	/**
     * @var \Magento\Framework\Url
     */
    protected $_url;

	/**
     * @var dataHelper
     */
    protected $dataHelper;
	
	/**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Url $url
	 * @param \AGM\Preview\Helper\Data $dataHelper
	 * @param \Magento\Framework\Registry $registry
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
		\Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Category\Tree $categoryTree,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Framework\Url $url,
		\AGM\Preview\Helper\Data $dataHelper,
		array $data = []
    ) {
        $this->_url = $url;
		$this->dataHelper = $dataHelper;
		parent::__construct($context,$categoryTree,$registry,$categoryFactory,$data);
    }

    /**
     * Delete button
     *
     * @return array
     */
    public function getButtonData()
    {
		if ($this->dataHelper->allowExtension() && $this->dataHelper->getGeneralConfig("preview_categories"))
		{
			$category = $this->_coreRegistry->registry('category');
			$categoryId = (int)$category->getId();

			if ($categoryId && !in_array($categoryId, $this->getRootIds()) && $category->isDeleteable()) {
				return [
					'id' => 'preview',
					'label' => __('Preview'),
					'on_click' 	=> 'window.open(\'' . $this->getPreviewUrl() . '\')',
					'class' => 'action- scalable',
					'sort_order' => 15
				];
			}
		}
        return [];
    }

    /**
     * @param array $args
     * @return string
     */
    public function getPreviewUrl(array $args = [])
    {
		$category 	= $this->_coreRegistry->registry('category');
        $categoryId = (int)$category->getId();
		
		return $this->_url->getUrl('catalog/category/view', ['id' => $categoryId, '_nosid' => false, '_query' => ['___store' => "admin"]]);
    }
}