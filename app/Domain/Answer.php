<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/05/06
 * Time: 16:21
 */

namespace App\Domain;


class Answer
{
    protected $exercise_list = [];

    protected $ok_count = 0;

    protected $ng_count = 0;

    protected $studying_count = 0;

    public function __construct($request)
    {
        if (!is_array($request->exercise_list)) {
            throw new DomainException("問題集が配列ではありません。");
        }
        if (count($request->exercise_list) == 0) {
            throw new DomainException("問題集が設定されていません。");
        }
        $this->exercise_list = $request->exercise_list;
        foreach ($this->exercise_list as $exercise) {
            if (!isset($request->$exercise)) {
                throw new DomainException("回答されていない問題があります。");
            }
            switch ($request->$exercise) {
                case 'ok':
                    $this->ok_count++;
                    break;
                case 'ng':
                    $this->ng_count++;
                    break;
                case 'studying':
                    $this->studying_count++;
                    break;
                default:
                    throw new DomainException("不正な回答が設定されています。");
            }
        }
    }

    public function getExerciseCount()
    {
        return count($this->exercise_list);
    }
    public function getOKCount()
    {
        return $this->ok_count;
    }
    public function getNGCount()
    {
        return $this->ng_count;
    }
    public function getStudyingCount()
    {
        return $this->studying_count;
    }
    public function toGraphData() {
        return [
            'labels' => ['OK', 'Studying', 'NG'],
            'datasets' => [
                'label' => '回答数',
                'backgroundColor' => '#f87979',
                'data' =>[
                    $this->ok_count,
                    $this->studying_count,
                    $this->ng_count
                ],
            ],
        ];
    }
}
