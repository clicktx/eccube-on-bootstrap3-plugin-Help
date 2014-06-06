<!--{*
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
 *}-->
<form name="form1" id="form1" method="post" action="?">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="edit">
<input type="hidden" name="help_id" value="<!--{$tpl_help_id}-->">
<div id="basis" class="contents-main">
    <table class="form">
        <tr>
            <th>ヘルプカテゴリ<span class="attention"> *</span></th>
            <td>
                <span class="attention"><!--{$arrErr.help_category}--></span>
                <!--{if $tpl_help_id == ""}-->
                <select name="help_category" style="<!--{if $arrErr.help_category != ""}-->background-color: <!--{$smarty.const.ERR_COLOR}-->;<!--{/if}-->" onChange="fnModeSubmit('change', '', ''); return false;">
                    <!--{html_options options=$arrCategory selected=$help_category}-->
                </select>
                <!--{else}-->
                <!--{$arrCategory[$help_category]|escape}-->
                <input type="hidden" name="help_category" value="<!--{$help_category}-->" />
                <!--{/if}-->
            </td>
        </tr>
        <tr>
            <th>ヘルプ内容<span class="attention"> (タグ許可)*</span></th>
            <td>
                <span class="attention"><!--{$arrErr.help_question}--></span>
                <textarea name="help_question" maxlength="<!--{$smarty.const.MLTEXT_LEN}-->" cols="60" rows="8" class="area60" style="<!--{if $arrErr.help_question != ""}-->background-color: <!--{$smarty.const.ERR_COLOR}-->;<!--{/if}-->" ><!--{$arrForm.help_question|h}--></textarea>
                <span class="attention"> （上限<!--{$smarty.const.MLTEXT_LEN}-->文字）</span>
            </td>
        </tr>
        <tr>
            <th>ヘルプ回答<span class="attention"> (タグ許可)*</span></th>
            <td>
                <span class="attention"><!--{$arrErr.help_answer}--></span>
                <textarea name="help_answer" maxlength="<!--{$smarty.const.MLTEXT_LEN}-->" cols="60" rows="8" class="area60" style="<!--{if $arrErr.help_answer != ""}-->background-color: <!--{$smarty.const.ERR_COLOR}-->;<!--{/if}-->" ><!--{$arrForm.help_answer|escape}--></textarea>
                <span class="attention"> （上限<!--{$smarty.const.MLTEXT_LEN}-->文字）</span>
            </td>
        </tr>
    </table>
    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', 'edit', '', ''); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>

    <div>ヘルプカテゴリ：<!--{$arrCategory[$help_category]|escape}--></div>
    <table class="list">
        <colgroup width="65%">
        <colgroup width="10%">
        <colgroup width="10%">
        <colgroup width="15%">
        <tr>
            <th>ヘルプ内容</th>
            <th>編集</th>
            <th>削除</th>
            <th>移動</th>
        </tr>
        <!--{section name=cnt loop=$arrHelp}-->
            <tr style="background:<!--{if $tpl_class_id != $arrHelp[cnt].help_id}-->#ffffff<!--{else}--><!--{$smarty.const.SELECT_RGB}--><!--{/if}-->;">
            <!--{assign var=help_id value=$arrHelp[cnt].help_id}-->
                <td><!--{* ヘルプ内容 *}--><!--{$arrHelp[cnt].help_question|mb_strimwidth:0:65:"..."|nl2br_html}--></td>
                <td align="center">
                    <!--{if $tpl_help_id != $arrHelp[cnt].help_id}-->
                    <a href="?" onclick="fnModeSubmit('pre_edit', 'help_id', <!--{$arrHelp[cnt].help_id}-->); return false;">編集</a>
                    <!--{else}-->
                    編集中
                    <!--{/if}-->
                </td>
                <td align="center">
                    <!--{if $arrClassCatCount[$class_id] > 0}-->
                    -
                    <!--{else}-->
                    <a href="?" onclick="fnModeSubmit('delete', 'help_id', <!--{$arrHelp[cnt].help_id}-->); return false;">削除</a>
                    <!--{/if}-->
                </td>
                <td align="center">
                    <!--{if $smarty.section.cnt.iteration != 1}-->
                    <a href="?" onclick="fnModeSubmit('up', 'help_id', <!--{$arrHelp[cnt].help_id}-->); return false;">上へ</a>
                    <!--{/if}-->
                    <!--{if $smarty.section.cnt.iteration != $smarty.section.cnt.last}-->
                    <a href="?" onclick="fnModeSubmit('down', 'help_id', <!--{$arrHelp[cnt].help_id}-->); return false;">下へ</a>
                    <!--{/if}-->
                </td>
            </tr>
        <!--{/section}-->
    </table>

</div>
</form>
