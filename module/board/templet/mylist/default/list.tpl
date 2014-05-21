<div class="ModuleBoardMyList">
	<table cellpadding="0" cellspacing="0" class="mylistTable">
	<col width="110" /><col width="1" /><col width="100%" /><col width="1" /><col width="100" /><col width="1" /><col width="70" /><col width="1" /><col width="70" />
	<tr class="sectionBar">
		<td colspan="9"></td>
	</tr>
	<tr>
		<td class="headerCell">게시판</td>
		<td class="splitBar"></td>
		<td class="headerCell">제목</td>
		<td class="splitBar"></td>
		<td class="headerCell">작성일</td>
		<td class="splitBar"></td>
		<td class="headerCell">조회</td>
		<td class="splitBar"></td>
		<td class="headerCell">추천</td>
	</tr>
	<tr class="splitBar">
		<td colspan="9"></td>
	</tr>
	{foreach name=list from=$data item=data}
	<tr>
		<td class="bodyCell center f11"><div>{$data.board}</div></td>
		<td class="splitBar"></td>
		<td class="bodyCell">
			<div>
				{if $data.is_secret}<img src="{$skinDir}/images/icon_locked.gif" />{/if}
				{if $data.category}<span class="gray">[{$data.category}]</span> {/if}<a href="{$data.postlink}" width="800" height="500" onclick="return OpenLinkToPopup(this);">{$data.title|GetCutString:25:true}</a> {if $data.ment > 0} <span class="orange tahoma f10">[{$data.ment}{if $is_newment}+{/if}]</span>{/if}
				{if $data.is_image}<img src="{$skinDir}/images/icon_image.gif" />{/if}
				{if $data.is_file}<img src="{$skinDir}/images/icon_file.gif" />{/if}
			</div>
		</td>
		<td class="splitBar"></td>
		<td class="bodyCell tahoma f11 center">{$data.reg_date|date_format:"%Y.%m.%d"}</td>
		<td class="splitBar"></td>
		<td class="bodyCell tahoma f11 right">{$data.hit|number_format}</td>
		<td class="splitBar"></td>
		<td class="bodyCell tahoma f11 right">{$data.vote|number_format}</td>
	</tr>
	<tr class="splitBar">
		<td colspan="9"></td>
	</tr>
	{/foreach}
	<tr class="sectionEnd">
		<td colspan="9"><div></div></td>
	</tr>
	</table>
	
	<div class="height10"></div>
	
	<table cellpadding="0" cellspacing="0" class="layoutfixed">
	<col width="150" /><col width="100%" /><col width="150" />
	<tr>
		<td class="innerimg">
			<a href="{$link.page}{$prevlist}" class="btn btn-sm btn-primary"{if $prevlist == false} disabled="disabled"{/if}>이전페이지</a>
		</td>
		<td class="pageinfo"><span class="bold">{$totalpost}</span> posts / <span style="color:#EF5900;">{$p}</span> of {$totalpage} page{if $totalpage > 1}s{/if}</td>
		<td class="innerimg right">
			<a href="{$link.page}{$nextlist}" class="btn btn-sm btn-primary"{if $nextlist == false} disabled="disabled"{/if}>다음페이지</a>
		</td>
	</tr>
	</table>
	
	<div class="height10"></div>
	
	<div class="center">
		<ul class="pagination pagination-sm">
			<li{if $prevpage == false} class="disabled"{/if}><a href="{if $prevpage != false}{$link.page}{$prevpage}{else}javascript:void(0);{/if}">이전{$pagenum}페이지</a></li>
			{foreach name=page from=$page item=page}
			<li{if $page == $p} class="active"{/if}><a href="{$link.page}{$page}">{$page}</a></li>
			{/foreach}
			<li{if $nextpage == false} class="disabled"{/if}><a href="{if $nextpage != false}{$link.page}{$nextpage}{else}javascript:void(0);{/if}">다음{$pagenum}페이지</a></li>
		</ul>
	</div>
</div>