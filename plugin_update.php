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
class plugin_update {

    /**
    * アップデート
    * updateはアップデート時に実行されます.
    * 引数にはdtb_pluginのプラグイン情報が渡されます.
    *
    * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
    * @return void
    */
    function update($arrPlugin) {

        if($arrPlugin['plugin_version'] <= 0.8){
            //インストール済みバージョンが0.8以下の場合
            // ファイル更新
            if(copy(DOWNLOADS_TEMP_PLUGIN_UPDATE_DIR . "plugin_update.php", PLUGIN_UPLOAD_REALDIR . "Help/plugin_update.php") === false) print_r("失敗");
            if(copy(DOWNLOADS_TEMP_PLUGIN_UPDATE_DIR . "Help.php", PLUGIN_UPLOAD_REALDIR . "Help/Help.php") === false) print_r("失敗");
            if(copy(PLUGIN_UPLOAD_REALDIR . "Help/admin/basis/plg_Help_help.php", HTML_REALDIR . ADMIN_DIR . "basis/plg_Help_help.php") === false) print_r("失敗");
        }

        // ファイル更新
        if(copy(DOWNLOADS_TEMP_PLUGIN_UPDATE_DIR . "plugin_info.php", PLUGIN_UPLOAD_REALDIR . "Help/plugin_info.php") === false) print_r("失敗");
    }
}
?>
