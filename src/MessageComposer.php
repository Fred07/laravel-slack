<?php

namespace Fred\SlackService;

/**
 * 透過 template 點綴 Message
 *
 * Class MessageComposer
 * @package Fred\SlackServiceProvider
 */
class MessageComposer
{
    public const DEFAULT_TEMPLATE_PATH = __DIR__ . '/templates/ExceptionTemplate.php';

    /**
     * @var string
     */
    private $templatePath;

    /**
     * @var Message
     */
    private $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return Message
     */
    public function getMessage(): Message
    {
        return $this->message;
    }

    /**
     * @param string $templatePath
     * @return MessageComposer
     */
    public function useTemplate(string $templatePath): self
    {
        $this->templatePath = $templatePath;
        return $this;
    }

    /**
     * 傳入陣列套用 template 變數
     * key 為 template 變數名稱，value 為要顯示的值
     * example:
     * [
     *     'exceptionTitle' => 'Exception:',
     *     'exceptionContent' => 'division by zero!',
     * ]
     *
     * @param array $data
     * @return MessageComposer
     */
    public function apply(array $data): self
    {
        // 套用 key 為變數名稱
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        $templatePath = $this->templatePath ?? self::DEFAULT_TEMPLATE_PATH;
        $data = require $templatePath;

        $this->message->setBlocks($data['blocks']);
        $this->message->setAttachments($data['attachments']);
        return $this;
    }
}