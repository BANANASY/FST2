<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PurchaseOrder
 *
 * @author NexX
 */
class PurchaseOrder {
    private $PurchaseOrderID;
    private $SupplierID;
    private $EmployeeID;
    private $DateTime;
    private $Status;
    
    function __construct($PurchaseOrderID, $SupplierID, $EmployeeID, $DateTime, $Status) {
        $this->PurchaseOrderID = $PurchaseOrderID;
        $this->SupplierID = $SupplierID;
        $this->EmployeeID = $EmployeeID;
        $this->DateTime = $DateTime;
        $this->Status = $Status;
    }
    function getPurchaseOrderID() {
        return $this->PurchaseOrderID;
    }

    function getSupplierID() {
        return $this->SupplierID;
    }

    function getEmployeeID() {
        return $this->EmployeeID;
    }

    function getDateTime() {
        return $this->DateTime;
    }

    function getStatus() {
        return $this->Status;
    }

    function setPurchaseOrderID($PurchaseOrderID) {
        $this->PurchaseOrderID = $PurchaseOrderID;
    }

    function setSupplierID($SupplierID) {
        $this->SupplierID = $SupplierID;
    }

    function setEmployeeID($EmployeeID) {
        $this->EmployeeID = $EmployeeID;
    }

    function setDateTime($DateTime) {
        $this->DateTime = $DateTime;
    }

    function setStatus($Status) {
        $this->Status = $Status;
    }
}
