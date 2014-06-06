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
<!--▼CONTENTS-->
<div id="undercolumn">

  <div id="undercolumn_help">
    <h2 class="title"><!--{$tpl_title|h}--></h2>

    <div id="category" class="category_title">カテゴリ一覧</div>
    <ul>
    <!--{section name=cnt loop=$arrHelp}-->
      <!--{if $arrHelp[cnt].help_category != $bef_category}-->
      <li><a href="#<!--{$arrHelp[cnt].help_category|escape}-->"><!--{$arrHelp[cnt].name|escape}--></a></li>
      <!--{/if}-->
      <!--{assign var=bef_category value=$arrHelp[cnt].help_category}-->
    <!--{/section}-->
    <!--{assign var=bef_category value=''}-->
    </ul>

    <div class="category_margin"></div>

    <!--{section name=cnt loop=$arrHelp}-->
      <!--{if $arrHelp[cnt].help_category != $bef_category}-->
        <!--{if $bef_category != ''}-->
          <div class="category_back"><a href="#category">カテゴリ一覧へ</a></div>
          </td>
        </tr>
      </table>
    </div>

    <div class="category_margin"></div>

        <!--{/if}-->
    <div id="<!--{$arrHelp[cnt].help_category|escape}-->">
      <div class="category_title"><!--{$arrHelp[cnt].name|escape}--></div>
      <table style="margin: 0px; padding: 0px;">
        <tr>
          <td>
      <!--{/if}-->
            <table>
              <tr>
                <th width="50" align="center">Ｑ</th>
                <td><div class="help_question"><!--{$arrHelp[cnt].help_question|nl2br_html}--></div></td>
              </tr>
              <tr>
                <th width="50" align="center">Ａ</th>
                <td><div class="help_answer"><!--{$arrHelp[cnt].help_answer|nl2br_html}--></div></td>
              </tr>
            </table>
      <!--{assign var=bef_category value=$arrHelp[cnt].help_category}-->
    <!--{/section}-->
          <div class="category_back"><a href="#category">カテゴリ一覧へ</a></div>
          </td>
        </tr>
      </table>
    </div>

  </div>
</div>
<!--▲CONTENTS-->
