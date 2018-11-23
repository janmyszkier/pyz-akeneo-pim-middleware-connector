<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AkeneoPimMiddlewareConnector\Business;


use Pyz\Zed\AkeneoPimMiddlewareConnector\AkeneoPimMiddlewareConnectorDependencyProvider;
use Pyz\Zed\DataImport\Business\DataImportBusinessFactory;
use Pyz\Zed\DataImport\Business\Model\CategoryTemplate\CategoryTemplateWriterStep;
use Pyz\Zed\DataImport\Business\Model\CmsBlock\Category\Repository\CategoryRepository;
use Pyz\Zed\DataImport\Business\Model\CmsBlock\CmsBlockWriterStep;
use Pyz\Zed\DataImport\Business\Model\CmsBlockCategory\CmsBlockCategoryWriterStep;
use Pyz\Zed\DataImport\Business\Model\CmsBlockCategoryPosition\CmsBlockCategoryPositionWriterStep;
use Pyz\Zed\DataImport\Business\Model\CmsBlockStore\CmsBlockStoreWriterStep;
use Pyz\Zed\DataImport\Business\Model\CmsPage\CmsPageWriterStep;
use Pyz\Zed\DataImport\Business\Model\CmsPage\PlaceholderExtractorStep;
use Pyz\Zed\DataImport\Business\Model\CmsTemplate\CmsTemplateWriterStep;
use Pyz\Zed\DataImport\Business\Model\Country\Repository\CountryRepository;
use Pyz\Zed\DataImport\Business\Model\Currency\CurrencyWriterStep;
use Pyz\Zed\DataImport\Business\Model\Customer\CustomerWriterStep;
use Pyz\Zed\DataImport\Business\Model\DataFormatter\DataImportDataFormatter;
use Pyz\Zed\DataImport\Business\Model\DataFormatter\DataImportDataFormatterInterface;
use Pyz\Zed\DataImport\Business\Model\Discount\DiscountWriterStep;
use Pyz\Zed\DataImport\Business\Model\DiscountAmount\DiscountAmountWriterStep;
use Pyz\Zed\DataImport\Business\Model\DiscountStore\DiscountStoreWriterStep;
use Pyz\Zed\DataImport\Business\Model\DiscountVoucher\DiscountVoucherWriterStep;
use Pyz\Zed\DataImport\Business\Model\Glossary\GlossaryWriterStep;
use Pyz\Zed\DataImport\Business\Model\Locale\AddLocalesStep;
use Pyz\Zed\DataImport\Business\Model\Locale\LocaleNameToIdLocaleStep;
use Pyz\Zed\DataImport\Business\Model\Locale\Repository\LocaleRepository;
use Pyz\Zed\DataImport\Business\Model\Navigation\NavigationKeyToIdNavigationStep;
use Pyz\Zed\DataImport\Business\Model\Navigation\NavigationWriterStep;
use Pyz\Zed\DataImport\Business\Model\NavigationNode\NavigationNodeValidityDatesStep;
use Pyz\Zed\DataImport\Business\Model\NavigationNode\NavigationNodeWriterStep;
use Pyz\Zed\DataImport\Business\Model\OrderSource\OrderSourceWriterStep;
use Pyz\Zed\DataImport\Business\Model\Product\AttributesExtractorStep;
use Pyz\Zed\DataImport\Business\Model\Product\ProductLocalizedAttributesExtractorStep;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepository;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\AddCategoryKeysStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\AddProductAbstractSkusStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\ProductAbstractHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\ProductAbstractSkuToIdProductAbstractStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\Writer\ProductAbstractBulkPdoDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\Writer\ProductAbstractPropelDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\Writer\Sql\ProductAbstractSql;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\Writer\Sql\ProductAbstractSqlInterface;
use Pyz\Zed\DataImport\Business\Model\ProductAbstractStore\ProductAbstractStoreHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstractStore\Writer\ProductAbstractStoreBulkPdoDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductAbstractStore\Writer\ProductAbstractStorePropelDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductAbstractStore\Writer\Sql\ProductAbstractStoreSql;
use Pyz\Zed\DataImport\Business\Model\ProductAbstractStore\Writer\Sql\ProductAbstractStoreSqlInterface;
use Pyz\Zed\DataImport\Business\Model\ProductAttributeKey\AddProductAttributeKeysStep;
use Pyz\Zed\DataImport\Business\Model\ProductAttributeKey\ProductAttributeKeyWriter;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\ProductConcreteHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\ProductSkuToIdProductStep;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\Writer\ProductConcreteBulkPdoDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\Writer\ProductConcretePropelDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\Writer\Sql\ProductConcreteSql;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\Writer\Sql\ProductConcreteSqlInterface;
use Pyz\Zed\DataImport\Business\Model\ProductGroup\ProductGroupWriter;
use Pyz\Zed\DataImport\Business\Model\ProductImage\ProductImageHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductImage\Writer\ProductImageBulkPdoDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductImage\Writer\ProductImagePropelDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductImage\Writer\Sql\ProductImageSql;
use Pyz\Zed\DataImport\Business\Model\ProductImage\Writer\Sql\ProductImageSqlInterface;
use Pyz\Zed\DataImport\Business\Model\ProductLabel\Hook\ProductLabelAfterImportPublishHook;
use Pyz\Zed\DataImport\Business\Model\ProductLabel\ProductLabelWriterStep;
use Pyz\Zed\DataImport\Business\Model\ProductManagementAttribute\ProductManagementAttributeWriter;
use Pyz\Zed\DataImport\Business\Model\ProductManagementAttribute\ProductManagementLocalizedAttributesExtractorStep;
use Pyz\Zed\DataImport\Business\Model\ProductOption\ProductOptionWriterStep;
use Pyz\Zed\DataImport\Business\Model\ProductOptionPrice\ProductOptionPriceWriterStep;
use Pyz\Zed\DataImport\Business\Model\ProductPrice\ProductPriceHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductPrice\Writer\ProductPriceBulkPdoDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductPrice\Writer\ProductPricePropelDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductPrice\Writer\Sql\ProductPriceSql;
use Pyz\Zed\DataImport\Business\Model\ProductPrice\Writer\Sql\ProductPriceSqlInterface;
use Pyz\Zed\DataImport\Business\Model\ProductRelation\Hook\ProductRelationAfterImportHook;
use Pyz\Zed\DataImport\Business\Model\ProductRelation\ProductRelationWriter;
use Pyz\Zed\DataImport\Business\Model\ProductReview\ProductReviewWriterStep;
use Pyz\Zed\DataImport\Business\Model\ProductSearchAttribute\Hook\ProductSearchAfterImportHook;
use Pyz\Zed\DataImport\Business\Model\ProductSearchAttribute\ProductSearchAttributeWriter;
use Pyz\Zed\DataImport\Business\Model\ProductSearchAttributeMap\ProductSearchAttributeMapWriter;
use Pyz\Zed\DataImport\Business\Model\ProductSet\ProductSetImageExtractorStep;
use Pyz\Zed\DataImport\Business\Model\ProductSet\ProductSetWriterStep;
use Pyz\Zed\DataImport\Business\Model\ProductStock\Hook\ProductStockAfterImportPublishHook;
use Pyz\Zed\DataImport\Business\Model\ProductStock\ProductStockHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductStock\Writer\ProductStockBulkPdoDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductStock\Writer\ProductStockPropelDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductStock\Writer\Sql\ProductStockSql;
use Pyz\Zed\DataImport\Business\Model\ProductStock\Writer\Sql\ProductStockSqlInterface;
use Pyz\Zed\DataImport\Business\Model\PropelExecutor;
use Pyz\Zed\DataImport\Business\Model\PropelExecutorInterface;
use Pyz\Zed\DataImport\Business\Model\Shipment\ShipmentWriterStep;
use Pyz\Zed\DataImport\Business\Model\ShipmentPrice\ShipmentPriceWriterStep;
use Pyz\Zed\DataImport\Business\Model\Stock\StockWriterStep;
use Pyz\Zed\DataImport\Business\Model\Store\StoreReader;
use Pyz\Zed\DataImport\Business\Model\Store\StoreWriterStep;
use Pyz\Zed\DataImport\Business\Model\Tax\TaxSetNameToIdTaxSetStep;
use Pyz\Zed\DataImport\Business\Model\Tax\TaxWriterStep;
use Pyz\Zed\DataImport\Communication\Plugin\ProductAbstract\ProductAbstractPropelWriterPlugin;
use Pyz\Zed\DataImport\Communication\Plugin\ProductAbstractStore\ProductAbstractStorePropelWriterPlugin;
use Pyz\Zed\DataImport\Communication\Plugin\ProductConcrete\ProductConcretePropelWriterPlugin;
use Pyz\Zed\DataImport\Communication\Plugin\ProductImage\ProductImagePropelWriterPlugin;
use Pyz\Zed\DataImport\Communication\Plugin\ProductPrice\ProductPricePropelWriterPlugin;
use Pyz\Zed\DataImport\Communication\Plugin\ProductStock\ProductStockPropelWriterPlugin;
use Pyz\Zed\DataImport\DataImportDependencyProvider;
use Spryker\Service\UtilEncoding\UtilEncodingServiceInterface;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\ProductSearch\Code\KeyBuilder\FilterGlossaryKeyBuilder;
use Spryker\Zed\Currency\Business\CurrencyFacadeInterface;
use Spryker\Zed\DataImport\Business\DataImportBusinessFactory as SprykerDataImportBusinessFactory;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSet;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBroker;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterCollection;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisher;
use Spryker\Zed\DataImport\Dependency\Facade\DataImportToEventBridge;
use Spryker\Zed\DataImport\Dependency\Facade\DataImportToEventFacadeInterface;
use Spryker\Zed\Discount\DiscountConfig;
use Spryker\Zed\PriceProduct\Business\PriceProductFacadeInterface;
use Spryker\Zed\ProductAbstractDataImport\Business\Model\ProductAbstractWriterStep;
use Spryker\Zed\Stock\Business\StockFacadeInterface;
use Spryker\Zed\Store\Business\StoreFacadeInterface;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Business\AkeneoPimMiddlewareConnectorBusinessFactory as OriginalAkeneoPimMiddlewareConnectorBusinessFactory;
use Spryker\Zed\ProductAbstractDataImport\Business\Model\Reader\ProductAbstractReader;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Translator\Dictionary\DictionaryInterface;

/**
 * @method \Pyz\Zed\DataImport\DataImportConfig getConfig()
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class AkeneoPimMiddlewareConnectorBusinessFactory extends OriginalAkeneoPimMiddlewareConnectorBusinessFactory
{

    /*note, most of those methods come from src/Pyz/Zed/DataImport/Business/DataImportBusinessFactory.php */

    public function createAbstractProductDataImporter(){
        return new Importer(
            $this->createDataImporterPublisher(),
            $this->createAbstractProductImportDataSetStepBroker(),
            $this->createDataSet()
        );
    }

    protected function createDataImporterPublisher()
    {
        return new DataImporterPublisher();
    }

    private function createDataImportToEventBridge()
    {
        return new DataImportToEventBridge($this->getEventFacade());
    }

    /**
     * @deprecated Please make sure that your `getEventFacade()` method is public. With the next major we will use public methods only in this factory.
     *
     */
    public function getEventFacade()
    {
        return $this->getProvidedDependency(AkeneoPimMiddlewareConnectorDependencyProvider::FACADE_EVENT);
    }

    public function createAbstractProductImportDataSetStepBroker()
    {
        $dataSetStepBroker = new DataSetStepBroker();
        $dataSetStepBroker
            ->addStep($this->createAddLocalesStep())
            ->addStep($this->createAddCategoryKeysStep())
            ->addStep($this->createTaxSetNameToIdTaxSetStep(TaxSetNameToIdTaxSetStep::KEY_SOURCE))
            ->addStep($this->createAttributesExtractorStep())
            ->addStep($this->createProductLocalizedAttributesExtractorStep([
                ProductAbstractHydratorStep::KEY_NAME,
                ProductAbstractHydratorStep::KEY_URL,
                ProductAbstractHydratorStep::KEY_DESCRIPTION,
                ProductAbstractHydratorStep::KEY_META_TITLE,
                ProductAbstractHydratorStep::KEY_META_DESCRIPTION,
                ProductAbstractHydratorStep::KEY_META_KEYWORDS,
            ]))
//        ->addStep(new ProductAbstractHydratorStep())
            ->addStep($this->createAbstractProductDataWriteStep());

        return $dataSetStepBroker;
    }

    public function createAbstractProductDataWriteStep()
    {
        return new ProductAbstractWriterStep($this->createProductAbstractReader());
    }

    public function createProductAbstractReader()
    {
        return new ProductAbstractReader();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    protected function createAddLocalesStep()
    {
        return new AddLocalesStep($this->getStore());
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    protected function getStore()
    {
        return $this->getProvidedDependency(AkeneoPimMiddlewareConnectorDependencyProvider::STORE);
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\ProductAbstract\AddCategoryKeysStep
     */
    protected function createAddCategoryKeysStep()
    {
        return new AddCategoryKeysStep();
    }

        /**
         * @param string $source
         * @param string $target
         *
         * @return \Pyz\Zed\DataImport\Business\Model\Tax\TaxSetNameToIdTaxSetStep
         */
        protected function createTaxSetNameToIdTaxSetStep($source = TaxSetNameToIdTaxSetStep::KEY_SOURCE, $target = TaxSetNameToIdTaxSetStep::KEY_TARGET)
    {
        return new TaxSetNameToIdTaxSetStep($source, $target);
    }

        /**
         * @return \Pyz\Zed\DataImport\Business\Model\Product\AttributesExtractorStep
         */
        protected function createAttributesExtractorStep()
    {
        return new AttributesExtractorStep();
    }

        /**
         * @param array $defaultAttributes
         *
         * @return \Pyz\Zed\DataImport\Business\Model\Product\ProductLocalizedAttributesExtractorStep
         */
        protected function createProductLocalizedAttributesExtractorStep(array $defaultAttributes = [])
    {
        return new ProductLocalizedAttributesExtractorStep($defaultAttributes);
    }

    protected function createDataSet()
    {
        return new DataSet();
    }

    public function createProductModelWriteStream(): WriteStreamInterface
    {
        return new DataImportWriteStream($this->getProvidedDependency(static::PRODUCT_MODEL_IMPORT_OUTPUT_STREAM_PLUGIN));
    }


}