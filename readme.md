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
          - → 自己採点方式に変更
        - 正解・不正解を記録
    - 結果が表示される
- 会員登録できる
- 問題集を作成できる
- 問題を作成できる

## ToDo
- [x] Workbook（問題集）クラス作成
  - [x] Exercise（問題）クラスの設計
  - [x] Workbookクラスの設計
- [x] Workbookを取得するクラス作成とメソッド作成
  - [x] Use caseクラス作成
  - [x] Domainクラス作成
  - [x] Repository作成
- [x] Workbook一覧を表示するクラス作成
  - [x] Workbook一覧表示Viewのクラス作成
  - [x] Workbook表示のコントローラ作成
  - [x] Workbook一覧表示のRoute作成
- [x] 指定したWorkbookをExercise（問題）を含めて取得するメソッド作成
- [ ] 問題に回答できる画面を作成
  - [x] サンプル問題、問題集用のSeed作成
  - [ ] 問題と解答を一覧で表示
  - [ ] 解答を隠して表示できるView作成
  - [ ] 自己採点でマルとバツを記録できるボタン配置
  - [ ] 採点画面に移動するボタン作成
  - [ ] 採点画面作成
- 解答時のセッションを管理するメソッド作成
- History（問題回答履歴）クラス作成
- 問題履歴を保存するメソッド作成
- 結果を取得して表示する画面作成

## License
The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
