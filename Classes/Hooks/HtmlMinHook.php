<?php

declare(strict_types=1);

namespace StudioMitte\HtmlMin\Hooks;

use StudioMitte\HtmlMin\Configuration;
use TYPO3\CMS\Core\Information\Typo3Information;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use voku\helper\HtmlMin;

class HtmlMinHook
{
    /** @var Configuration */
    protected $configuration;

    public function __construct()
    {
        $this->configuration = GeneralUtility::makeInstance(Configuration::class);
    }

    public function run(array $params): void
    {
        if ($this->configuration->enabled()) {
            /** @var TypoScriptFrontendController $parentObject */
            $parentObject = $params['pObj'];
            if (!$parentObject->no_cache && empty($parentObject->config['INTincScript'])
                && GeneralUtility::inList($this->configuration->allowedTypes(), $parentObject->type)) {
                $this->minimize($parentObject);
            }
        }
    }

    protected function minimize(TypoScriptFrontendController $frontendController): void
    {
        $htmlMin = new HtmlMin();
        $htmlMin->doRemoveComments($this->configuration->removeComments());
        $htmlMin->doRemoveOmittedQuotes($this->configuration->removeOmittedQuotes());
        $htmlMin->doRemoveOmittedHtmlTags($this->configuration->removeOmittedHtmlTags());
        $frontendController->content = $htmlMin->minify($frontendController->content);

        $headerComment = $frontendController->config['config']['headerComment'] ?? '';
        if ($headerComment && $this->configuration->headerComment() && $this->configuration->removeComments()) {
            $headerComment = '<!--' . LF . '	' . $headerComment . LF . $this->getTypo3Information() . '-->';
            $frontendController->content = str_replace('<title>', $headerComment . LF . '<title>', $frontendController->content);
        }
    }

    protected function getTypo3Information(): string
    {
        if (class_exists(Typo3Information::class)) {
            $typo3Information = new Typo3Information();
            return $typo3Information->getInlineHeaderComment();
        }

        return '	This website is powered by TYPO3 - inspiring people to share!
	TYPO3 is a free open source Content Management Framework initially created by Kasper Skaarhoj and licensed under GNU/GPL.
	TYPO3 is copyright 1998-' . date('Y') . ' of Kasper Skaarhoj. Extensions are copyright of their respective owners.
	Information and contribution at https://typo3.org/';
    }

}
