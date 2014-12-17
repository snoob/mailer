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
     * @param TemplateMailInterface $message
     */
    protected function generateMessageContent(TemplateMailInterface $message)
    {
        $templateLocation = $this->contentGenerator->getTemplateLocation($message->getTemplateReference());
        if ($message->getSubject() === null) {
            $message->setSubject($this->contentGenerator->getSubject($templateLocation, $message->getTemplateVars()));
        }
        $message->setBody($this->contentGenerator->getTextBody($templateLocation, $message->getTemplateVars()));
        $message->addPart($this->contentGenerator->getHtmlBody($templateLocation, $message->getTemplateVars()));
    }

    //@TODO a remplacer par un event de swiftmailer
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
        $this->generateMessageContent($message);
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