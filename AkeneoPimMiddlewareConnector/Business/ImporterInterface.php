<?php

namespace Pyz\Zed\AkeneoPimMiddlewareConnector\Business;

interface ImporterInterface{
    public function import(array $data): void;
}