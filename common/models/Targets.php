<?php

namespace common\models;

use common\models\CompanyTargets;

use Yii;

class Targets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'targets';
    }


    /**
     * Gets query for [[CompanyTargets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyTargets()
    {
        return $this->hasMany(CompanyTargets::class, ['targetid' => 'id']);
    }
    public function getMarkets() {
        return $this->hasMany(Company::className(), ['id' => 'companyid'])
            ->viaTable('company_targets', ['companyid' => 'id']);
    }

}
