<?php

namespace app\models;

use yii\base\Model;

class ReportForm extends Model
{
    public $year;
    
    public function rules()
    {
        return [
            ['year', 'integer'],
            ['year', 'default', 'value' => date('Y')],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'year' => 'Год',
        ];
    }
}