<?php

namespace backend\modules\Categories\models;

/**
 * This is the ActiveQuery class for [[CategoriesProducts]].
 *
 * @see CategoriesProducts
 */
class CategoriesProductsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CategoriesProducts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CategoriesProducts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
