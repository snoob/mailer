<?php

namespace Snoob\Component\Mailer\Generator;

interface ContentGeneratorInterface
{
    /**
     * @param array $templateReference
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function getTemplateLocation(array $templateReference);

    /**
     * @param  string $templateName
     * @param  array  $parameters
     *
     * @return string
     */
    public function getSubject($templateName, array $parameters = array());

    /**
     * @param  string $templateName
     * @param  array  $parameters
     *
     * @return string
     */
    public function getTextBody($templateName, array $parameters = array());

    /**
     * @param  string $templateName
     * @param  array  $parameters
     *
     * @return string
     */
    public function getHtmlBody($templateName, array $parameters = array());

}