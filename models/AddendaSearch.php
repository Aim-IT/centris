<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Addenda;

/**
 * AddendaSearch represents the model behind the search form about `app\models\Addenda`.
 */
class AddendaSearch extends Addenda
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'NO_ADDENDA', 'ORDRE_AFFICHAGE'], 'integer'],
            [['NO_INSCRIPTION', 'CODE_LANGUE', 'CHAMP_INUTILISE_1', 'CHAMP_INUTILISE_2', 'TEXTE'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Addenda::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'NO_ADDENDA' => $this->NO_ADDENDA,
            'ORDRE_AFFICHAGE' => $this->ORDRE_AFFICHAGE,
        ]);

        $query->andFilterWhere(['like', 'NO_INSCRIPTION', $this->NO_INSCRIPTION])
            ->andFilterWhere(['like', 'CODE_LANGUE', $this->CODE_LANGUE])
            ->andFilterWhere(['like', 'CHAMP_INUTILISE_1', $this->CHAMP_INUTILISE_1])
            ->andFilterWhere(['like', 'CHAMP_INUTILISE_2', $this->CHAMP_INUTILISE_2])
            ->andFilterWhere(['like', 'TEXTE', $this->TEXTE]);

        return $dataProvider;
    }
}
