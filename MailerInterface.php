<?php

namespace Snoob\Component\Mailer;

/**
 * This interface will become useless when SwiftMailer team will create their own mailer interface.
 */
interface MailerInterface
{
    /**
     * @see \Swift_Mailer
     *
     * @param  \Swift_Mime_Message $message
     * @param  array               $failedRecipients An array of failures by-reference
     *
     * @return int
     */
    public function send(\Swift_Mime_Message $message, &$failedRecipients = null);
}