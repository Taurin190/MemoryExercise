# MemoryExercise
Laravelの練習プロジェクト。
問題を自分で作って確認するWEBアプリ。ユーザ管理、投稿、表示を一通り実装したい。

## Requirement
- 登録されている問題を回答できる
  - 自分の作ったもしくは他の人が作った問題集に回答できる
    - 問題集を一覧が表示される
      - 全ての問題集を取得
        - 問題の詳細は取らず問題集のみ全取得
      - 問題集のidを付けたリンク表示
    - リンクを踏んだ問題集の詳細に遷移
    - 一つずつ全ての問題に回答できる
      - 問題集に紐づく全問題を取得
      - 問題に回答
        - 表示４択より回答を選択
        - 正解・不正解を記録
    - 結果が表示される
- 会員登録できる
- 問題集を作成できる
- 問題を作成できる

## ToDo
- [ ] Workbook（問題集）クラス作成
  - [ ] Exercise（問題）クラスの設計
  - [ ] Workbookクラスの設計
- Workbookを取得するクラス作成とメソッド作成
- Workbook一覧を表示するクラス作成
- 指定したWorkbookをExercise（問題）を含めて取得するメソッド作成
- 問題に回答できる画面を作成
- 解答時のセッションを管理するメソッド作成
- History（問題回答履歴）クラス作成
- 問題履歴を保存するメソッド作成
- 結果を取得して表示する画面作成

## License
The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
