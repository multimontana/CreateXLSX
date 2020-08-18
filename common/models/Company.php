<?php

namespace common\models;

use Yii;



class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }



    /**
     * Gets query for [[CompanyTargets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyTargets()
    {
        return $this->hasMany(CompanyTargets::class, ['companyid' => 'id']);
    }
    public function getMarkets() {
        return $this->hasMany(Targets::className(), ['id' => 'targetid'])
            ->viaTable('company_targets', ['targetid' => 'id']);
    }
}
