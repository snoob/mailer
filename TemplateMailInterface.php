<?php

namespace Snoob\Component\Mailer;

interface TemplateMailInterface extends \Swift_Mime_Message
{
    /**
     * @return array
     */
    public function getTemplateReference();

    /**
     * Renvoie les variables nécessaires à la generation du template
     * La variable locale (language courante) est automatiquement présente dans ce tableau
     *
     * @return array
     */
    public function getTemplateVars();

    /**
     * @param  array $mailerParameters
     *
     * @return TemplateMailInterface
     */
    public function setParametersFromMailer(array $mailerParameters);

    /**
     * Add a MimePart to this Message.
     *
     * @param string|\Swift_OutputByteStream $body
     * @param string                        $contentType
     * @param string                        $charset
     *
     * @return TemplateMailInterface
     */
    public function addPart($body, $contentType = null, $charset = null);
}