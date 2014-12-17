<?php

namespace Snoob\Component\Mailer\Twig;

use Snoob\Component\Mailer\Generator\ContentGeneratorInterface;

class TwigContentGenerator implements ContentGeneratorInterface
{
    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param  string $templateLocation
     * @param  string $block
     * @param  array  $parameters
     *
     * @return string
     */
    protected function renderBlock($templateLocation, $block, array $parameters)
    {
        /** @var \Twig_Template $template */
        $template = $this->twig->loadTemplate($templateLocation);

        return $template->renderBlock($block, $parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplateLocation(array $templateReference)
    {
        if (count($templateReference) === 0) {
            throw new \InvalidArgumentException(json_encode($templateReference) . ' is an invalid template reference');
        }
        $namePrefix = 'mails';
        if ($templateReference['locale'] !== null) {
            $namePrefix .= '/' . $templateReference['locale'];
        }
        return '@' . $templateReference['bundle'] . '/' . $namePrefix . '/' . $templateReference['name'] . '.html.twig';
    }

    /**
     * {@inheritDoc}
     */
    public function getSubject($templateLocation, array $parameters = array())
    {
        return $this->renderBlock($templateLocation, 'subject', $parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function getTextBody($templateName, array $parameters = array())
    {
        return $this->renderBlock($templateName, 'body_text', $parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function getHtmlBody($templateName, array $parameters = array())
    {
        return $this->renderBlock($templateName, 'body_html', $parameters);
    }
}