<?php

namespace backend\modules\Products\models;

/**
 * This is the ActiveQuery class for [[ProductImages]].
 *
 * @see ProductImages
 */
class ProductImagesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProductImages[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductImages|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
