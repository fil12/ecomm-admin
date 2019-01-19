<?php

namespace backend\modules\Categories\Service;


use backend\modules\Categories\models\Category;
use yii\data\ArrayDataProvider;
use yii\debug\models\timeline\DataProvider;

class CategoryService
{


    public  function getProductByCategory(Category $category)
    {
        $provider = new ArrayDataProvider([
            'allModels' => $category->products,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'title', 'price','is_published'],
            ],
        ]);

        return $provider ?? self::NO_PRODUCTS;
    }


}