<?php

namespace Snoob\Component\Mailer;

use Snoob\Component\Mailer\Generator\ContentGeneratorInterface;

class TemplateMailer extends \Swift_Mailer implements MailerInterface
{
    /**
     * @var string
     */
    protected $locale;

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @param ContentGeneratorInterface $contentGenerator
     */
    public function __construct(ContentGeneratorInterface $contentGenerator)
    {
        $this->contentGenerator = $contentGenerator;
    }

    /**
     * @return array
     */
    protected function getDefaultsParameters()
    {
        return array('locale' => $this->locale);
    }

    /**
     * @param \Swift_Mime_Message $message
     *
     * throws \RuntimeException
     */
    protected function preSend(\Swift_Mime_Message $message)
    {
        if (!$message instanceof TemplateMailInterface) {
            throw new \RuntimeException('The message must implement the interface Template');
        }
        $message->setParametersFromMailer($this->getDefaultsParameters());
    }

    /**
     * {@inheritDoc}
     */
    public function send(\Swift_Mime_Message $message, &$failedRecipients = null)
    {
        $this->preSend($message);
        return parent::send($message, $failedRecipients);
    }
}