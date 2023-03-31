<?php

declare(strict_types=1);

namespace SUDHAUS7\ResponsivePicture\TCA;

use TYPO3\CMS\Core\Utility\ArrayUtility;

class MediaWidthItemProcFunc
{
    /**
     * @return array<int, array{0: string, 1: mixed}>
     */
    public function getMediaWidth(array &$configuration): void
    {
        $possibleVariants = $GLOBALS['TCA']['sys_file_reference']['columns']['crop']['config']['cropVariants'] ??= [];
        $itemsArray = [];
        foreach ($possibleVariants as $key => $variant) {
            $itemsArray[] = [
                $variant['title'],
                $key,
            ];
        }
        ArrayUtility::mergeRecursiveWithOverrule(
            $configuration['items'],
            $itemsArray
        );
    }
}
