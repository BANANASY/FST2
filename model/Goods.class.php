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
class Goods {
    private $GoodsID;
    
    private $CategoryID;
    private $Category_Title;
    private $Category_Description;
    
    private $TaxID;
    private $Tax_Date;
    private $Tax_Name;
    private $Tax_Percent;
    
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
    
    function __construct($GoodsID, $CategoryID, $Category_Title, $Category_Description, $TaxID, $Tax_Date, $Tax_Name, $Tax_Percent, $Name, $Description, $Manufacturer, $CurrentNetSalesPrice, $StorageLocation, $Unit, $MinAmount, $StockAmount, $Active, $IsOrdered) {
        $this->GoodsID = $GoodsID;
        $this->CategoryID = $CategoryID;
        $this->Category_Title = $Category_Title;
        $this->Category_Description = $Category_Description;
        $this->TaxID = $TaxID;
        $this->Tax_Date = $Tax_Date;
        $this->Tax_Name = $Tax_Name;
        $this->Tax_Percent = $Tax_Percent;
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

    function getCategory_Title() {
        return $this->Category_Title;
    }

    function getCategory_Description() {
        return $this->Category_Description;
    }

    function getTaxID() {
        return $this->TaxID;
    }

    function getTax_Date() {
        return $this->Tax_Date;
    }

    function getTax_Name() {
        return $this->Tax_Name;
    }

    function getTax_Percent() {
        return $this->Tax_Percent;
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

    function setCategory_Title($Category_Title) {
        $this->Category_Title = $Category_Title;
    }

    function setCategory_Description($Category_Description) {
        $this->Category_Description = $Category_Description;
    }

    function setTaxID($TaxID) {
        $this->TaxID = $TaxID;
    }

    function setTax_Date($Tax_Date) {
        $this->Tax_Date = $Tax_Date;
    }

    function setTax_Name($Tax_Name) {
        $this->Tax_Name = $Tax_Name;
    }

    function setTax_Percent($Tax_Percent) {
        $this->Tax_Percent = $Tax_Percent;
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
