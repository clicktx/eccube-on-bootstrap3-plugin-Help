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

class Help extends SC_Plugin_Base {

    /**
     * コンストラクタ
     *
     */
    public function __construct(array $arrSelfInfo) {
        parent::__construct($arrSelfInfo);
    }

    /**
     * インストール
     * installはプラグインのインストール時に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin plugin_infoを元にDBに登録されたプラグイン情報(dtb_plugin)
     * @return void
     */
    function install($arrPlugin) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        // テーブル作成
        switch(DB_TYPE){
        	case "pgsql": //Postgres
                $create_mtb_sql  = <<< __EOS__
            CREATE TABLE plg_help_mtb_help (
                id smallint,
                name text,
                rank smallint NOT NULL DEFAULT 0,
                PRIMARY KEY (id)
            );
__EOS__;
                $create_dtb_sql  = <<< __EOS__
            CREATE TABLE plg_help_dtb_help (
                help_id int NOT NULL UNIQUE,
                help_category smallint NOT NULL,
                help_question text NOT NULL,
                help_answer text NOT NULL,
                rank int NOT NULL DEFAULT 0,
                creator_id int NOT NULL,
                create_date timestamp NOT NULL,
                update_date timestamp NOT NULL,
                del_flg smallint NOT NULL DEFAULT 0
            );
__EOS__;
                $create_seq_sql  = <<< __EOS__
            CREATE SEQUENCE plg_help_dtb_help_help_id_seq INCREMENT 1 START 15;
__EOS__;
                break;

        	case "mysql": //MySQL
                $create_mtb_sql  = <<< __EOS__
            CREATE TABLE plg_help_mtb_help (
                id smallint,
                name text,
                rank smallint NOT NULL DEFAULT 0,
                PRIMARY KEY (id)
            );
__EOS__;
                $create_dtb_sql  = <<< __EOS__
            CREATE TABLE plg_help_dtb_help (
                help_id int NOT NULL,
                help_category smallint NOT NULL,
                help_question text NOT NULL,
                help_answer text NOT NULL,
                rank int NOT NULL DEFAULT 0,
                creator_id int NOT NULL,
                create_date timestamp NOT NULL,
                update_date timestamp NOT NULL,
                del_flg smallint NOT NULL DEFAULT 0,
                PRIMARY KEY (help_id)
            );
__EOS__;
                $create_seq_sql  = <<< __EOS__
            CREATE TABLE plg_help_dtb_help_help_id_seq (
                sequence INT NOT NULL AUTO_INCREMENT,
                PRIMARY KEY(sequence)
            );
__EOS__;
                break;
        }

        $objQuery->query($create_mtb_sql);
        $objQuery->query($create_dtb_sql);
        $objQuery->query($create_seq_sql);

        // 初期データ追加
        $sqlval_plugin = array();
        $sqlval_plugin['free_field1'] = "ヘルプ";
        $sqlval_plugin['update_date'] = 'CURRENT_TIMESTAMP';
        $where = "plugin_code = ?";
        // UPDATEの実行
        $objQuery->update('dtb_plugin', $sqlval_plugin, $where, array('Help'));

        // dtb_blocpositionへデータ追加
        $device_type_id = DEVICE_TYPE_PC;
        $page_id = $objQuery->nextVal('dtb_pagelayout_page_id');
        $target_id = 1;
        $bloc_id = array(1,2,3);
        $bloc_row = array(2,3,1);
        $anywhere = 0;
        for($i=0;$i<3;$i++){
            $sqlval_blocposition = array();
            $sqlval_blocposition['device_type_id'] = $device_type_id;
            $sqlval_blocposition['page_id'] = $page_id;
            $sqlval_blocposition['target_id'] = $target_id;
            $sqlval_blocposition['bloc_id'] = $bloc_id[$i];
            $sqlval_blocposition['bloc_row'] = $bloc_row[$i];
            $sqlval_blocposition['anywhere'] = $anywhere;
            $objQuery->insert("dtb_blocposition", $sqlval_blocposition);
        }
        // dtb_pagelayoutへデータ追加
        $device_type_id = array(DEVICE_TYPE_PC,DEVICE_TYPE_SMARTPHONE,DEVICE_TYPE_MOBILE);
        $page_name = 'ヘルプ';
        $url = 'plugin/Help/plg_Help_index.php';
        $filename = 'plugin/Help/plg_Help_index';
        for($i=0;$i<3;$i++){
            $sqlval_pagelayout = array();
            $sqlval_pagelayout['device_type_id'] = $device_type_id[$i];
            $sqlval_pagelayout['page_id'] = $page_id;
            $sqlval_pagelayout['page_name'] = $page_name;
            $sqlval_pagelayout['url'] = $url;
            $sqlval_pagelayout['filename'] = $filename;
            $sqlval_pagelayout['header_chk'] = 1;
            $sqlval_pagelayout['footer_chk'] = 1;
            $sqlval_pagelayout['edit_flg'] = 2;
            $sqlval_pagelayout['create_date'] = "CURRENT_TIMESTAMP";
            $sqlval_pagelayout['update_date'] = "CURRENT_TIMESTAMP";
            $objQuery->insert("dtb_pagelayout", $sqlval_pagelayout);
        }

        // mtb_helpへデータ追加
        $name = array('配送','注文','支払い','返品・返金','登録情報・注文内容の変更','プライバシー・保証','各種サービス');
        for($i=0;$i<7;$i++){
            $sqlval_mtb_help = array();
            $sqlval_mtb_help['id'] = $i + 1;
            $sqlval_mtb_help['name'] = $name[$i];
            $sqlval_mtb_help['rank'] = $i;
            $objQuery->insert("plg_help_mtb_help", $sqlval_mtb_help);
        }

        // dtb_helpへデータ追加
        $help_category = array(1,1,2,2,3,3,4,4,5,5,6,6,7,7);
        $help_question = array('カテゴリ１内容１','カテゴリ１内容２','カテゴリ２内容１','カテゴリ２内容２','カテゴリ３内容１','カテゴリ３内容２','カテゴリ４内容１','カテゴリ４内容２','カテゴリ５内容１','カテゴリ５内容２','カテゴリ６内容１','カテゴリ６内容２','カテゴリ７内容１','カテゴリ７内容２');
        $help_answer = array('カテゴリ１回答１','カテゴリ１回答２','カテゴリ２回答１','カテゴリ２回答２','カテゴリ３回答１','カテゴリ３回答２','カテゴリ４回答１','カテゴリ４回答２','カテゴリ５回答１','カテゴリ５回答２','カテゴリ６回答１','カテゴリ６回答２','カテゴリ７回答１','カテゴリ７回答２');
        for($i=0;$i<14;$i++){
            $sqlval_dtb_help = array();
            $sqlval_dtb_help['help_id'] = $i + 1;
            $sqlval_dtb_help['help_category'] = $help_category[$i];
            $sqlval_dtb_help['help_question'] = $help_question[$i];
            $sqlval_dtb_help['help_answer'] = $help_answer[$i];
            $sqlval_dtb_help['rank'] = $i + 1;
            $sqlval_dtb_help['creator_id'] = 0;
            $sqlval_dtb_help['create_date'] = CURRENT_TIMESTAMP;
            $sqlval_dtb_help['update_date'] = CURRENT_TIMESTAMP;
            $sqlval_dtb_help['del_flg'] = 0;
            $objQuery->insert("plg_help_dtb_help", $sqlval_dtb_help);
        }

        //MySQLシーケンス値設定
        switch(DB_TYPE){
            case "mysql":
                $insert_seq_sql = array (
                    "sequence" => 14
                ) ;
                $objQuery->insert('plg_help_dtb_help_help_id_seq',$insert_seq_sql);
                break;
            default :
                break;
        }

        // ファイルのコピー
        if(copy(PLUGIN_UPLOAD_REALDIR . "Help/templates/admin/plg_Help_help.tpl", TEMPLATE_ADMIN_REALDIR . "basis/plg_Help_help.tpl") === false) print_r("失敗");
        if(copy(PLUGIN_UPLOAD_REALDIR . "Help/admin/basis/plg_Help_help.php", HTML_REALDIR . ADMIN_DIR . "basis/plg_Help_help.php") === false) print_r("失敗");
        if(!file_exists(TEMPLATE_REALDIR . "plugin"))mkdir(TEMPLATE_REALDIR . "plugin");
        if(!file_exists(TEMPLATE_REALDIR . "plugin/Help"))mkdir(TEMPLATE_REALDIR . "plugin/Help");
        if(SC_Utils_Ex::sfCopyDir(PLUGIN_UPLOAD_REALDIR . "Help/templates/default/", TEMPLATE_REALDIR . "plugin/Help/") === false) print_r("失敗");
        if(!file_exists(MOBILE_TEMPLATE_REALDIR . "plugin"))mkdir(MOBILE_TEMPLATE_REALDIR . "plugin");
        if(!file_exists(MOBILE_TEMPLATE_REALDIR . "plugin/Help"))mkdir(MOBILE_TEMPLATE_REALDIR . "plugin/Help");
        if(SC_Utils_Ex::sfCopyDir(PLUGIN_UPLOAD_REALDIR . "Help/templates/mobile/", MOBILE_TEMPLATE_REALDIR . "plugin/Help/") === false) print_r("失敗");
        if(!file_exists(SMARTPHONE_TEMPLATE_REALDIR . "plugin"))mkdir(SMARTPHONE_TEMPLATE_REALDIR . "plugin");
        if(!file_exists(SMARTPHONE_TEMPLATE_REALDIR . "plugin/Help"))mkdir(SMARTPHONE_TEMPLATE_REALDIR . "plugin/Help");
        if(SC_Utils_Ex::sfCopyDir(PLUGIN_UPLOAD_REALDIR . "Help/templates/sphone/", SMARTPHONE_TEMPLATE_REALDIR . "plugin/Help/") === false) print_r("失敗");
        if(!file_exists(PLUGIN_HTML_REALDIR . "Help"))mkdir(PLUGIN_HTML_REALDIR . "Help");
        if(copy(PLUGIN_UPLOAD_REALDIR . "Help/plg_Help_index.php", PLUGIN_HTML_REALDIR . "Help/plg_Help_index.php") === false) print_r("失敗");
        if(copy(PLUGIN_UPLOAD_REALDIR . "Help/logo.png", PLUGIN_HTML_REALDIR . "Help/logo.png") === false) print_r("失敗");
        if(!file_exists(PLUGIN_HTML_REALDIR . "Help/media"))mkdir(PLUGIN_HTML_REALDIR . "Help/media");
        if(SC_Utils_Ex::sfCopyDir(PLUGIN_UPLOAD_REALDIR . "Help/media/", PLUGIN_HTML_REALDIR . "Help/media/") === false) print_r("失敗");
    }

    /**
     * アンインストール
     * uninstallはアンインストール時に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    function uninstall($arrPlugin) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();

        //テーブルの削除
        $objQuery->query("DROP TABLE plg_help_mtb_help;");
        $objQuery->query("DROP TABLE plg_help_dtb_help;");

        //シーケンスの削除
        switch(DB_TYPE){
            case "pgsql": //Postgres
                $drop_sql  = <<< __EOS__
                DROP SEQUENCE plg_help_dtb_help_help_id_seq;
__EOS__;
                break;
            case "mysql": //MySQL
                $drop_sql  = <<< __EOS__
                DROP TABLE plg_help_dtb_help_help_id_seq;
__EOS__;
                break;
        }
        $objQuery->query($drop_sql);

        // dtb_blocpositionテーブルからデータ削除
        $page_id = $objQuery->select('page_id', 'dtb_pagelayout', 'page_name = ? AND url = ?', array("ヘルプ", "plugin/Help/plg_Help_index.php"));
        $arr_where = array(array("device_type_id" => DEVICE_TYPE_PC, "page_id" => $page_id[0]['page_id'], "target_id" => 1, "bloc_id" => 1),
                           array("device_type_id" => DEVICE_TYPE_PC, "page_id" => $page_id[0]['page_id'], "target_id" => 1, "bloc_id" => 2),
                           array("device_type_id" => DEVICE_TYPE_PC, "page_id" => $page_id[0]['page_id'], "target_id" => 1, "bloc_id" => 3));
        foreach($arr_where as $where){
            $objQuery->delete('dtb_blocposition','device_type_id = ? and page_id = ? and target_id = ? and bloc_id = ?',array ($where["device_type_id"],$where["page_id"],$where["target_id"],$where["bloc_id"]));
        }

        // dtb_pagelayoutテーブルからデータ削除
        $arr_where = array(array("device_type_id" => DEVICE_TYPE_PC, "page_id" => $page_id[0]['page_id']),
                           array("device_type_id" => DEVICE_TYPE_SMARTPHONE, "page_id" => $page_id[0]['page_id']),
                           array("device_type_id" => DEVICE_TYPE_MOBILE, "page_id" => $page_id[0]['page_id']));
        foreach($arr_where as $where){
            $objQuery->delete('dtb_pagelayout','device_type_id = ? and page_id = ?',array ($where["device_type_id"],$where["page_id"]));
        }

        // メディアディレクトリ削除.
        if(SC_Helper_FileManager_Ex::deleteFile(TEMPLATE_ADMIN_REALDIR . "basis/plg_Help_help.tpl") === false); // TODO エラー処理
        if(SC_Helper_FileManager_Ex::deleteFile(HTML_REALDIR . ADMIN_DIR . "basis/plg_Help_help.php") === false); // TODO エラー処理
        if(SC_Helper_FileManager_Ex::deleteFile(TEMPLATE_REALDIR . "plugin/Help") === false); // TODO エラー処理
        if(SC_Helper_FileManager_Ex::deleteFile(MOBILE_TEMPLATE_REALDIR . "plugin/Help") === false); // TODO エラー処理
        if(SC_Helper_FileManager_Ex::deleteFile(SMARTPHONE_TEMPLATE_REALDIR . "plugin/Help") === false); // TODO エラー処理
        if(SC_Helper_FileManager_Ex::deleteFile(PLUGIN_HTML_REALDIR . "Help") === false); // TODO エラー処理
    }

    /**
     * アップデート
     * updateはアップデート時に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    function update($arrPlugin) {
        // nop
    }

    /**
     * 稼働
     * enableはプラグインを有効にした際に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    function enable($arrPlugin) {
        // nop
    }

    /**
     * 停止
     * disableはプラグインを無効にした際に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    function disable($arrPlugin) {
        // nop
    }

    /**
     * スーパーフックポイント
     *
     * ヘルプ画面表記を取得する
     */
    function preProcess ($objPage) {
        $plugin = SC_Plugin_Util_Ex::getPluginByPluginCode("Help");
        $title = $plugin['free_field1'];
        define('plg_Help_PAGE_TITLE', $title);
    }

    /**
     * プレフィルタコールバック関数
     *
     * @param string &$source テンプレートのHTMLソース
     * @param LC_Page_Ex $objPage ページオブジェクト
     * @param string $filename テンプレートのファイル名
     * @return void
     */
    function prefilterTransform(&$source, LC_Page_Ex $objPage, $filename) {
        $objTransform = new SC_Helper_Transform($source);
        $template_dir = PLUGIN_UPLOAD_REALDIR . 'Help/templates/';
        switch($objPage->arrPageLayout['device_type_id']){
            case DEVICE_TYPE_MOBILE:
                if (strpos($filename, '/mobile/index.tpl') !== false) {
                    $objTransform->select()->replaceElement(file_get_contents($template_dir . 'plg_Help_snip_mobile_top.tpl'));
                }
                break;
            case DEVICE_TYPE_SMARTPHONE:
                if (strpos($filename, 'footer.tpl') !== false) {
                    $objTransform->select('nav.guide_area p a',1)->insertAfter(file_get_contents($template_dir . 'plg_Help_snip_sphone_footer.tpl'));
                }
                break;
            case DEVICE_TYPE_PC:
                if (strpos($filename, 'frontparts/bloc/guide.tpl') !== false) {
                    $objTransform->select('ul.button_like li',3)->insertAfter(file_get_contents($template_dir . 'plg_Help_snip_default_bloc_guide.tpl'));
                }
                break;
            case DEVICE_TYPE_ADMIN:
            default:
                if (strpos($filename, 'basis/subnavi.tpl') !== false) {
                    $objTransform->select('ul.level1 li',9)->insertAfter(file_get_contents($template_dir . 'plg_Help_snip_admin_basis_subnavi.tpl'));
                }
                break;
        }
        $source = $objTransform->getHTML();
    }

    /**
     * 処理の介入箇所とコールバック関数を設定
     * registはプラグインインスタンス生成時に実行されます
     *
     * @param SC_Helper_Plugin $objHelperPlugin
     * @return void
     */
    function register(SC_Helper_Plugin $objHelperPlugin) {
        // ヘッダへの追加
        $template_dir = PLUGIN_UPLOAD_REALDIR . 'Help/templates/';
        $objHelperPlugin->setHeadNavi($template_dir . 'plg_Help_header.tpl');
        $objHelperPlugin->addAction('prefilterTransform', array(&$this, 'prefilterTransform'), $this->arrSelfInfo['priority']);
    }
}
?>
