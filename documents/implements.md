# 実装について
以下のようなアーキテクチャで実装を行いたい。
https://little-hands.hatenablog.com/entry/2018/12/10/ddd-architecture

- 以下のような役割で実装する。
  - 作成・更新時
    - Controller
      - RequestでPOSTされた情報を受ける。
      - FormRequestクラスの拡張したものでValidationを行う。
      - RequestからrequestやsessionからDTOを取得する。
      - UseCaseにDTOを渡す。
    - UseCase
      - DTOをDomainクラスに変換する。
      - 権限確認など必要なメソッドを呼び出す。
      - DomainクラスをInfrastructureクラスに渡す。
    - Infrastructure
      - DomainクラスをORMのModelに変換する。
      - 登録や編集を行う。
  - 一覧・詳細表示時
    - Controller
      - GETパラメータからクエリのパラメータを受け取る。
      - FormRequestクラスの拡張したものでValidationを行う。
      - UseCaseクラスに問い合わせる。
      - 取得したDTOをそのままViewに渡して表示する。
    - UseCase
      - Infrastructureクラスに問い合わせてDomainクラスを取得する。
      - DTOクラスに詰めてControllerに返す。
    - Infrastructure
      - ORMのモデルにパラメータを合わせて問い合わせる。
      - 取得したデータをドメインモデルに詰めてUseCaseに返す。
