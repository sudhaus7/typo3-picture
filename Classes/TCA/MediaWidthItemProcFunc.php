<?php

declare(strict_types=1);

namespace SUDHAUS7\ResponsivePicture\TCA;

use TYPO3\CMS\Core\Utility\ArrayUtility;

class MediaWidthItemProcFunc
{
    /**
     * @param array<int|string, mixed> $configuration
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
        // unset first crop variant as this is the default
        array_shift($itemsArray);
        ArrayUtility::mergeRecursiveWithOverrule(
            $configuration['items'],
            $itemsArray
        );
    }
}
