<?php

namespace Fred\SlackService;

class Message
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var array
     */
    private $attachments = [];

    /**
     * @var array
     */
    private $blocks = [];

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $channel;

    /**
     * @var bool
     */
    private $enableMrkDwnInText = true;

    /**
     * Message constructor.
     *
     * @param string $text
     */
    public function __construct(string $text = '')
    {
        $this->text = $text;
    }

    /**
     * @param array $blocks
     *
     * @return self
     */
    public function setBlocks(array $blocks): self
    {
        $this->blocks = $blocks;

        return $this;
    }

    /**
     * @param array $attachment
     *
     * @return self
     */
    public function attach(array $attachment): self
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * @param array $attachments
     *
     * @return self
     */
    public function setAttachments(array $attachments): self
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * @param string $username
     *
     * @return self
     */
    public function from(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param string $channel
     *
     * @return self
     */
    public function to(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @param string $text
     *
     * @return self
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return array
     */
    public function getBlocks(): array
    {
        return $this->blocks;
    }

    /**
     * @return array
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * @param bool $enable
     */
    public function enableMrkDwnInText(bool $enable): void
    {
        $this->enableMrkDwnInText = $enable;
    }

    /**
     * @return string
     */
    public function createPayload(): string
    {
        $payload = [];

        $payload['text'] = $this->text;
        $payload['channel'] = $this->channel;
        $payload['mrkdwn'] = $this->enableMrkDwnInText;

        if ($this->username) {
            $payload['username'] = $this->username;
        }

        if (!empty($this->blocks)) {
            $payload['blocks'] = $this->blocks;
        }

        if (!empty($this->attachments)) {
            $payload['attachments'] = $this->attachments;
        }

        return json_encode($payload, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }
}
