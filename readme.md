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
- [x] 問題集を編集できるようにする
  - [x] 編集画面作成
  - [x] 一覧で自分の作成した問題集には編集ボタンが表示する
- [x] データが無い時の挙動
  - [x] 問題の登録されていない問題集は戻るボタンのみ表示させる
  - [x] 問題集でタイトルない時
  - [x] 問題、答えがない時
- [x] データの最大値
  - [x] 問題集タイトル最大値以上入力時の挙動
  - [x] 問題集説明文最大値以上入力時の挙動
  - [x] 問題の質問最大値以上入力時の挙動
  - [x] 問題の答え最大値以上入力時の挙動
- [ ] 問題集への問題登録方法の改善

## License
The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
