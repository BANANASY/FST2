<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GoodsLight
 *
 * @author pc7227
 */
class GoodsLight {

    private $goodsID;
    private $name;
    private $manufacturer;
    private $storageLocation;
    private $unit;
    private $minAmount;
    private $stockAmount;
    private $isOrdered;
    private $orderedAmount;

    public function __construct($goodsID, $name, $manufacturer, $storageLocation, $unit, $minAmount, $stockAmount, $isOrdered, $orderedAmount) {
        $this->goodsID = $goodsID;
        $this->name = $name;
        $this->manufacturer = $manufacturer;
        $this->storageLocation = $storageLocation;
        $this->unit = $unit;
        $this->minAmount = $minAmount;
        $this->stockAmount = $stockAmount;
        $this->isOrdered = $isOrdered;
        $this->orderedAmount = $orderedAmount;
    }

    public function getGoodsID() {
        return $this->GoodsID;
    }

    public function getName() {
        return $this->Name;
    }

    public function getManufacturer() {
        return $this->Manufacturer;
    }

    public function getStorageLocation() {
        return $this->StorageLocation;
    }

    public function getUnit() {
        return $this->Unit;
    }

    public function getMinAmount() {
        return $this->MinAmount;
    }

    public function getStockAmount() {
        return $this->StockAmount;
    }

    public function getActive() {
        return $this->Active;
    }

    public function getIsOrdered() {
        return $this->IsOrdered;
    }

    public function getOrderedAmount() {
        return $this->orderedAmount;
    }

    public function ensureStockAmount() {
        if ($this->stockAmount - $this->orderedAmount >= 0) {
//            echo "Stock: ".$this->stockAmount."<br>Ordered: ". $this->orderedAmount."<br>";
            return true;
        } else {
            return false;
        }
    }

    public function deductFromStock() {
        $db = new DB();
        $newStockAmount = $this->stockAmount - $this->orderedAmount;
        if ($db->setNewStock($newStockAmount, $this->goodsID)) {
//            echo "Stock: ".$this->stockAmount."<br>Ordered: ". $this->orderedAmount."<br>";
            return true;
        } else {
            return false;
        }
    }

    public function printAccordeon($salesId) {
        echo "<tr class='collapse accordion s$salesId' active>";
        echo "<td colspan='5'><b>$this->name</b> <em>$this->manufacturer</em><br>Ordered ($this->orderedAmount)<br><span class='pull-left'>located at $this->storageLocation</span><span class='badge pull-right'>goodsId ($this->goodsID)</span>  </td>";
        echo "</tr>";
    }

}
