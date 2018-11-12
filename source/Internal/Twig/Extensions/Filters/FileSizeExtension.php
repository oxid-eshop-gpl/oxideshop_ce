<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\FileSizeLogic;
use Twig\Extension\AbstractExtension;

/**
 * Class FileSizeExtension
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Filters
 * @author  Jędrzej Skoczek
 */
class FileSizeExtension extends AbstractExtension
{

    /**
     * @var FileSizeLogic
     */
    private $fileSizeLogic;

    /**
     * FileSizeExtension constructor.
     *
     * @param FileSizeLogic $fileSizeLogic
     */
    public function __construct(FileSizeLogic $fileSizeLogic)
    {
        $this->fileSizeLogic = $fileSizeLogic;
    }

    /**
     * @return array|\Twig_Filter[]
     */
    public function getFilters()
    {
        return [new \Twig_Filter('fileSize', [$this, 'fileSize'])];
    }

    /**
     * @param string $size
     *
     * @return string
     */
    public function fileSize($size)
    {
        return $this->fileSizeLogic->getFileSize($size);
    }
}
