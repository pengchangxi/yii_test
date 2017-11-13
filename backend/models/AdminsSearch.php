<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Admins;

/**
 * AdminsSearch represents the model behind the search form about `backend\models\Admins`.
 */
class AdminsSearch extends Admins
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'role_id', 'status', 'errornum'], 'integer'],
            [['username','created_start', 'created_end', 'email', 'mobile', 'realname', 'nickname', 'password_hash', 'auth_key', 'avatar', 'created_at', 'updated_at', 'last_login_ip', 'last_login_time'], 'safe'],
        ];
    }

    public function attributes(){
        //添加属性
        return array_merge(parent::attributes(),['created_start','created_end']);
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
        $query = Admins::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>[
                    'id'=>SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'role_id' => $this->role_id,
            'status' => $this->status,
            'last_login_time' => $this->last_login_time,
            'errornum' => $this->errornum,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'realname', $this->realname])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'last_login_ip', $this->last_login_ip]);

        if ($this->created_start!='' && $this->created_end==''){
            $created = strtotime(date('Y-m-d 00:00:00',strtotime($this->created_start)));
            $query->andFilterWhere(['>= ', 'created_at ', $created]);
        }
        if ($this->created_end!="" && $this->created_start==''){
            $created= strtotime(date("Y-m-d 23:59:59",strtotime($this->created_end)));
            $query->andFilterWhere(['<=', 'created_at', $created]);
        }
        if ($this->created_start!="" && $this->created_end!=""){
            $start= strtotime(date("Y-m-d 00:00:00",strtotime($this->created_start)));
            $end= strtotime(date("Y-m-d 23:59:59",strtotime($this->created_end)));
            $query->andFilterWhere(['between', 'created_at', $start, $end]);
        }

        return $dataProvider;
    }
}
