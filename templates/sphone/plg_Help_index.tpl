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
<section id="undercolumn">
    <!--☆ヘルプ -->
    <h2 class="title"><!--{$tpl_title|h}--></h2>

    <dl class="form_help">
    <!--{section name=cnt loop=$arrHelp}-->
      <!--{if $arrHelp[cnt].help_category != $bef_category}-->
        <!--{if $bef_category != ''}-->
      </dd>
        <!--{/if}-->
      <dt>■<!--{$arrHelp[cnt].name|escape}--></dt>
      <dd>
        <!--{/if}-->
        <table>
          <tr>
            <th width="50" align="center">Ｑ</th>
            <td><div class="help_question"><!--{$arrHelp[cnt].help_question|nl2br_html}--></div></td>
          </tr>
          <tr>
            <th width="50" align="center" class="answer">Ａ</th>
            <td><div class="help_answer"><!--{$arrHelp[cnt].help_answer|nl2br_html}--></div></td>
          </tr>
        </table>
        <!--{assign var=bef_category value=$arrHelp[cnt].help_category}-->
      <!--{/section}-->
      </dd>
    </dl>
</section>

<section id="search_area">
<form method="get" action="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="search" name="name" id="search" value="" placeholder="キーワードを入力" class="searchbox" >
</form>
</section>
<!--▲CONTENTS-->

<script type="application/javascript">
<!--//
$(function(){
  $("dd").hide();
  $("dt").click(function(){
    $(this).next().slideToggle("normal");
  });
});
//-->
</script>
