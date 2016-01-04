<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ADDENDA".
 *
 * @property string $NO_INSCRIPTION
 * @property integer $NO_ADDENDA
 * @property string $CODE_LANGUE
 * @property integer $ORDRE_AFFICHAGE
 * @property string $CHAMP_INUTILISE_1
 * @property string $CHAMP_INUTILISE_2
 * @property string $TEXTE
 */
class Addenda extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ADDENDA';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NO_INSCRIPTION', 'CODE_LANGUE', 'CHAMP_INUTILISE_1', 'CHAMP_INUTILISE_2', 'TEXTE'], 'string'],
            [['NO_ADDENDA', 'ORDRE_AFFICHAGE'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'NO_INSCRIPTION' => 'No  Inscription',
            'NO_ADDENDA' => 'No  Addenda',
            'CODE_LANGUE' => 'Code  Langue',
            'ORDRE_AFFICHAGE' => 'Ordre  Affichage',
            'CHAMP_INUTILISE_1' => 'Champ  Inutilise 1',
            'CHAMP_INUTILISE_2' => 'Champ  Inutilise 2',
            'TEXTE' => 'Texte',
        ];
    }
}
