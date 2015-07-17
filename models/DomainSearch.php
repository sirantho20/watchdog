<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Domain;

/**
 * DomainSearch represents the model behind the search form about `app\models\Domain`.
 */
class DomainSearch extends Domain
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['domain_id', 'notify_when_down', 'notify_when_up', 'account_id', 'watch_mx', 'watch_dns', 'watch_ip'], 'integer'],
            [['domain', 'date_added', 'date_updated', 'added_ip', 'updated_ip'], 'safe'],
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
        $query = Domain::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }

        $query->andFilterWhere([
            'domain_id' => $this->domain_id,
            'notify_when_down' => $this->notify_when_down,
            'notify_when_up' => $this->notify_when_up,
            'account_id' => $this->account_id,
            'date_added' => $this->date_added,
            'date_updated' => $this->date_updated,
            'watch_mx' => $this->watch_mx,
            'watch_dns' => $this->watch_dns,
            'watch_ip' => $this->watch_ip,
        ]);

        $query->andFilterWhere(['like', 'domain', $this->domain])
            ->andFilterWhere(['like', 'added_ip', $this->added_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
