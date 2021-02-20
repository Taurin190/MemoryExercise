<?php

namespace App\Dto;

/**
 * Class ExerciseDto
 * データを入れるだけのクラス
 * - publicにしているが代入して変更を行わない
 * - Domainを作成時の引数として使う
 * - Viewへの出力する時はDomainから取得する
 * - Viewで表示する時に値を取り出す
 * @package App\Dto
 */
class ExerciseDto
{
    public $exercise_id;

    public $question;

    public $answer;

    public $permission;

    public $label_list;

    public $user_id;

    function __construct($question, $answer, $permission, $user_id, $exercise_id=null, $label_list = [])
    {
        $this->exercise_id = $exercise_id;
        $this->question = $question;
        $this->answer = $answer;
        $this->permission = $permission;
        $this->user_id = $user_id;
        $this->label_list = $label_list;
    }

    public function toArray() {
        return [
            "exercise_id" => $this->exercise_id,
            "question" => $this->question,
            "answer" => $this->answer,
            "permission" => $this->permission,
            "author_id" => $this->user_id,
            "user_id" => $this->user_id,
            "label_list" => $this->label_list
        ];
    }
}
