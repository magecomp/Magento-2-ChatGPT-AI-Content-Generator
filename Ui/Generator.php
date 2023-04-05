<?php
namespace Magecomp\Chatgptaicontent\Ui;

use Magecomp\Chatgptaicontent\Model\CompletionConfig;
use Magento\Ui\Component\Container;

class Generator extends Container
{
    public function getConfiguration(): array
    {
        $config = parent::getConfiguration();

        /** @var CompletionConfig $completionConfig */
        $completionConfig = $this->getData('completion_config');

        return array_merge(
            $config,
            $completionConfig->getConfig(),
            [
                'settings' => [
                    'serviceUrl' => $this->context->getUrl('magecomp_chatgptaicontent/generate'),
                    'validationUrl' => $this->context->getUrl('magecomp_chatgptaicontent/validate'),
                ]
            ]
        );
    }
}
