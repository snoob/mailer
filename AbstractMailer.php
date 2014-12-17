<?php

namespace Snoob\Component\Mailer;

abstract class AbstractMailer extends \Swift_Mailer implements MailerInterface
{
    /**
     * @var array
     */
    protected $parameters;

    /**
     * @param array $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return array
     */
    protected function getParameters()
    {
        return $this->parameters;
    }

    //@TODO a remplacer par un event de swiftmailer
    /**
     * @param \Swift_Mime_Message $message
     *
     * throws \RuntimeException
     */
    abstract protected function preSend(\Swift_Mime_Message $message);

    /**
     * {@inheritDoc}
     */
    public function send(\Swift_Mime_Message $message, &$failedRecipients = null)
    {
        $this->preSend($message);
        return parent::send($message, $failedRecipients);
    }
}