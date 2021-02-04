# MemoryExercise
Laravelの練習プロジェクト。
問題を自分で作って確認するWEBアプリ。ユーザ管理、投稿、表示を一通り実装したい。

## setup

    # run mysql and redis
    docker-compose up -d mysql redis
    # run vue.js with hot reload
    npm run hot
    # run laravel app
    php artisan serve

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
- [x] 問題集への問題登録方法の改善
- [ ] 未実装部分の実装
  - [ ] 問題登録時にユーザ情報も登録
  - [ ] 問題集登録時にユーザ情報も登録
  - [ ] 問題の削除機能追加
  - [ ] 問題集の削除機能追加
  - [ ] 問題詳細の表示
  - [ ] ラベル登録機能
  - [ ] ラベルで問題を検索する機能追加
- [ ] バグ修正
  - [ ] 問題追加のページ変更時にチェックが残っている

## License
The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
