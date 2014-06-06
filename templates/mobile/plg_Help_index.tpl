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
<!-- ▼メニュー ここから -->
<!--{section name=cnt loop=$arrHelp}-->
  <!--{if $arrHelp[cnt].help_category != $bef_category}-->
    <!--{assign var=question_cnt value=1}-->
    <!--{if $bef_category != ''}-->
      </ul>
    <!--{/if}-->
    <!--{$arrHelp[cnt].name|escape}-->
    <ul>
  <!--{/if}-->
  <a href="plg_Help_index.php?page=<!--{$arrHelp[cnt].help_id}-->"><!--{$arrHelp[cnt].help_question|nl2br_html}--></a><br>
  <!--{assign var=bef_category value=$arrHelp[cnt].help_category}-->
  <!--{assign var=question_cnt value=`$question_cnt+1`}-->
<!--{/section}-->
</ul>
<!-- ▲メニュー ここまで -->
