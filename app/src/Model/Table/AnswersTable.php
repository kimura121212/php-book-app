<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RuleChecker;
use Cake\Validation\Validator;

// Qusetion Model

class QuestionsTable extends Table
{
    //バリデーションルールの定義
    // @param \Cake\Validation\Validator $validator バリデーションインスタンス
    // @return \Cake\Validation\Validator バリデーションインスタンス

    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id', 'IDが不正です')
            ->allowEmpty('id', 'create', 'IDが不正です');

        $validator
            ->scalar('body', '回答内容が不正です')
            ->requirePresence('body', 'create', '回答内容が不正です')
            ->notEmpty('body', '回答内容は必ず入力してください')
            ->maxLength('body', 140, '回答内容は140字以内で入力してください');

        return $validator;
    }

    // ルートチェッカーを作成する
    // @param \Cake\ORM\RuleChecker $rule ルールチェッカーのオブジェクト
    // @return \Cake\ORM\RuleChecker ルールチェッカーのオブジェクト
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(
            ['questin_id'],
            'Questions',
            '質問が既に削除されているため回答することができません'
        ));

        return $rules;
    }

    // @inheritdoc
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('answers'); //使用されるテーブル名
        $this->setDisplayField('id'); //list形式でデータ取得する際に使用されるカラム名
        $this->setPrimaryKey('id'); //プライマリーキーとなるカラム名

        $this->addBehavior('Timestamp'); //createdおよびmodifiedカラムを自動設定する

        $this->belongsTo('Questions', [
            'foreignKey' => 'question_id',
            'joinType' => 'INNER'
        ]);
    }
}