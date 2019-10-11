<?php

namespace App\Model\Table;

use Cake\ORM\Table;

// Qusetion Model

class QuestionsTable extends Table
{
    // @inheritdoc
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('questions'); //使用されるテーブル名
        $this->setDisplayField('id'); //list形式でデータ取得する際に使用されるカラム名
        $this->setPrimaryKey('id'); //プライマリーキーとなるカラム名

        $this->addBehavior('Timestamp'); //createdおよびmodifiedカラムを自動設定する

        $this->hasMany('Answers', [
            'foreignKey' => 'question_id'
        ]);
    }

    //回答付きの質問一覧を取得する
    //@return \Cake\ORM\Query 回答付きの質問一覧クエリ

    public function findQuestionsWithAnsweredCount()
    {
        $query = $this->Questions->find();
        $query
            ->select(['answered_count' => $query->func()->count('Answer.id')])
            ->leftJoinWith('Answers')
            ->group(['Questions.id'])
            ->enableAutoFields(true);

        return $query;
    }
}