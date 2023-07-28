<?php

namespace Magecomp\Chatgptaicontent\Model\CompletionRequest;

use Magecomp\Chatgptaicontent\Api\CompletionRequestInterface;
use Magecomp\Chatgptaicontent\Model\Config;

class MetaTitle extends AbstractCompletion implements CompletionRequestInterface
{
    public const TYPE = 'meta_title';
    protected const CUT_RESULT_PREFIX = 'Meta Title: ';

    public function getJsConfig(): ?array
    {
        return [
            'attribute_label' => ' Meta Title',
            'container' => 'product_form.product_form.search-engine-optimization.container_meta_title',
            'prompt_from' => 'product_form.product_form.content.container_description.description',
            'target_field' => 'product_form.product_form.search-engine-optimization.container_meta_title.meta_title',
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
            "max_tokens" => 100,
            "frequency_penalty" => 0,
            "presence_penalty" => 0
        ];
        $metaTitlePrompt = $this->scopeConfig->getValue(Config::XML_PATH_PROMPT_META_TITLE);
        if (strpos($model, 'gpt') !== false) {
            $payload['messages'] = array(
                array(
                    'role' => 'system',
                    'content' => 'You are a helpful assistant.',
                ),
                array(
                    'role' => 'user',
                    'content' => sprintf($metaTitlePrompt, $text),
                ),
            );
        } else {
            $payload['prompt'] = sprintf($metaTitlePrompt, $text);
        }
        return $payload;
    }
}
