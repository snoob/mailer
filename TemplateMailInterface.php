<?php

namespace Snoob\Component\Mailer;

interface TemplateMailInterface extends \Swift_Mime_Message
{
    /**
     * Les templates des emails sont stockés dans Bundle/Resources/mails.
     * Pour ne pas surcharger les yms on traduit les emails directement dans les templates.
     * Pour traduire un template on ajoute le dossier à l'arborescence ci-dessus (dans Bundle/Resources/mail/locale)
     * Cette méthode renvoie les informations necessaires à la localisation du template
     *
     * @param  $bundle : AcmeDemoBundle
     * @param  string $name  : nom du template sans l'extension
     * @param  string|null $locale : si le template est traduit
     *
     * @return TemplateMailInterface
     */
    public function setTemplateReference($bundle, $name);

    /**
     * @return array
     */
    public function getTemplateReference();

    /**
     * @param  string $name
     * @param  string $var
     *
     * @return TemplateMailInterface
     */
    public function addTemplateVar($name, $var);

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
     * @param  string|null $locale : null ou false désactive la traduction par template
     *
     * @return TemplateMailInterface
     */
    public function setLocale($locale);
}