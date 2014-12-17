<?php

namespace Snoob\Component\Mailer;

class TemplateMailer extends AbstractMailer
{
    /**
     * @var ContentGeneratorInterface
     */
    protected $contentGenerator;

    /**
     * @param ContentGeneratorInterface $contentGenerator
     */
    public function setContentGenerator(ContentGeneratorInterface $contentGenerator)
    {
        $this->contentGenerator = $contentGenerator;
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

    /**
     * {@inheritDoc}
     */
    protected function preSend(\Swift_Mime_Message $message)
    {
        if (!$message instanceof TemplateMailInterface) {
            throw new \RuntimeException('The message must implement the interface Template');
        }
        $message->setParametersFromMailer($this->getParameters());
        $this->generateMessageContent($message);
    }
}
