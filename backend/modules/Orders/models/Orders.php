<?php

namespace backend\modules\Orders\models;

use backend\modules\Products\models\Product;
use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $customer_id
 * @property string $shipping_method
 * @property string $status
 * @property string $comment
 * @property string $created_at
 * @property string $updated_at
 *
 * @property OrderProduct[] $orderProducts
 * @property Customers $customer
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id'], 'integer'],
            [['shipping_method', 'status', 'created_at', 'updated_at'], 'required'],
            [['comment'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['shipping_method', 'status'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customers::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'shipping_method' => 'Shipping Method',
            'status' => 'Status',
            'comment' => 'Comment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
//        return $this->hasMany(OrderProduct::className(), ['order_id' => 'id']);
        return $this->hasMany(Product::className(), ['id' => 'product_id'])
            ->viaTable('order_product', ['order_id' => 'id'])
            ->leftJoin('order_product', '{{product}}.id=product_id')
            ->select('{{product}}.*, order_product.qty') ;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customers::className(), ['id' => 'customer_id']);
    }

    /**
     * {@inheritdoc}
     * @return OrdersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrdersQuery(get_called_class());
    }
}
