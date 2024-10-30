=== WP移行専用プラグイン for CPI ===
Contributors: kddiwebcommunications
Tags: migration, 移行, 乗り換え
Requires at least: 5.1
Tested up to: 6.4
Stable tag: 1.0.2
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

CPI のレンタルサーバーへのサーバー間移行が簡単に行えます。移行元サーバーから設定情報、データベース画像などのコンテンツデータをまとめて移行できます。

== Description ==

CPI のレンタルサーバーへのサーバー間移行が簡単に行えるプラグインです。
移行元サーバーから設定情報、データベース、画像などのコンテンツデータを、まとめて移行することができます。

## ■利用時の事前準備

サーバー間の移行は、移行元サーバー、移行先サーバーの双方に本プラグインのインストールが必要です。
なお、移行元、移行先で対応する WordPress バージョンが異なりますので、ご確認の上、ご利用ください。

## ■提供機能

このプラグインでは、「移行元サーバーでのエクスポート」「移行先サーバーへのインポート」「バックアップの作成」が行えます。

#### 【エクスポート】

移行元の WordPress から構成データファイルを作成して出力します。
エクスポート時に文字列置換も行えますので、サイト移設時の「ドメイン名の変更」「ディレクトリの変更」時も一括で置換した構成データファイルを作成することが可能です。

#### 【インポート】

移行先の WordPress で生成した構成データファイルを指定し、エクスポートした環境を復元できます。

#### 【バックアップ】

本プラグインでインポートできるバックアップデータ（構成データファイル）をサーバー上に生成します。ダウンロードとバックアップデータの削除が行えます。

※詳しいプラグインの使い方・注意事項は[サポートサイト](https://support.cpi.ad.jp/contents/wp-plugin_for_cpi.html "サポートサイト")をご確認ください。

== Installation ==

詳しいプラグインのインストール方法および注意事項は[サポートサイト](https://support.cpi.ad.jp/contents/wp-plugin_for_cpi.html "サポートサイト")をご確認ください

== Frequently Asked Questions ==

本プラグインの使用方法は、[サポートサイト](https://support.cpi.ad.jp/contents/wp-plugin_for_cpi.html "サポートサイト")よりご確認ください。
また、お困りごとがあった際にはトラブルシューティングをご確認ください。

== Changelog ==

= 1.0.2 =

* Response to uploading files up to 10GB.

= 1.0.1 =

* Improve several Japanese translations.

= 1.0 =

* Initial release.
* This plugin was developed based on [All-in-One WP Migration](https://wordpress.org/plugins/all-in-one-wp-migration/) 7.14.
