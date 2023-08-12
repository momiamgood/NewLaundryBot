<?php

namespace Base\Template;

class Template
{
    public $text;
    public $buttons;
    private $templateName;
    private $dataArray;
    private $lang;

    public function __construct($templateName, $lang = null,  $dataArray = null)
    {
        $this->templateName = $templateName;
        $this->dataArray = $dataArray;
        $this->lang = $lang;
    }

    public function Load(): Template
    {
        // загружаю шаблон из файла
        $templateText = file_get_contents(__DIR__ . "Templates/{$this->templateName}.txt");

        if ($this->lang) {
            preg_match_all("/<:$this->lang>(.*?)<\/:$this->lang>/s", $templateText, $text);
            $templateText = $text[1][0];
        }

        $templateText = str_replace("\n", "", $templateText);
        $templateText = str_replace("<:n>", "\n", $templateText);

        // заполняю переменные шаблона
        foreach ($this->dataArray as $item) {
            $templateText = str_replace($item->pattern, $item->replacement, $templateText);
        }

        // заполняю кнопки шаблона
        preg_match_all("/<:buttons>(.*?)<\/:buttons>/", $templateText, $matches);
        $templateButtons = $matches[1];

        $k = 1;
        foreach ($templateButtons as $templateButton) {
            $button = new Button($templateButton);
            if ($button->GetType() == Button::TextType) $button->SetData($k);

            $this->buttons[] = $button;

            $k++;
        }

        $this->text = preg_replace("/<:buttons>(.*?)<\/:buttons>/", "", $templateText);

        return $this;
    }

    public function LoadButtons()
    {
        foreach ($this->buttons as $key => $button) {
            $this->buttons[$key] = $button->PrepareToSend();
        }
    }
}
