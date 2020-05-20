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
            $this->minimize($parentObject);
        }
    }

    protected function minimize(TypoScriptFrontendController $frontendController): void
    {
        $htmlMin = new HtmlMin();

        $frontendController->content = $htmlMin->minify($frontendController->content);

        $headerComment = $frontendController->config['config']['headerComment'] ?? '';
        if ($headerComment && $this->configuration->headerComment()) {
            $typo3Information = new Typo3Information();
            $headerComment = '<!--' . $headerComment . $typo3Information->getInlineHeaderComment() . LF . '-->';
            $frontendController->content = str_replace('<title>', $headerComment . LF . '<title>', $frontendController->content);
        }
    }
}
