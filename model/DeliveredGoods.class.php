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
class DeliveredGoods {

    private $DeliveryInfoID;
    private $GoodsID;
    private $Amount;
    private $QualityIsOK;

    function __construct($DeliveryInfoID, $GoodsID, $Amount, $QualityIsOK) {
        $this->DeliveryInfoID = $DeliveryInfoID;
        $this->GoodsID = $GoodsID;
        $this->Amount = $Amount;
        $this->QualityIsOK = $QualityIsOK;
    }

    function getDeliveryInfoID() {
        return $this->DeliveryInfoID;
    }

    function getGoodsID() {
        return $this->GoodsID;
    }

    function getAmount() {
        return $this->Amount;
    }

    function getQualityIsOK() {
        return $this->QualityIsOK;
    }

    function setDeliveryInfoID($DeliveryInfoID) {
        $this->DeliveryInfoID = $DeliveryInfoID;
    }

    function setGoodsID($GoodsID) {
        $this->GoodsID = $GoodsID;
    }

    function setAmount($Amount) {
        $this->Amount = $Amount;
    }

    function setQualityIsOK($QualityIsOK) {
        $this->QualityIsOK = $QualityIsOK;
    }

}
