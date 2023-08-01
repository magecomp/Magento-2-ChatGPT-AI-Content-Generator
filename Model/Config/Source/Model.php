<?php
namespace Magecomp\Chatgptaicontent\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Model extends AbstractSource
{
    public function getAllOptions()
    {
        return [
            ['value' => 'gpt-4', 'label' => 'gpt-4'],
            ['value' => 'gpt-4-0613', 'label' => 'gpt-4-0613'],
            ['value' => 'gpt-4-32k', 'label' => 'gpt-4-32k'],
            ['value' => 'gpt-4-32k-0613', 'label' => 'gpt-4-32k-0613'],
            ['value' => 'gpt-3.5-turbo', 'label' => 'gpt-3.5-turbo'],
            ['value' => 'gpt-3.5-turbo-0613', 'label' => 'gpt-3.5-turbo-0613'],
            ['value' => 'gpt-3.5-turbo-16k', 'label' => 'gpt-3.5-turbo-16k'],
            ['value' => 'gpt-3.5-turbo-16k-0613', 'label' => 'gpt-3.5-turbo-16k-0613'],
            ['value' => 'text-davinci-003', 'label' => 'text-davinci-003'],
            ['value' => 'text-davinci-002', 'label' => 'text-davinci-002'],
            ['value' => 'text-davinci-001', 'label' => 'text-davinci-001'],
            ['value' => 'text-curie-001', 'label' => 'text-curie-001'],
            ['value' => 'text-babbage-001', 'label' => 'text-babbage-001'],
            ['value' => 'text-ada-001', 'label' => 'text-ada-001'],
            ['value' => 'davinci', 'label' => 'davinci'],
            ['value' => 'curie', 'label' => 'curie'],
            ['value' => 'babbage', 'label' => 'babbage'],
            ['value' => 'ada', 'label' => 'ada'],
        ];
    }
}
