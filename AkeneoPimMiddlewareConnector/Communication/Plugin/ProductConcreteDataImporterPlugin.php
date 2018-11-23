<?php

namespace Pyz\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Dependency\Plugin\DataImporterPluginInterface;

class ProductConcreteDataImporterPlugin extends AbstractPlugin implements DataImporterPluginInterface{

    /**
     * @param array $data
     *
     * @return void
     */
    public function import(array $data): void
    {
        $this->getFacade()
            ->importProductConcreteData($data);
    }
}