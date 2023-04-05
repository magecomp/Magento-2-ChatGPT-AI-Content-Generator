<?php
namespace Magecomp\Chatgptaicontent\Block\Adminhtml\Product;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Framework\View\Element\Template;
use Magento\Store\Api\StoreRepositoryInterface;
use Magecomp\Chatgptaicontent\Model\Config;
use Magento\Framework\Serialize\Serializer\Json;

class Helper extends Template
{
    private Config $config;
    private StoreRepositoryInterface $storeRepository;
    private LocatorInterface $locator;
    private Json $json;

    public function __construct(
        Template\Context $context,
        Config $config,
        StoreRepositoryInterface $storeRepository,
        LocatorInterface $locator,
        Json $json,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->config = $config;
        $this->storeRepository = $storeRepository;
        $this->locator = $locator;
        $this->json = $json;
    }

    public function getComponentJsonConfig(): string
    {
        $config = [
            // 'component' => 'Magecomp_Chatgptaicontent/js/view/helper',
            'serviceUrl' => $this->getUrl('Magecomp_Chatgptaicontent/helper/validate'),
            'sku' => $this->locator->getProduct()->getSku(),
            'storeId' => $this->locator->getStore()->getId(),
            'stores' => $this->getStores()
        ];
        return $this->json->serialize($config);
    }

    public function getStores(): array
    {
        $selectedStoreId = (int) $this->locator->getStore()->getId();
        $storeIds = $this->config->getEnabledStoreIds();

        $results = [];
        $first = null;
        foreach ($storeIds as $storeId) {
            $store = $this->storeRepository->getById($storeId);
            if ($selectedStoreId === $storeId) {
                $first = $store;
                continue;
            }
            $results[] = [
                'label' => $storeId === 0 ? __('Default scope') : $store->getName(),
                'store_id' => $storeId,
                'selected' => false
            ];
        }

        if ($first) {
            array_unshift($results, [
                'label' => __('Current scope'),
                'store_id' => $first->getId(),
                'selected' => true
            ]);
        }

        return $results;
    }

    public function toHtml(): string
    {
        $enabled = $this->config->getValue(Config::XML_PATH_ENABLED);
        if (!$enabled) {
            return '';
        }
        return parent::toHtml();
    }
}
