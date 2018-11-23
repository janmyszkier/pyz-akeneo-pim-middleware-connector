<?php

namespace Pyz\Zed\AkeneoPimMiddlewareConnector\Business;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReaderConfigurationTransfer;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use \SprykerEco\Zed\AkeneoPimMiddlewareConnector\Business\AkeneoPimMiddlewareConnectorFacade as OriginalAkeneoPimMiddlewareConnectorFacade;

/**
 * @method \Pyz\Zed\AkeneoPimMiddlewareConnector\Business\AkeneoPimMiddlewareConnectorBusinessFactory getFactory()
 */
class AkeneoPimMiddlewareConnectorFacade extends OriginalAkeneoPimMiddlewareConnectorFacade {

    /**
     * @param array $data
     *
     * @return void
     */
    public function importCategories(array $data)
    {
        $this->getFactory()
            ->createCategoryImporter()
            ->import($data);
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function importAttributeData(array $data)
    {
        $this->getFactory()
            ->createAttributeDataImporter()
            ->import($data);
    }

    public function importModelProducts($data){

        $this->getFactory()
            ->createAbstractProductDataImporter()
            ->import($data);
    }

    public function importProductAbstractStoresAssignment($data){
        $this->getFactory()
            ->createProductAbstractStoresAssignmentDataImporter()
            ->import($data);
    }

    public function importProductConcreteData($data){
        $this->getFactory()
            ->createProductConcreteDataImporter()
            ->import($data);
    }

    public function importPriceProductData($data){

        $this->getFactory()
            ->createPriceProductDataImporter()
            ->import($data);
    }

}