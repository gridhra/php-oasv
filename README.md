# [WIP] php-oasv

実装途中です。気長に待ってください。

PHPのHttpResponse ObjectとOASのスキーマとを比較検査するための軽量ライブラリです。

主にPHPUnitのassertion toolとしてAPIを構成するつもりでいます。

## 課題感

- 既存ツールのエラーハンドリング周りが煩雑であり、メッセージもわかりにくい
- 既存ツールを使うにしても、PHPUnit Testでの利用に最適化されておらず、いずれにせよラッパーライブラリを構成する必要がある
- メンテナとして参加していないプロジェクト・プロダクトのOAS課題を解決するのが面倒（これだけ入れておいて、で済ませたい）

## TODO

- [ ] Implementation
- [ ] Testing
- [ ] upload to Packagist
- [ ] Writing README.md in English
- [ ] Writing documentation
