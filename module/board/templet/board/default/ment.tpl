{if $select}
<table cellpadding="0" cellspacing="0" class="boardTable">
<col width="43" /><col width="1" /><col width="100%" />
<tr>
	<td colspan="3" class="sectionTitle">작성자에 의해 채택된 답변</td>
</tr>
<tr class="sectionBar">
	<td colspan="3"></td>
</tr>
<tr>
	<td class="sPhoto"><img src="{$select.photo}" /></td>
	<td class="splitBar"></td>
	<td class="mentCell">
		<div>
			<table cellpadding="0" cellspacing="0" class="layoutfixed">
			<col width="100%" /><col width="30" /><col width="60" /><col width="150" /><col width="150" />
			<tr class="mentCell">
				<td>{$select.nickname}</td>
				<td class="tahoma f10 bold">LV.<span class="orange">{if $select.member.level.lv < 10}0{/if}{$select.member.level.lv}</span></td>
				<td>
					<table cellpadding="0" cellspacing="0" class="exp">
					<col width="1" /><col width="{$select.member.level.exp/$select.member.level.next*50|string_format:"%d"}" /><col width="100%" /><col width="2" />
					<tr>
						<td class="start"></td>
						<td class="on"></td>
						<td class="off"></td>
						<td class="end"></td>
					</tr>
					</table>
				</td>
				<td>
					<div class="email">{if $select.email}<a href="mailto:{$select.email}">{$select.email}</a>{else}<span class="disabled">NONE</span>{/if}</div>
				</td>
				<td>
					<div class="homepage">{if $select.homepage}<a href="{$select.homepage}" target="_blank">{$select.homepage}</a>{else}<span class="disabled">NONE</span>{/if}</div>
				</td>
			</tr>
			</table>
		</div>
		<div style="margin-top:3px;">
			<table cellpadding="0" cellspacing="0" class="layoutfixed">
			<col width="200" /><col width="100%" />
			<tr>
				<td class="tahoma f10 gray">{$select.reg_date|date_format:"%Y-%m-%d, %I:%M %p"}</td>
				<td class="right">
					
				</td>
			</tr>
			</table>
		</div>
	</td>
</tr>
<tr class="splitBar">
	<td colspan="3"></td>
</tr>
<tr>
	<td colspan="3" class="mentContentCell selectMent">
		<div class="mentContent">
			{$select.content}
		
			{if $select.last_modify.hit > 0}<div class="tahoma f10 gray right">Last Edited by <span class="bold">{$select.last_modify.editor}</span> At {$select.last_modify.date|date_format:"%Y/%m/%d %H:%M:%S"} <span class="bold">({$select.last_modify.hit|number_format})</span></div>{/if}
			
			{if $select.file}
			<div class="height5"></div>
			<ul class="filelist">
				{foreach name=file from=$select.file item=file}
					<li><a href="{$file.link}" target="downloadFrame">{$file.filename}</a> ({$file.filesize}, {$file.hit|number_format} Hit{if $file.hit > 1}s{/if})</li>
				{/foreach}
			</ul>
			{/if}
		</div>
	</td>
</tr>
</table>

<div class="height10"></div>
{/if}

<table cellpadding="0" cellspacing="0" class="boardTable">
<col width="100%" /><col width="200" />
<tr>
	<td class="sectionTitle">댓글</td>
	<td class="right tahoma f10">
		<div class="height10"></div>
		TOTAL #<span class="orange bold">{$data|@sizeof}</span>
	</td>
</tr>
</table>

{$mentStart}
{foreach name=data from=$data item=data}
	{$data.replyStart}
	
	<div class="{if $data.parent == 0}mainMent{else}replyMent{/if}">
		<table cellpadding="0" cellspacing="0" class="boardTable">
		<col width="43" /><col width="1" /><col width="100%" />
		<tr class="sectionBar">
			<td colspan="3"></td>
		</tr>
		{if $data.is_delete == true}
		<tr>
			<td colspan="3">
				<div class="deleteMent">아래의 답변댓글에 대한 원래의 댓글이 작성자 또는 관리자에 의해 삭제되었습니다.</div>
			</td>
		</tr>
		{else}
		<tr>
			<td class="sPhoto"><img src="{$data.photo}" /></td>
			<td class="splitBar"></td>
			<td class="mentCell">
				<div>
					<table cellpadding="0" cellspacing="0" class="layoutfixed">
					<col width="100%" /><col width="30" /><col width="60" /><col width="150" /><col width="150" />
					<tr class="mentCell">
						<td>{$data.nickname}</td>
						<td class="tahoma f10 bold">LV.<span class="orange">{if $data.member.level.lv < 10}0{/if}{$data.member.level.lv}</span></td>
						<td>
							<table cellpadding="0" cellspacing="0" class="exp">
							<col width="1" /><col width="{$data.member.level.exp/$data.member.level.next*50|string_format:"%d"}" /><col width="100%" /><col width="2" />
							<tr>
								<td class="start"></td>
								<td class="on"></td>
								<td class="off"></td>
								<td class="end"></td>
							</tr>
							</table>
						</td>
						<td>
							<div class="email">{if $data.email}<a href="mailto:{$data.email}">{$data.email}</a>{else}<span class="disabled">NONE</span>{/if}</div>
						</td>
						<td>
							<div class="homepage">{if $data.homepage}<a href="{$data.homepage}" target="_blank">{$data.homepage}</a>{else}<span class="disabled">NONE</span>{/if}</div>
						</td>
					</tr>
					</table>
				</div>
				<div style="margin-top:3px;">
					<table cellpadding="0" cellspacing="0" class="layoutfixed">
					<col width="200" /><col width="100%" />
					<tr>
						<td class="tahoma f10 gray">{$data.reg_date|date_format:"%Y-%m-%d, %I:%M %p"}</td>
						<td class="right">
							<span class="label label-primary label-sm tahoma pointer" onclick="{$data.action.reply}">REPLY</span>
							<a href="{$data.link.modify}" style="text-decoration:none;"><span class="label label-primary label-sm tahoma pointer">MODIFY</span></a>
							<a href="{$data.link.delete}" style="text-decoration:none;"><span class="label label-danger label-sm tahoma pointer">DELETE</span></a>
						</td>
					</tr>
					</table>
				</div>
			</td>
		</tr>
		<tr class="splitBar">
			<td colspan="3"></td>
		</tr>
		<tr>
			<td colspan="3" class="mentContentCell">
				<div class="mentContent">
					{$data.content}
				
					{if $data.last_modify.hit > 0}<div class="tahoma f10 gray right">Last Edited by <span class="bold">{$data.last_modify.editor}</span> At {$data.last_modify.date|date_format:"%Y/%m/%d %H:%M:%S"} <span class="bold">({$data.last_modify.hit|number_format})</span></div>{/if}
					
					{if $data.file}
					<div class="height5"></div>
					<ul class="filelist">
						{foreach name=file from=$data.file item=file}
							<li><a href="{$file.link}" target="downloadFrame">{$file.filename}</a> ({$file.filesize}, {$file.hit|number_format} Hit{if $file.hit > 1}s{/if})</li>
						{/foreach}
					</ul>
					{/if}
			
					{if $data.select == true}
					<div class="right">
						<div class="height10"></div>
						<span class="btn btn-sm btn-warning" onclick="{$data.action.select}">답변이 도움되셨다면, 이곳을 눌러 답변채택을 하여주시기 바랍니다.</span>
					</div>
					{/if}
				</div>
			</td>
		</tr>
		{/if}
		</table>
		
		<div class="height10"></div>
		{$data.reply}
		{$data.replyEnd}
	</div>
{/foreach}

{if $permission.ment == true}
	{$ment_write}
{/if}

{$mentEnd}