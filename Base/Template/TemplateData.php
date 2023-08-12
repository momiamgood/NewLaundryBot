<?php

namespace Base\Template;

class TemplateData
{
    public $pattern;
    public $replacement;

    public function __construct($pattern, $replacement)
    {
        $this->pattern = $pattern;
        $this->replacement = $replacement;
    }
}