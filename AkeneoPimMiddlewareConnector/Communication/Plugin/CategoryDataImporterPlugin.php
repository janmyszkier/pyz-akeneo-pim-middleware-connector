<?php

namespace Pyz\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin;

use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Dependency\Plugin\DataImporterPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
/**
 * @method \Pyz\Zed\AkeneoPimMiddlewareConnector\Business\AkeneoPimMiddlewareConnectorFacadeInterface getFacade()
 */
class CategoryDataImporterPlugin extends AbstractPlugin implements DataImporterPluginInterface {

    /**
     * @param array $data
     *
     * @return void
     */
    public function import(array $data): void
    {
        $this->getFacade()
            ->importCategories($data);
    }
}