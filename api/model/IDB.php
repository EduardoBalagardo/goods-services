<?php

interface IDB
{
    const USER = 'hempmexc_goods';
    const PASS = 'goods.services.1234';
    const HOST = 'localhost';
    const DB = 'hempmexc_goods_services';

    public function filter($data, $type);
}
