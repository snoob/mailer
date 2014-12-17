<?php

namespace Snoob\Component\Mailer;

class TemplateMail extends \Swift_Message implements MailInterface
{
    /**
     * @var bool
     */
    protected $useTemplateTranslation = true;

    /**
     * @var  array
     * @see  setTemplateReference()
     */
    protected $templateReference = array();

    /**
     * @var  array
     * @see  getTemplateVars()
     */
    protected $templateVars = array();

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = array())
    {
        $this->buildHeader($parameters);
        $this->buildView($parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function setParametersFromMailer(array $mailerParameters)
    {
        if ($this->useTemplateTranslation === true && $this->templateVars['locale'] === 'default') {
            $this->templateVars['locale'] = $mailerParameters['locale'];
        }
        if ($this->getFrom() === null) {
            $this->setFrom($mailerParameters['from']);
        }
        return $this;
    }

    /**
     * @param $addresses with keys to, bcc, from
     * @throws \InvalidArgumentException
     * @return MailInterface
     */
    public function setAddresses(array $addresses)
    {
        foreach ($addresses as $key => $value) {
            if (!in_array($key, array('to', 'bcc', 'from'))) {
                throw new \InvalidArgumentException($key . 'is an invalid address type');
            }
            $this->{'set' . ucfirst($key)}($value);
        }
        return $this;
    }

    /**
     * @return MailInterface
     */
    protected function dontUseTemplateTranslation()
    {
        return $this->setLocale(null);
    }

    /**
     * {@inheritDoc}
     */
    public function setLocale($locale)
    {
        $this->useTemplateTranslation =  !empty($locale);
        $this->templateVars['locale'] = $locale ? $locale : null;
        $this->templateReference['locale'] = $this->templateVars['locale'];
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setTemplateReference($bundle, $name)
    {
        $this->templateReference['bundle'] = $bundle;
        $this->templateReference['name'] = $name;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplateReference()
    {
        return $this->templateReference;
    }

    /**
     * @param array $vars
     * @return MailInterface
     */
    protected function addTemplateVars(array $templateVars)
    {
        foreach ($templateVars as $key => $value) {
            $this->addTemplateVar($key, $value);
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addTemplateVar($name, $var)
    {
        $this->templateVars[$name] = $var;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplateVars()
    {
        return $this->templateVars;
    }

    /**
     * Méthode à implementer pour définir l'expéditeur, le ou les destinataire(s) et l'objet du mail
     * @param array $parameters
     * @return MailInterface
     */
    protected function buildHeader(array $parameters)
    {
        return $this;
    }

    /**
     * Méthode à implementer pour définir la référence au template et les variables de templates du mail
     * @param array $parameters
     * @return MailInterface|void
     */
    protected function buildView(array $parameters)
    {
        return $this;
    }
}