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
    public $uuid;

    public $question;

    public $answer;

    public $permission;

    public $label_list;

    public $user_id;

    function __construct($question, $answer, $permission, $user_id, $uuid=null, $label_list = [])
    {
        $this->uuid = $uuid;
        $this->question = $question;
        $this->answer = $answer;
        $this->permission = $permission;
        $this->user_id = $user_id;
        $this->label_list = $label_list;
    }
}
