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
        $this->headerComment = (bool)($configuration['headerComment'] ?? true);
    }

    /** @var bool */
    protected $enabled = true;
    /** @var bool */
    protected $headerComment = true;

    public function enabled(): bool
    {
        return $this->enabled;
    }

    public function headerComment(): bool
    {
        return $this->headerComment;
    }

}
