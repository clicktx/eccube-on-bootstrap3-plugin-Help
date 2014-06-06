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

// {{{ requires
require_once CLASS_EX_REALDIR . 'page_extends/LC_Page_Ex.php';

/**
 * ヘルプ のページクラス.
 *
 * @package Page
 * @author CUORE CO.,LTD.
 * @version $Id: LC_Page_Help.php 1 2009-08-04 00:00:00Z $
 */
class plg_Help_LC_Page_Help extends LC_Page_Ex {

    // }}}
    // {{{ functions

    /**
     * Page を初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();
        $this->tpl_page_category = 'help';
        $this->tpl_title = plg_Help_PAGE_TITLE;
    }

    /**
     * Page のプロセス.
     *
     * @return void
     */
    function process() {
        parent::process();
        $this->action();
        $this->sendResponse();
    }

    /**
     * Page のアクション.
     *
     * @return void
     */
    function action() {
        //ヘルプ内容の取得
        $objQuery =& SC_Query_Ex::getSingletonInstance();

        // デバイスタイプチェック
        if (SC_Display_Ex::detectDevice() == DEVICE_TYPE_MOBILE) {
            // モバイルの場合
            // IDチェック
            if (@$_GET['page'] < 1) {
                // 指定なしの場合、一覧画面
                $column = "h1.help_id, h1.help_category, h1.help_question, h1.help_answer, h2.name";
                $table = "plg_help_dtb_help h1, plg_help_mtb_help h2";
                $where = "h1.help_category = h2.id AND h1.del_flg <> 1";
                $order = "h1.help_category, h1.rank DESC";

                $objQuery->setorder($order);
            } else {
                // 指定ありの場合、詳細画面
                $this->tpl_mainpage = 'plugin/Help/plg_Help_help_detail.tpl';

                $column = "h1.help_question, h1.help_answer";
                $table = "plg_help_dtb_help h1";
                $where = "h1.help_id = ". @$_GET['page'];
            }
        } else {
            // モバイル以外の場合
            $column = "h1.help_category, h1.help_question, h1.help_answer, h2.name";
            $table = "plg_help_dtb_help h1, plg_help_mtb_help h2";
            $where = "h1.help_category = h2.id AND h1.del_flg = 0";
            $order = "h1.help_category, h1.rank DESC";

            $objQuery->setorder($order);
        }
        $this->arrHelp = $objQuery->select($column, $table, $where);
    }

    /**
     * デストラクタ.
     *
     * @return void
     */
    function destroy() {
        parent::destroy();
    }
}
?>
