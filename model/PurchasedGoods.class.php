<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PurchasedGoods
 *
 * @author NexX
 */
class PurchasedGoods extends Goods{
    private $PurchaseOrderID;
    private $GoodsID;
    private $Amount;
    private $PurchasePrice;
    
    function __construct($PurchaseOrderID, $GoodsID, $Amount, $PurchasePrice) {
        $this->PurchaseOrderID = $PurchaseOrderID;
        $this->GoodsID = $GoodsID;
        $this->Amount = $Amount;
        $this->PurchasePrice = $PurchasePrice;
    }

    function getPurchaseOrderID() {
        return $this->PurchaseOrderID;
    }

    function getGoodsID() {
        return $this->GoodsID;
    }

    function getAmount() {
        return $this->Amount;
    }

    function getPurchasePrice() {
        return $this->PurchasePrice;
    }

    function setPurchaseOrderID($PurchaseOrderID) {
        $this->PurchaseOrderID = $PurchaseOrderID;
    }

    function setGoodsID($GoodsID) {
        $this->GoodsID = $GoodsID;
    }

    function setAmount($Amount) {
        $this->Amount = $Amount;
    }

    function setPurchasePrice($PurchasePrice) {
        $this->PurchasePrice = $PurchasePrice;
    }
}
