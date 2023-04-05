<?php

namespace Magecomp\Chatgptaicontent\Model\CompletionRequest;

use Magecomp\Chatgptaicontent\Api\CompletionRequestInterface;

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
        return [
            "model" => "text-davinci-003",
            "prompt" => sprintf("Create HTML meta title (only content) of the following product:\n%s", $text),
            "n" => 1,
            "temperature" => 0.5,
            "max_tokens" => 100,
            "frequency_penalty" => 0,
            "presence_penalty" => 0
        ];
    }
}
