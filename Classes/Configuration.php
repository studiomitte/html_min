<?php
declare(strict_types=1);

namespace StudioMitte\HtmlMin;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Configuration
{

    public function __construct()
    {
        $configuration = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('html_min');

        $this->enabled = (bool)($configuration['enabled'] ?? true);
        $this->allowedTypes = (string)($configuration['allowedTypes'] ?? '');
        $this->headerComment = (bool)($configuration['headerComment'] ?? true);
        $this->removeComments = (bool)($configuration['removeComments'] ?? false);
        $this->removeOmittedQuotes = (bool)($configuration['removeOmittedQuotes'] ?? false);
    }

    /** @var bool */
    protected $enabled = true;

    /** @var string */
    protected $allowedTypes = '0';

    /** @var bool */
    protected $headerComment = true;

    /** @var bool */
    protected $removeComments = false;

    /** @var bool */
    protected $removeOmittedQuotes = false;

    public function enabled(): bool
    {
        return $this->enabled;
    }

    public function allowedTypes(): string
    {
        return $this->allowedTypes;
    }

    public function headerComment(): bool
    {
        return $this->headerComment;
    }

    /**
     * @return bool
     */
    public function removeComments(): bool
    {
        return $this->removeComments;
    }

    /**
     * @return bool
     */
    public function removeOmittedQuotes(): bool
    {
        return $this->removeOmittedQuotes;
    }

}
