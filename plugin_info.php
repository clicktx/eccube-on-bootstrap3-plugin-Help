<?php
/*
 * Help
 * 
 * Copyright(c) 2009-2012 CUORE CO.,LTD. All Rights Reserved.
 * 
 * http://ec.cuore.jp/
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

/**
 * ヘルプ機能プラグイン の情報クラス.
 *
 * @package Help
 * @author CUORE CO.,LTD.
 */
class plugin_info {
    /** プラグインコード(必須)：システム上でのキーとなります。プラグインコードは一意である必要があります。 */
    static $PLUGIN_CODE        = "Help";
    /** プラグイン名(必須)：プラグイン管理・画面出力（エラーメッセージetc）にはこの値が出力されます。 */
    static $PLUGIN_NAME        = "ヘルプ機能 for EC-CUBE on BootStrap3";
    /** プラグインメインクラス名(必須)：本体がプラグインを実行する際に呼ばれるクラス。拡張子は不要です。 */
    static $CLASS_NAME         = "Help";
    /** プラグインバージョン(必須) */
    static $PLUGIN_VERSION     = "1.3.4";
    /** 本体対応バージョン(必須) */
    static $COMPLIANT_VERSION  = "2.12.0～2.13.1";
    /** 作者(必須) */
    static $AUTHOR             = "clicktx";
    /** 説明(必須) */
    static $DESCRIPTION        = "ヘルプ機能を追加します。テンプレート「EC-CUBE on BootStrap3」に最適化済。";
    /** 作者用のサイトURL：設定されている場合はプラグイン管理画面の作者名がリンクになります。 */
    static $AUTHOR_SITE_URL    = "http://perl.no-tubo.net";
    /** プラグインのサイトURL : 設定されている場合はプラグイン管理画面の作者名がリンクになります。 */
    static $PLUGIN_SITE_URL   = "https://github.com/clicktx/eccube-on-bootstrap3-plugin-Help";
    /** ライセンス */
    static $LICENSE        = "LGPL";
}
?>
