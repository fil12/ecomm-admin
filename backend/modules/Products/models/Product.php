<?php

namespace backend\modules\Products\models;

use backend\modules\Categories\models\CategoriesProducts;
use backend\modules\Categories\models\Category;
use backend\modules\Orders\models\OrderProduct;
use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $title
 * @property double $price
 * @property string $description
 * @property string $sku
 * @property int $is_recommended
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_published
 *
 * @property CategoriesProducts[] $categoriesProducts
 * @property Category[] $categories
 * @property OrderProduct[] $orderProducts
 * @property ProductImages[] $productImages
 * @property ProductParametersValue[] $productParametersValues
 * @property int $qty
 */
class Product extends \yii\db\ActiveRecord
{

    const NO_PRODUCTS = 'no products';

    /**
     * @var $qty - contains the 'qty' property
     * of the related model OrderProducts
     */
    public $qty;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'price', 'sku', 'created_at', 'updated_at', 'is_published'], 'required'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['is_recommended', 'is_published'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['sku'], 'string', 'max' => 25],
        ];
    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'price' => 'Price',
            'description' => 'Description',
            'sku' => 'Sku',
            'is_recommended' => 'Is Recommended',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_published' => 'Is Published',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriesProducts()
    {
        return $this->hasMany(CategoriesProducts::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('categories_products', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImages::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductParametersValues()
    {
        return $this->hasMany(ProductParametersValue::className(), ['product_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }
}
