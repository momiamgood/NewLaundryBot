<?php

namespace Base\Core;

class Telegram extends Request {
    public function sendMessage($chat_id, $text, $buttons = NULL, $buttonType = 'inline')
    {
        $content = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html',
            'disable_web_page_preview' => 'true'
        ];

        // Если переданы кнопки то добавляем их к сообщению
        if (isset($buttons) && is_array($buttons)) {
            switch ($buttonType){
                case 'inline':
                    $content['reply_markup'] = $this->buildInlineKeyBoard($buttons);
                    break;
                case 'remove':
                    $content['reply_markup'] = $this->ReplyKeyboardRemove();
                    break;
                case 'keyboard':
                    $content['reply_markup'] = $this->buildKeyBoard($buttons);
            }
        }

        return $this->request('sendMessage', $content);
    }

    /** Задаем inline кнопку
     * @param array $buttons
     * @return string
     */
    public function buildInlineKeyBoard(array $buttons)
    {
        $replyMarkup = [
            'inline_keyboard' => $buttons,
        ];

        return json_encode($replyMarkup, true);
    }

    public function ReplyKeyboardRemove()
    {
        $replyMarkup = [
            'remove_keyboard' => true,
        ];

        return json_encode($replyMarkup, true);
    }

    /** кнопка клавиатуры номер телефона и геолокация
     * @param $text
     * @param bool $request_contact
     * @param bool $request_location
     * Пример:
     * $buttons_phone[] = [
     * $this->buildKeyboardButton("☎️ Отправить номер"),
     * ];
     * $this->sendMessage($chat_id, "Отправьте номер телефона", $buttons_phone, 0);
     * @return string
     */
    public function buildKeyboardButton($text, $request_contact = false, $request_location = true): string
    {
        $replyMarkup = [
            'text' => $text,
            'request_contact' => $request_contact,
            'request_location' => $request_location,
        ];

        return json_encode($replyMarkup, true);
    }

    /** Готовим набор кнопок клавиатуры
     * @param array $options
     * @param bool $onetime
     * @param bool $resize
     * @param bool $selective
     * @return string
     */
    function buildKeyBoard(array $options, bool $onetime = false, bool $resize = true, bool $selective = true): string
    {
        $replyMarkup = [
            'keyboard' => $options,
            'one_time_keyboard' => $onetime,
            'resize_keyboard' => $resize,
            'selective' => $selective,
        ];

        return json_encode($replyMarkup, true);
    }
}