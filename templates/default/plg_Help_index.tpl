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
    <div class="row">
      <div class="col-xs-12 col-md-4">
        <h3 id="category" class="category_title">カテゴリ一覧</h3>
        <ul>
        <!--{section name=cnt loop=$arrHelp}-->
          <!--{if $arrHelp[cnt].help_category != $bef_category}-->
          <li><a href="#<!--{$arrHelp[cnt].help_category|escape}-->"><!--{$arrHelp[cnt].name|escape}--></a></li>
          <!--{/if}-->
          <!--{assign var=bef_category value=$arrHelp[cnt].help_category}-->
        <!--{/section}-->
        <!--{assign var=bef_category value=''}-->
        </ul>
      </div>
      <div class="col-xs-12 col-md-8">

        <!--{section name=cnt loop=$arrHelp}-->
          <!--{if $arrHelp[cnt].help_category != $bef_category}-->
            <!--{if $bef_category != ''}-->
        </div>

            <!--{/if}-->
        <div id="<!--{$arrHelp[cnt].help_category|escape}-->" class="margin-bottom-xl">
          <h3 class="category_title">
            <!--{$arrHelp[cnt].name|escape}-->
            <small><a href="#category">カテゴリ一覧へ</a></small>
          </h3>
          <!--{/if}-->
              <div class="panel panel-default">
                <table class="table table-bordered">
                  <tr>
                    <th width="50" align="center">Ｑ</th>
                    <td><div class="help_question"><!--{$arrHelp[cnt].help_question|nl2br_html}--></div></td>
                  </tr>
                  <tr>
                    <th width="50" align="center">Ａ</th>
                    <td><div class="help_answer"><!--{$arrHelp[cnt].help_answer|nl2br_html}--></div></td>
                  </tr>
                </table>
              </div>
          <!--{assign var=bef_category value=$arrHelp[cnt].help_category}-->
        <!--{/section}-->
        </div>

      </div>
    </div>
  </div>
</div>
<!--▲CONTENTS-->
