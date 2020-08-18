<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vulnerabilities".
 *
 * @property int $id
 * @property int|null $vendorId
 * @property string $version
 * @property string $CVE
 * @property string $link
 * @property int $risk
 * @property string|null $global_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property DetectedVulnerabilities[] $detectedVulnerabilities
 */
class Vulnerabilities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vulnerabilities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vendorId', 'risk'], 'integer'],
            [['version', 'CVE', 'link', 'risk'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['version', 'CVE'], 'string', 'max' => 64],
            [['link', 'global_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vendorId' => 'Vendor ID',
            'version' => 'Version',
            'CVE' => 'Cve',
            'link' => 'Link',
            'risk' => 'Risk',
            'global_id' => 'Global ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


}
