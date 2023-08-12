<?php

namespace Base\Template;

class Button
{
    const TextType = "text";
    const ButtonType = "button";
    const LinkType = "link";
    protected $text;
    protected $type;
    protected $data;
    protected $mailingId;

    public function __construct($buttonData)
    {
        $buttonData = explode(";", $buttonData);

        $this->text = $buttonData[0];
        $this->type = $buttonData[1];
        $this->data = $buttonData[2];
    }

    public function GetText()
    {
        return $this->text;
    }

    public function GetType()
    {
        return $this->type;
    }

    public function SetData($newData)
    {
        $this->data = $newData;
    }

    public function GetData()
    {
        return $this->data;
    }

    public function SetMailingId($newMailingId)
    {
        $this->mailingId = $newMailingId;
    }

    public function PrepareToSend(): array
    {
        $replyMarkup = [
            'text' => $this->text,
        ];

        switch ($this->type) {
            case self::LinkType:
                $replyMarkup["url"] = $this->data;
                break;
            case self::TextType:
                $replyMarkup["callback_data"] = "/usermailing_answer $this->mailingId $this->data";
                break;
            case self::ButtonType:
                $replyMarkup["callback_data"] = "$this->data";
                break;
        }

        return [$replyMarkup];
    }
}
