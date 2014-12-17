<?php

namespace Snoob\Component\Mailer;

abstract class AbstractTemplateMail extends \Swift_Message implements TemplateMailInterface
{
    /**
     * @var bool
     */
    protected $useTemplateTranslation = true;

    /**
     * @var array
     * @see setTemplateReference()
     */
    protected $templateReference = array();

    /**
     * @var array
     * @see getTemplateVars()
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
     * @param  array $addresses with keys to, bcc, from
     *
     * @return TemplateMailInterface
     *
     * @throws \InvalidArgumentException
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
     * @return TemplateMailInterface
     */
    protected function dontUseTemplateTranslation()
    {
        return $this->setLocale(null);
    }

    /**
     * @param  string|null $locale : null ou false désactive la traduction par template
     *
     * @return TemplateMailInterface
     */
    public function setLocale($locale)
    {
        $this->useTemplateTranslation =  !empty($locale);
        $this->templateVars['locale'] = $locale ? $locale : null;
        $this->templateReference['locale'] = $this->templateVars['locale'];

        return $this;
    }

    /**
     * Les templates des emails sont stockés dans Bundle/Resources/mails.
     * Pour ne pas surcharger les yms on traduit les emails directement dans les templates.
     * Pour traduire un template on ajoute le dossier à l'arborescence ci-dessus (dans Bundle/Resources/mail/locale)
     * Cette méthode renvoie les informations necessaires à la localisation du template
     *
     * @param  string      $bundle : AcmeDemoBundle
     * @param  string      $name  : nom du template sans l'extension
     * @param  string|null $locale : si le template est traduit
     *
     * @return TemplateMailInterface
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
     * @param  array $templateVars
     *
     * @return TemplateMailInterface
     */
    protected function addTemplateVars(array $templateVars)
    {
        foreach ($templateVars as $key => $value) {
            $this->addTemplateVar($key, $value);
        }
        return $this;
    }

    /**
     * @param  string $name
     * @param  string $var
     *
     * @return TemplateMailInterface
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
     *
     * @param  array $parameters
     *
     * @return TemplateMailInterface
     */
    abstract protected function buildHeader(array $parameters);

    /**
     * Méthode à implementer pour définir l'expéditeur, le ou les destinataire(s) et l'objet du mail
     *
     * @param  array $parameters
     *
     * @return TemplateMailInterface
     */
    abstract protected function buildView(array $parameters);
}