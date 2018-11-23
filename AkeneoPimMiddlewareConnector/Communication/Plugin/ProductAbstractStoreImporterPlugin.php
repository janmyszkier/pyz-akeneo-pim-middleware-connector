<?php

namespace Pyz\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Dependency\Plugin\DataImporterPluginInterface;

class ProductAbstractStoreImporterPlugin extends AbstractPlugin implements DataImporterPluginInterface {

    /**
     * @param array $data
     *
     * @return void
     */
    public function import(array $data): void
    {
        $this->getFacade()
            ->importProductAbstractStoresAssignment($data);
    }
}