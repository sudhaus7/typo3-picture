<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 project.
 *
 * @author Frank Berger <fberger@sudhaus7.de>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace SUDHAUS7\ResponsivePicture\TCA;

use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class MediaWidthItemProcFunc
{
    /**
     * @param array<int|string, mixed> $configuration
     */
    public function getMediaWidth(array &$configuration): void
    {
        $possibleVariants = $GLOBALS['TCA']['sys_file_reference']['columns']['crop']['config']['cropVariants'] ??= [];
        $itemsArray = [];
        $removeItems = [];
        if (isset($configuration['removeItems'])) {
            $removeItems = GeneralUtility::trimExplode(',', $configuration['removeItems']);
        }
        foreach ($possibleVariants as $key => $variant) {
            if (in_array($key, $removeItems)) {
                continue;
            }
            if (empty($variant['title'])) {
                continue;
            }
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
