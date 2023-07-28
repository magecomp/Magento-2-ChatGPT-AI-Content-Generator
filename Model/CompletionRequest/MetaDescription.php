<?php

namespace Magecomp\Chatgptaicontent\Model\CompletionRequest;

use Magecomp\Chatgptaicontent\Api\CompletionRequestInterface;
use Magecomp\Chatgptaicontent\Model\Config;

class MetaDescription extends AbstractCompletion implements CompletionRequestInterface
{
    public const TYPE = 'meta_description';
    protected const CUT_RESULT_PREFIX = 'Meta Description: ';

    public function getJsConfig(): ?array
    {
        return [
            'attribute_label' => 'Meta Description',
            'container' => 'product_form.product_form.search-engine-optimization.container_meta_description',
            'prompt_from' => 'product_form.product_form.content.container_description.description',
            'target_field' => 'product_form.product_form.search-engine-optimization.container_meta_description.meta_description',
            'component' => 'Magecomp_Chatgptaicontent/js/button',
        ];
    }

    public function getApiPayload(string $text): array
    {
        parent::validateRequest($text);
        $model = $this->scopeConfig->getValue(Config::XML_PATH_MODEL);
        $payload =  [
            "model" => $model,
            "n" => 1,
            "temperature" => 0.5,
            "max_tokens" => 255,
            "frequency_penalty" => 0,
            "presence_penalty" => 0
        ];
        $metaDescPrompt = $this->scopeConfig->getValue(Config::XML_PATH_PROMPT_META_DESCRIPTION);
        if (strpos($model, 'gpt') !== false) {
            $payload['messages'] = array(
                array(
                    'role' => 'system',
                    'content' => 'You are a helpful assistant.',
                ),
                array(
                    'role' => 'user',
                    'content' => sprintf($metaDescPrompt, $text),
                ),
            );
        } else {
            $payload['prompt'] = sprintf($metaDescPrompt, $text);
        }
        return $payload;
    }
}
