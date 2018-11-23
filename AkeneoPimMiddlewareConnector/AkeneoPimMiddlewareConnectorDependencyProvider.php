<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AkeneoPimMiddlewareConnector;

use Propel\Runtime\Propel;
use Pyz\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\AttributeDataImporterPlugin;
use Pyz\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\CategoryDataImporterPlugin;
use Pyz\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\ProductAbstractDataImporterPlugin;
use Pyz\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\ProductAbstractStoreImporterPlugin;
use Pyz\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\ProductConcreteDataImporterPlugin;
use Pyz\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\ProductPriceDataImporterPlugin;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\DataImport\Dependency\Propel\DataImportToPropelConnectionBridge;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\PriceProductDataImport\Dependency\Facade\PriceProductDataImportToPriceProductFacadeBridge;
use Spryker\Zed\PriceProductDataImport\Dependency\Service\PriceProductDataImportToUtilEncodingServiceBridge;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\AkeneoPimMiddlewareConnectorDependencyProvider as SprykerEcoAkeneoPimMiddlewareConnectorDependencyProvider;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\AttributeMapMapperStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\AttributeMapPreparationMapperStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\AttributeMapTranslationStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\CategoryImportTranslationStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\CategoryMapperStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\DefaultProductImportValidatorStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\LocaleMapperStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\ProductImportTranslationStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\ProductMapperStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\ProductModelImportMapperStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\ProductModelImportTranslationStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\AttributeAkeneoApiStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\AttributeWriteStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\CategoryAkeneoApiStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\CategoryWriteStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\JsonObjectWriteStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\LocaleStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\ProductAbstractWriteStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\ProductAkeneoApiStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\ProductConcreteWriteStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\ProductModelAkeneoApiStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\TaxSetStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\TaxSetMapperStagePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Iterator\NullIteratorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Stream\JsonInputStreamPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Stream\JsonOutputStreamPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Stream\JsonRowInputStreamPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Stream\JsonRowOutputStreamPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamReaderStagePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamWriterStagePlugin;
//use SprykerMiddleware\Zed\Report\Communication\Plugin\Hook\ReportPostProcessorHookPlugin;

class AkeneoPimMiddlewareConnectorDependencyProvider extends SprykerEcoAkeneoPimMiddlewareConnectorDependencyProvider {

    public const FACADE_EVENT = 'FACADE_EVENT';
    public const STORE = 'store';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);
        $container = $this->addProductAbstractDataImporterPlugin($container);
        $container = $this->addProductPriceDataImporterPlugin($container);
        $container = $this->addProductAbstractStoresDataImporterPlugin($container);
        $container = $this->addEventFacade($container);
        $container = $this->addStore($container);

        return $container;
    }
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCategoryDataImporterPlugin(Container $container): Container
    {
        $container[static::AKENEO_PIM_MIDDLEWARE_CATEGORY_IMPORTER_PLUGIN] = function () {
            return new CategoryDataImporterPlugin();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addAttributeDataImporterPlugin(Container $container): Container
    {
        $container[static::AKENEO_PIM_MIDDLEWARE_ATTRIBUTE_IMPORTER_PLUGIN] = function () {
            return new AttributeDataImporterPlugin();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductAbstractDataImporterPlugin(Container $container): Container
    {
        $container[static::AKENEO_PIM_MIDDLEWARE_PRODUCT_ABSTRACT_IMPORTER_PLUGIN] = function () {
            return new ProductAbstractDataImporterPlugin();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductConcreteDataImporterPlugin(Container $container): Container
    {
        $container[static::AKENEO_PIM_MIDDLEWARE_PRODUCT_CONCRETE_IMPORTER_PLUGIN] = function () {
            return new ProductConcreteDataImporterPlugin();
        };

        return $container;
    }

    protected function addProductPriceDataImporterPlugin(Container $container): Container
    {
        $container[static::AKENEO_PIM_MIDDLEWARE_PRODUCT_PRICE_IMPORTER_PLUGIN] = function (){
          return new ProductPriceDataImporterPlugin();
        };

        return $container;
    }

    protected function addProductAbstractStoresDataImporterPlugin(Container $container): Container
    {
        $container[static::AKENEO_PIM_MIDDLEWARE_PRODUCT_ABSTRACT_STORES_IMPORTER_PLUGIN] = function(){
            return new ProductAbstractStoreImporterPlugin();
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEventFacade(Container $container)
    {
        $container[static::FACADE_EVENT] = function (Container $container) {
            return $container->getLocator()->event()->facade();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    private function addStore(Container $container)
    {
        $container[static::STORE] = function () {
            return Store::getInstance();
        };

        return $container;
    }

}