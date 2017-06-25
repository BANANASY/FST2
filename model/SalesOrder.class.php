<?php

class salesOrder {

    private $salesId;
    private $goods = [];

    public function __construct($salesId) {
        $this->salesId = $salesId;
        $this->fillGoods();
    }

    private function fillGoods() {
        $db = new DB();
        $this->goods = $db->getGoods($this->salesId);
//        var_dump($goods);
    }

    public function getGoods() {
        return $this->goods;
    }

    public function getGoodsCount() {
        return count($this->goods);
    }

    public function isReadyForShipping() {
        $ready = true;
        foreach ($this->goods as $g) {
            if (!$g->ensureStockAmount()) {
                $ready = false;
            }
        }
        return $ready;
    }

    public function deductFromStock() {
        $success = true;
        foreach ($this->goods as $g) {
            if (!$g->deductFromStock()) {
                $success = false;
            }
        }
        return $success;
    }

    public function printGoods() {
        

        foreach ($this->goods as $g) {
            $g->printAccordeon($this->salesId);
        }

    }

}
