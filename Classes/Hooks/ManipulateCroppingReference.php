<?php

declare(strict_types=1);

namespace SUDHAUS7\ResponsivePicture\Hooks;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ManipulateCroppingReference
{
    public function processDatamap_beforeStart(DataHandler $pObj): void
    {
        $data = $pObj->datamap;
        if (!isset($data['sys_file_reference'])) {
            return;
        }
        foreach ($data['sys_file_reference'] as $uid => $reference) {
            if (!isset($reference['picture_variants'])) {
                continue;
            }
            $variants = GeneralUtility::intExplode(',', $reference['picture_variants']);
            $data['sys_file_reference'][$uid] = $this->mergeCroppingInformation($data['sys_file_reference'], $variants, $uid);
        }

        $pObj->datamap = $data;
    }

    /**
     * @param array<int, array<string, mixed>> $references
     * @param int[] $variants
     * @return array<string, mixed>
     */
    private function mergeCroppingInformation(array $references, array $variants, int $originalUid): array
    {
        $original = $references[$originalUid];
        $croppingInfo = json_decode($original['crop'], true);
        foreach ($variants as $variantId) {
            $variant = $references[$variantId] ?? [];
            if (isset($variant['crop'])) {
                $variantCropping = json_decode($variant['crop'], true);
                $croppingInfo = array_replace($croppingInfo, $variantCropping);
            }
        }
        $original['crop'] = json_encode($croppingInfo);
        return $original;
    }
}
