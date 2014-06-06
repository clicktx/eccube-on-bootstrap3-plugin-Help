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
require_once CLASS_EX_REALDIR . 'page_extends/admin/LC_Page_Admin_Ex.php';

/**
 * ヘルプ設定 のページクラス.
 *
 * @package Page
 * @author CUORE CO.,LTD.
 */
class plg_Help_LC_Page_Admin_Basis_Help extends LC_Page_Admin_Ex {

    // }}}
    // {{{ functions

    /**
     * Page を初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();
        $this->tpl_mainpage = 'basis/plg_Help_help.tpl';
        $this->tpl_subnavi = 'basis/subnavi.tpl';
        $this->tpl_subno = 'help';
        $this->tpl_subtitle = 'ヘルプ登録';
        $this->tpl_mainno = 'basis';
        $masterData = new SC_DB_MasterData_Ex();
        $this->arrCategory = $masterData->getMasterData("plg_help_mtb_help", array("id", "name", "rank"));
    }

    /**
     * Page のプロセス.
     *
     * @return void
     */
    function process() {
        $this->action();
        $this->sendResponse();
    }

    /**
     * Page のアクション.
     *
     * @return void
     */
    function action() {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objDb = new SC_Helper_DB_Ex();

        if(!isset($_POST['help_category'])) {
            $arrKeys = array_keys($this->arrCategory);
            $this->help_category = $arrKeys[0];
        } else {
            $this->help_category = $_POST['help_category'];
        }

        // 要求判定
        switch($this->getMode()) {
        // 編集処理
        case 'edit':
            // POST値の引き継ぎ
            $this->arrForm = $_POST;
            // 入力文字の変換
            $this->arrForm = $this->lfConvertParam($this->arrForm);
            // エラーチェック
            $this->arrErr = $this->lfErrorCheck($this->arrForm);
            if(count($this->arrErr) <= 0) {
                if($_POST['help_id'] == "") {
                    $this->lfInsertClass($this->arrForm);	// 新規作成
                } else {
                    $this->lfUpdateClass($this->arrForm);	// 既存編集
                }
                // ヘルプ内容・回答は初期化
                unset($this->arrForm['help_question']);
                unset($this->arrForm['help_answer']);
            } else {
                // POSTデータを引き継ぐ
                $this->tpl_help_id = $_POST['help_id'];
            }
            break;

        // 削除
        case 'delete':
            $objDb->sfDeleteRankRecord("plg_help_dtb_help", "help_id", $_POST['help_id'], "help_category = " . $this->help_category, true);
            break;
        // 編集前処理
        case 'pre_edit':
            // 編集項目をDBより取得する。
            $arrRet = $objQuery->select("help_category, help_question, help_answer", "plg_help_dtb_help", "help_id = ?", array($_POST['help_id']));
            // 入力項目にカテゴリ名を入力する。
            $this->arrForm['help_category'] = $arrRet[0]['help_category'];
            $this->arrForm['help_question'] = $arrRet[0]['help_question'];
            $this->arrForm['help_answer'] = $arrRet[0]['help_answer'];
            // POSTデータを引き継ぐ
            $this->tpl_help_id = $_POST['help_id'];
            break;
        case 'down':
            $objDb->sfRankDown("plg_help_dtb_help", "help_id", $_POST['help_id'], "help_category = " . $this->help_category);
            break;
        case 'up':
            $objDb->sfRankUp("plg_help_dtb_help", "help_id", $_POST['help_id'], "help_category = " . $this->help_category);
            break;
        default:
            break;
        }
        // ヘルプ情報の取得
        $objQuery->setorder("rank DESC");
        $this->arrHelp = $objQuery->select("help_id, help_category, help_question, help_answer", "plg_help_dtb_help", "help_category = ? AND del_flg = 0", array($this->help_category));
    }

    /**
     * デストラクタ.
     *
     * @return void
     */
    function destroy() {
        parent::destroy();
    }

    /* DBへの挿入 */
    function lfInsertClass($arrData) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        // INSERTする値を作成する。
        $sqlval['help_id'] = $objQuery->nextVal('plg_help_dtb_help_help_id');
        $sqlval['help_category'] = $arrData['help_category'];
        $sqlval['help_question'] = $arrData['help_question'];
        $sqlval['help_answer'] = $arrData['help_answer'];
        $sqlval['rank'] = $objQuery->max("rank", "plg_help_dtb_help", "help_category = " . $this->help_category) + 1;
        $sqlval['creator_id'] = $_SESSION['member_id'];
        $sqlval['create_date'] = "CURRENT_TIMESTAMP";
        $sqlval['update_date'] = "CURRENT_TIMESTAMP";
        // INSERTの実行
        $ret = $objQuery->insert("plg_help_dtb_help", $sqlval);
        return $ret;
    }

    /* DBへの更新 */
    function lfUpdateClass($arrData) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        // UPDATEする値を作成する。
        $sqlval['help_question'] = $arrData['help_question'];
        $sqlval['help_answer'] = $arrData['help_answer'];
        $sqlval['update_date'] = "CURRENT_TIMESTAMP";
        $where = "help_id = ?";
        // UPDATEの実行
        $ret = $objQuery->update("plg_help_dtb_help", $sqlval, $where, array($_POST['help_id']));
        return $ret;
    }

    /* 取得文字列の変換 */
    function lfConvertParam($array) {
        /*
         *  文字列の変換
         *  r :  「全角」英字を「半角(ﾊﾝｶｸ)」に変換
         *  R :  「半角(ﾊﾝｶｸ)」英字を「全角」に変換
         *  n :  「全角」数字を「半角(ﾊﾝｶｸ)」に変換
         *  N :  「半角(ﾊﾝｶｸ)」数字を「全角」に変換
         *  a :  「全角」英数字を「半角(ﾊﾝｶｸ)」に変換
         *  A :  「半角(ﾊﾝｶｸ)」英数字を「全角」に変換
         *  s :  「全角」スペースを「半角(ﾊﾝｶｸ)」に変換
         *  S :  「半角(ﾊﾝｶｸ)」スペースを「全角」に変換
         *  k :  「全角片仮名」を「半角(ﾊﾝｶｸ)片仮名」に変換
         *  K :  「半角(ﾊﾝｶｸ)片仮名」を「全角片仮名」に変換
         *  h :  「全角ひら仮名」を「半角(ﾊﾝｶｸ)片仮名」に変換
         *  H :  「半角(ﾊﾝｶｸ)片仮名」を「全角ひら仮名」に変換
         *  c :  「全角かた仮名」を「全角ひら仮名」に変換
         *  C :  「全角ひら仮名」を「全角かた仮名」に変換
         *  V :  濁点付きの文字を一文字に変換。"K","H"と共に使用します。
         */
        // 文字変換
        $arrConvList['help_question'] = "KVa";
        $arrConvList['help_answer'] = "KVa";

        foreach($arrConvList as $key => $val) {
            // POSTされてきた値のみ変換する。
            if(isset($array[$key])) {
                $array[$key] = mb_convert_kana($array[$key] ,$val);
            }
        }
        return $array;
    }

    /* 入力エラーチェック */
    function lfErrorCheck($array) {
        $objErr = new SC_CheckError_Ex($array);
        $objErr->doFunc(array("ヘルプカテゴリ", "help_category"), array("EXIST_CHECK"));
        $objErr->doFunc(array("ヘルプ内容", "help_question", MLTEXT_LEN), array("EXIST_CHECK", "SPTAB_CHECK", "MAX_LENGTH_CHECK", 'HTML_TAG_CHECK'));
        $objErr->doFunc(array("ヘルプ回答", "help_answer", MLTEXT_LEN), array("EXIST_CHECK", "SPTAB_CHECK", "MAX_LENGTH_CHECK", 'HTML_TAG_CHECK'));

        // 全入力項目に問題がない場合のみ、内容の重複チェック
        if(!isset($objErr->arrErr['help_category']) && !isset($objErr->arrErr['help_question']) && !isset($objErr->arrErr['help_answer'])) {
            $objQuery =& SC_Query_Ex::getSingletonInstance();
            // カテゴリと内容が同じレコードを検索
            $arrRet = $objQuery->select("help_id", "plg_help_dtb_help", "del_flg = 0 AND help_category = ? AND help_question = ?", array($array['help_category'], $array['help_question']));
            // 取得レコードがあった場合、IDを比較して編集中のレコードかチェック
            if(count($arrRet) > 0 && $arrRet[0]['help_id'] != $array['help_id']) {
                // 同じ内容が存在する場合
                $objErr->arrErr['help_question'] = "※ 既に同じ内容の登録が存在します。<br>";
            }
        }
        return $objErr->arrErr;
    }
}
?>
