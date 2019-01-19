<?php

namespace backend\modules\Products\models;

use Yii;

/**
 * This is the model class for table "product_parameters_value".
 *
 * @property int $id
 * @property string $value
 * @property string $created_at
 * @property string $updated_at
 * @property int $product_id
 * @property int $parameter_id
 *
 * @property Product $product
 * @property Parameters $parameter
 */
class ProductParametersValue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_parameters_value';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'product_id', 'parameter_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['product_id', 'parameter_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['parameter_id'], 'exist', 'skipOnError' => true, 'targetClass' => Parameters::className(), 'targetAttribute' => ['parameter_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'product_id' => 'Product ID',
            'parameter_id' => 'Parameter ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParameter()
    {
        return $this->hasOne(Parameters::className(), ['id' => 'parameter_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductParametersValueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductParametersValueQuery(get_called_class());
    }
}
