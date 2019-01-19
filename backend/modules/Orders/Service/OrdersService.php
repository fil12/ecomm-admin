<?php

namespace app\modules\Orders\Service;


use backend\modules\Orders\models\Orders;
use backend\modules\Products\models\Product;
use yii\data\ArrayDataProvider;

/**
 * Created by PhpStorm.
 * User: dev-alexf
 * Date: 19.01.19
 * Time: 15:55
 */

class OrdersService
{
    public function getOrderProducts(Orders $orders)
    {
        $provider = new ArrayDataProvider([
            'allModels' => $orders->orderProducts,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'title', 'price','is_published', 'qty'],
            ],
        ]);

        return $provider ?? Product::NO_PRODUCTS;    }
}