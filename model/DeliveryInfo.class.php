<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeliveryInfo
 *
 * @author NexX
 */
class DeliveryInfo {

    private $DeliveryInfoID;
    private $EmployeeID;
    private $SupplierID;
    private $PurchaseOrderID;
    private $DeliverySlipScanID;
    private $IncomeDateTime;
    private $DeliveryInformation;

    function __construct($DeliveryInfoID, $EmployeeID, $SupplierID, $PurchaseOrderID, $DeliverySlipScanID, $IncomeDateTime, $DeliveryInformation) {
        $this->DeliveryInfoID = $DeliveryInfoID;
        $this->EmployeeID = $EmployeeID;
        $this->SupplierID = $SupplierID;
        $this->PurchaseOrderID = $PurchaseOrderID;
        $this->DeliverySlipScanID = $DeliverySlipScanID;
        $this->IncomeDateTime = $IncomeDateTime;
        $this->DeliveryInformation = $DeliveryInformation;
    }

    function getDeliveryInfoID() {
        return $this->DeliveryInfoID;
    }

    function getEmployeeID() {
        return $this->EmployeeID;
    }

    function getSupplierID() {
        return $this->SupplierID;
    }

    function getPurchaseOrderID() {
        return $this->PurchaseOrderID;
    }

    function getDeliverySlipScanID() {
        return $this->DeliverySlipScanID;
    }

    function getIncomeDateTime() {
        return $this->IncomeDateTime;
    }

    function getDeliveryInformation() {
        return $this->DeliveryInformation;
    }

    function setDeliveryInfoID($DeliveryInfoID) {
        $this->DeliveryInfoID = $DeliveryInfoID;
    }

    function setEmployeeID($EmployeeID) {
        $this->EmployeeID = $EmployeeID;
    }

    function setSupplierID($SupplierID) {
        $this->SupplierID = $SupplierID;
    }

    function setPurchaseOrderID($PurchaseOrderID) {
        $this->PurchaseOrderID = $PurchaseOrderID;
    }

    function setDeliverySlipScanID($DeliverySlipScanID) {
        $this->DeliverySlipScanID = $DeliverySlipScanID;
    }

    function setIncomeDateTime($IncomeDateTime) {
        $this->IncomeDateTime = $IncomeDateTime;
    }

    function setDeliveryInformation($DeliveryInformation) {
        $this->DeliveryInformation = $DeliveryInformation;
    }

}
