<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Goods
 *
 * @author NexX
 */
class PlainGood {
    private $GoodsID;    
    private $CategoryID;
    private $TaxID;    
    private $Name;
    private $Description;
    private $Manufacturer;
    private $CurrentNetSalesPrice;
    private $StorageLocation;
    private $Unit;
    private $MinAmount;
    private $StockAmount;
    private $Active;
    private $IsOrdered;
    
    function __construct($GoodsID, $CategoryID, $TaxID, $Name, $Description, $Manufacturer, $CurrentNetSalesPrice, $StorageLocation, $Unit, $MinAmount, $StockAmount, $Active, $IsOrdered) {
        $this->GoodsID = $GoodsID;
        $this->CategoryID = $CategoryID;
        $this->TaxID = $TaxID;
        $this->Name = $Name;
        $this->Description = $Description;
        $this->Manufacturer = $Manufacturer;
        $this->CurrentNetSalesPrice = $CurrentNetSalesPrice;
        $this->StorageLocation = $StorageLocation;
        $this->Unit = $Unit;
        $this->MinAmount = $MinAmount;
        $this->StockAmount = $StockAmount;
        $this->Active = $Active;
        $this->IsOrdered = $IsOrdered;
    }
    function getGoodsID() {
        return $this->GoodsID;
    }

    function getCategoryID() {
        return $this->CategoryID;
    }

    function getTaxID() {
        return $this->TaxID;
    }

    function getName() {
        return $this->Name;
    }

    function getDescription() {
        return $this->Description;
    }

    function getManufacturer() {
        return $this->Manufacturer;
    }

    function getCurrentNetSalesPrice() {
        return $this->CurrentNetSalesPrice;
    }

    function getStorageLocation() {
        return $this->StorageLocation;
    }

    function getUnit() {
        return $this->Unit;
    }

    function getMinAmount() {
        return $this->MinAmount;
    }

    function getStockAmount() {
        return $this->StockAmount;
    }

    function getActive() {
        return $this->Active;
    }

    function getIsOrdered() {
        return $this->IsOrdered;
    }

    function setGoodsID($GoodsID) {
        $this->GoodsID = $GoodsID;
    }

    function setCategoryID($CategoryID) {
        $this->CategoryID = $CategoryID;
    }

    function setTaxID($TaxID) {
        $this->TaxID = $TaxID;
    }

    function setName($Name) {
        $this->Name = $Name;
    }

    function setDescription($Description) {
        $this->Description = $Description;
    }

    function setManufacturer($Manufacturer) {
        $this->Manufacturer = $Manufacturer;
    }

    function setCurrentNetSalesPrice($CurrentNetSalesPrice) {
        $this->CurrentNetSalesPrice = $CurrentNetSalesPrice;
    }

    function setStorageLocation($StorageLocation) {
        $this->StorageLocation = $StorageLocation;
    }

    function setUnit($Unit) {
        $this->Unit = $Unit;
    }

    function setMinAmount($MinAmount) {
        $this->MinAmount = $MinAmount;
    }

    function setStockAmount($StockAmount) {
        $this->StockAmount = $StockAmount;
    }

    function setActive($Active) {
        $this->Active = $Active;
    }

    function setIsOrdered($IsOrdered) {
        $this->IsOrdered = $IsOrdered;
    }
}

