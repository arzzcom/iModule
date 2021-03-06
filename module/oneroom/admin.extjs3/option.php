<script type="text/javascript">
ContentArea = function(viewport) {
	this.viewport = viewport;

	ContentArea.superclass.constructor.call(this,{
		id:"content",
		region:"center",
		title:"매물옵션관리",
		layout:"fit",
		items:[
			new Ext.Panel({
				layout:"hbox",
				border:false,
				layoutConfig:{align:"stretch"},
				items:[
					new Ext.grid.EditorGridPanel({
						id:"Option1",
						title:"옵션구분",
						margins:"5 5 5 5",
						tbar:[
							new Ext.Button({
								text:"옵션구분추가",
								icon:"<?php echo $_ENV['dir']; ?>/module/oneroom/images/admin/icon_plugin_add.png",
								handler:function() {
									new Ext.Window({
										id:"OptionAddWindow",
										title:"옵션구분추가",
										width:350,
										height:110,
										modal:true,
										resizable:false,
										layout:"fit",
										items:[
											new Ext.form.FormPanel({
												id:"OptionAddForm",
												labelAlign:"right",
												labelWidth:85,
												border:false,
												errorReader:new Ext.form.XmlErrorReader(),
												style:"background:#FFFFFF; padding:10px;",
												items:[
													new Ext.form.TextField({
														fieldLabel:"옵션구분",
														name:"title",
														width:200,
														allowBlank:false
													})
												],
												listeners:{actioncomplete:{fn:function(form,action) {
													if (action.type == "submit") {
														Ext.Msg.show({title:"안내",msg:"성공적으로 추가하였습니다.<br />계속해서 옵션구분을 추가하시겠습니까?",buttons:Ext.Msg.OKCANCEL,icon:Ext.MessageBox.QUESTION,fn:function(button){
															Ext.getCmp("Option1").getStore().reload();
															if (button == "ok") {
																Ext.getCmp("OptionAddForm").getForm().findField("title").setValue();
																Ext.getCmp("OptionAddForm").getForm().findField("title").clearInvalid();
																Ext.getCmp("OptionAddForm").getForm().findField("title").focus();
															} else {
																Ext.getCmp("OptionAddWindow").close();
															}
														}});
	
													}
												}}}
											})
										],
										buttons:[
											new Ext.Button({
												text:"확인",
												icon:"<?php echo $_ENV['dir']; ?>/module/oneroom/images/admin/icon_tick.png",
												handler:function() {
													Ext.getCmp("OptionAddForm").getForm().submit({url:"<?php echo $_ENV['dir']; ?>/module/oneroom/exec/Admin.do.php?action=option&do=add&parent=0",waitMsg:"데이터를 전송중입니다."});
												}
											}),
											new Ext.Button({
												text:"취소",
												icon:"<?php echo $_ENV['dir']; ?>/module/oneroom/images/admin/icon_cross.png",
												handler:function() {
													Ext.getCmp("OptionAddWindow").close();
												}
											})
										]
									}).show();
								}
							}),
							new Ext.Button({
								text:"옵션구분삭제",
								icon:"<?php echo $_ENV['dir']; ?>/module/oneroom/images/admin/icon_plugin_delete.png",
								handler:function() {
									var checked = Ext.getCmp("Option1").selModel.getSelections();
									if (checked.length == 0) {
										Ext.Msg.show({title:"에러",msg:"삭제할 옵션구분을 선택하여 주십시오.",buttons:Ext.Msg.OK,icon:Ext.Msg.WARNING});
										return false;
									}
	
									var idxs = new Array();
									for (var i=0, loop=checked.length;i<loop;i++) {
										idxs.push(checked[i].get("idx"));
									}
									var idx = idxs.join(",");
									
									Ext.Msg.show({title:"안내",msg:"선택옵션구분을 삭제하게 되면 해당 옵션구분의 세부옵션도 함께 삭제됩니다.<br />정말 삭제하시겠습니까?",buttons:Ext.Msg.OKCANCEL,icon:Ext.Msg.QUESTION,fn:function(button) {
										if (button == "ok") {
											Ext.Msg.wait("처리중입니다.","Please Wait...");
											Ext.Ajax.request({
												url:"<?php echo $_ENV['dir']; ?>/module/oneroom/exec/Admin.do.php",
												success:function() {
													Ext.Msg.show({title:"안내",msg:"성공적으로 삭제하였습니다.",buttons:Ext.Msg.OK,icon:Ext.Msg.INFO});
													Ext.getCmp("Option1").getStore().reload();
												},
												failure:function() {
													Ext.Msg.show({title:"안내",msg:"서버에 이상이 있어 처리하지 못하였습니다.<br />잠시후 다시 시도해보시기 바랍니다.",buttons:Ext.Msg.OK,icon:Ext.Msg.INFO});
												},
												headers:{},
												params:{"action":"option","do":"delete","idx":idx}
											});
										}
									}});
								}
							}),
							'->',
							new Ext.Button({
								text:"변경사항저장",
								icon:"<?php echo $_ENV['dir']; ?>/module/oneroom/images/admin/icon_disk.png",
								handler:function() {
									Ext.Msg.wait("처리중입니다.","Please Wait...");
									Ext.Ajax.request({
										url:"<?php echo $_ENV['dir']; ?>/module/oneroom/exec/Admin.do.php",
										success:function() {
											Ext.Msg.show({title:"안내",msg:"성공적으로 저장하였습니다.",buttons:Ext.Msg.OK,icon:Ext.Msg.INFO});
											Ext.getCmp("Option1").getStore().reload();
										},
										failure:function() {
											Ext.Msg.show({title:"안내",msg:"서버에 이상이 있어 처리하지 못하였습니다.<br />잠시후 다시 시도해보시기 바랍니다.",buttons:Ext.Msg.OK,icon:Ext.Msg.INFO});
										},
										headers:{},
										params:{"action":"option","do":"modify","data":GetGridData(Ext.getCmp("Option1"))}
									});
								}
							})
						],
						bbar:[
							new Ext.Button({
								text:"위로이동",
								icon:"<?php echo $_ENV['dir']; ?>/module/oneroom/images/admin/icon_arrow_up.png",
								handler:function() {
									var checked = Ext.getCmp("Option1").selModel.getSelections();

									if (checked.length == 0) {
										Ext.Msg.show({title:"에러",msg:"이동할 옵션을 선택하여 주십시오.",buttons:Ext.Msg.OK,icon:Ext.MessageBox.ERROR});
										return false;
									}
	
									var selecter = new Array();
									for (var i=0, loop=checked.length;i<loop;i++) {
										var sort = checked[i].get("sort");
										if (sort != 0) {
											Ext.getCmp("Option1").getStore().getAt(sort).set("sort",sort-1);
											Ext.getCmp("Option1").getStore().getAt(sort-1).set("sort",sort);
	
											selecter.push(sort-1);
											Ext.getCmp("Option1").getStore().sort("sort","ASC");
										} else {
											return false;
										}
									}
	
									for (var i=0, loop=selecter.length;i<loop;i++) {
										Ext.getCmp("Option1").selModel.selectRow(selecter[i]);
									}
								}
							}),
							new Ext.Button({
								text:"아래로이동",
								icon:"<?php echo $_ENV['dir']; ?>/module/oneroom/images/admin/icon_arrow_down.png",
								handler:function() {
									var checked = Ext.getCmp("Option1").selModel.getSelections();

									if (checked.length == 0) {
										Ext.Msg.show({title:"에러",msg:"이동할 옵션을 선택하여 주십시오.",buttons:Ext.Msg.OK,icon:Ext.MessageBox.ERROR});
										return false;
									}
	
									var selecter = new Array();
									for (var i=checked.length-1;i>=0;i--) {
										var sort = checked[i].get("sort");
										if (sort != Ext.getCmp("Option1").getStore().getCount()-1) {
											Ext.getCmp("Option1").getStore().getAt(sort).set("sort",sort+1);
											Ext.getCmp("Option1").getStore().getAt(sort+1).set("sort",sort);
	
											selecter.push(sort+1);
											Ext.getCmp("Option1").getStore().sort("sort","ASC");
										} else {
											return false;
										}
									}
	
									for (var i=0, loop=selecter.length;i<loop;i++) {
										Ext.getCmp("Option1").selModel.selectRow(selecter[i]);
									}
								}
							})
						],
						cm:new Ext.grid.ColumnModel([
							new Ext.ux.grid.CheckboxSelectionModel(),
							{
								dataIndex:"idx",
								hidden:true,
								hideable:false
							},{
								id:"title1",
								header:"옵션구분명",
								dataIndex:"title",
								sortable:false,
								menuDisabled:true,
								resizable:false,
								editor:new Ext.form.TextField({selectOnFocus:true})
							},{
								dataIndex:"sort",
								hidden:true,
								hideable:false
							}
						]),
						sm:new Ext.ux.grid.CheckboxSelectionModel(),
						store:new Ext.data.Store({
							proxy:new Ext.data.ScriptTagProxy({url:"<?php echo $_ENV['dir']; ?>/module/oneroom/exec/Admin.get.php"}),
							reader:new Ext.data.JsonReader({
								root:"lists",
								totalProperty:"totalCount",
								fields:["idx","title",{name:"sort",type:"int"}]
							}),
							remoteSort:false,
							sortInfo:{field:"sort",direction:"ASC"},
							baseParams:{action:"option",parent:"0"},
							listeners:{load:{fn:function() {
								Ext.getCmp("Option2").getStore().baseParams.parent = "-1";
								Ext.getCmp("Option2").getStore().load();
							}}}
						}),
						autoExpandColumn:"title1",
						flex:1,
						listeners:{rowclick:{fn:function(grid,idx,e) {
							Ext.getCmp("Option2").getStore().baseParams.parent = grid.getStore().getAt(idx).get("idx");
							Ext.getCmp("Option2").getStore().load();
						}}}
					}),
					new Ext.grid.EditorGridPanel({
						id:"Option2",
						title:"세부옵션",
						margins:"5 5 5 0",
						tbar:[
							new Ext.Button({
								text:"세부옵션추가",
								icon:"<?php echo $_ENV['dir']; ?>/module/oneroom/images/admin/icon_plugin_add.png",
								handler:function() {
									if (Ext.getCmp("Option2").getStore().baseParams.parent == "-1") {
										Ext.Msg.show({title:"에러",msg:"상위 옵션구분을 선택하여 주십시오.",buttons:Ext.Msg.OK,icon:Ext.MessageBox.ERROR});
										return false;
									}
									
									var parent = Ext.getCmp("Option1").getStore().find("idx",Ext.getCmp("Option2").getStore().baseParams.parent,false,false);
									
									new Ext.Window({
										id:"OptionAddWindow",
										title:"세부옵션추가 ("+Ext.getCmp("Option1").getStore().getAt(parent).get("title")+")",
										width:350,
										height:110,
										modal:true,
										resizable:false,
										layout:"fit",
										items:[
											new Ext.form.FormPanel({
												id:"OptionAddForm",
												labelAlign:"right",
												labelWidth:85,
												border:false,
												errorReader:new Ext.form.XmlErrorReader(),
												style:"background:#FFFFFF; padding:10px;",
												items:[
													new Ext.form.TextField({
														fieldLabel:"세부옵션명",
														name:"title",
														width:200,
														allowBlank:false
													})
												],
												listeners:{actioncomplete:{fn:function(form,action) {
													if (action.type == "submit") {
														Ext.Msg.show({title:"안내",msg:"성공적으로 추가하였습니다.<br />계속해서 세부옵션을 추가하시겠습니까?",buttons:Ext.Msg.OKCANCEL,icon:Ext.MessageBox.QUESTION,fn:function(button){
															Ext.getCmp("Option2").getStore().reload();
															if (button == "ok") {
																Ext.getCmp("OptionAddForm").getForm().findField("title").setValue();
																Ext.getCmp("OptionAddForm").getForm().findField("title").clearInvalid();
																Ext.getCmp("OptionAddForm").getForm().findField("title").focus();
															} else {
																Ext.getCmp("OptionAddWindow").close();
															}
														}});
													}
												}}}
											})
										],
										buttons:[
											new Ext.Button({
												text:"확인",
												icon:"<?php echo $_ENV['dir']; ?>/module/oneroom/images/admin/icon_tick.png",
												handler:function() {
													Ext.getCmp("OptionAddForm").getForm().submit({url:"<?php echo $_ENV['dir']; ?>/module/oneroom/exec/Admin.do.php?action=option&do=add&parent="+Ext.getCmp("Option2").getStore().baseParams.parent,waitMsg:"데이터를 전송중입니다."});
												}
											}),
											new Ext.Button({
												text:"취소",
												icon:"<?php echo $_ENV['dir']; ?>/module/oneroom/images/admin/icon_cross.png",
												handler:function() {
													Ext.getCmp("OptionAddWindow").close();
												}
											})
										]
									}).show();
								}
							}),
							new Ext.Button({
								text:"세부옵션삭제",
								icon:"<?php echo $_ENV['dir']; ?>/module/oneroom/images/admin/icon_plugin_delete.png",
								handler:function() {
									var checked = Ext.getCmp("Option2").selModel.getSelections();
									if (checked.length == 0) {
										Ext.Msg.show({title:"에러",msg:"삭제할 세부옵션을 선택하여 주십시오.",buttons:Ext.Msg.OK,icon:Ext.Msg.WARNING});
										return false;
									}
	
									var idxs = new Array();
									for (var i=0, loop=checked.length;i<loop;i++) {
										idxs.push(checked[i].get("idx"));
									}
									var idx = idxs.join(",");
									
									Ext.Msg.show({title:"안내",msg:"정말 삭제하시겠습니까?",buttons:Ext.Msg.OKCANCEL,icon:Ext.Msg.QUESTION,fn:function(button) {
										if (button == "ok") {
											Ext.Msg.wait("처리중입니다.","Please Wait...");
											Ext.Ajax.request({
												url:"<?php echo $_ENV['dir']; ?>/module/oneroom/exec/Admin.do.php",
												success:function() {
													Ext.Msg.show({title:"안내",msg:"성공적으로 삭제하였습니다.",buttons:Ext.Msg.OK,icon:Ext.Msg.INFO});
													Ext.getCmp("Option1").getStore().reload();
												},
												failure:function() {
													Ext.Msg.show({title:"안내",msg:"서버에 이상이 있어 처리하지 못하였습니다.<br />잠시후 다시 시도해보시기 바랍니다.",buttons:Ext.Msg.OK,icon:Ext.Msg.INFO});
												},
												headers:{},
												params:{"action":"option","do":"delete","idx":idx}
											});
										}
									}});
								}
							}),
							'->',
							new Ext.Button({
								text:"변경사항저장",
								icon:"<?php echo $_ENV['dir']; ?>/module/oneroom/images/admin/icon_disk.png",
								handler:function() {
									Ext.Msg.wait("처리중입니다.","Please Wait...");
									Ext.Ajax.request({
										url:"<?php echo $_ENV['dir']; ?>/module/oneroom/exec/Admin.do.php",
										success:function() {
											Ext.Msg.show({title:"안내",msg:"성공적으로 저장하였습니다.",buttons:Ext.Msg.OK,icon:Ext.Msg.INFO});
											Ext.getCmp("Option2").getStore().reload();
										},
										failure:function() {
											Ext.Msg.show({title:"안내",msg:"서버에 이상이 있어 처리하지 못하였습니다.<br />잠시후 다시 시도해보시기 바랍니다.",buttons:Ext.Msg.OK,icon:Ext.Msg.INFO});
										},
										headers:{},
										params:{"action":"option","do":"modify","data":GetGridData(Ext.getCmp("Option2"))}
									});
								}
							})
						],
						bbar:[
							new Ext.Button({
								text:"위로이동",
								icon:"<?php echo $_ENV['dir']; ?>/module/oneroom/images/admin/icon_arrow_up.png",
								handler:function() {
									var checked = Ext.getCmp("Option2").selModel.getSelections();

									if (checked.length == 0) {
										Ext.Msg.show({title:"에러",msg:"이동할 옵션을 선택하여 주십시오.",buttons:Ext.Msg.OK,icon:Ext.MessageBox.ERROR});
										return false;
									}
	
									var selecter = new Array();
									for (var i=0, loop=checked.length;i<loop;i++) {
										var sort = checked[i].get("sort");
										if (sort != 0) {
											Ext.getCmp("Option2").getStore().getAt(sort).set("sort",sort-1);
											Ext.getCmp("Option2").getStore().getAt(sort-1).set("sort",sort);
	
											selecter.push(sort-1);
											Ext.getCmp("Option2").getStore().sort("sort","ASC");
										} else {
											return false;
										}
									}
	
									for (var i=0, loop=selecter.length;i<loop;i++) {
										Ext.getCmp("Option2").selModel.selectRow(selecter[i]);
									}
								}
							}),
							new Ext.Button({
								text:"아래로이동",
								icon:"<?php echo $_ENV['dir']; ?>/module/oneroom/images/admin/icon_arrow_down.png",
								handler:function() {
									var checked = Ext.getCmp("Option2").selModel.getSelections();

									if (checked.length == 0) {
										Ext.Msg.show({title:"에러",msg:"이동할 옵션을 선택하여 주십시오.",buttons:Ext.Msg.OK,icon:Ext.MessageBox.ERROR});
										return false;
									}
	
									var selecter = new Array();
									for (var i=checked.length-1;i>=0;i--) {
										var sort = checked[i].get("sort");
										if (sort != Ext.getCmp("Option2").getStore().getCount()-1) {
											Ext.getCmp("Option2").getStore().getAt(sort).set("sort",sort+1);
											Ext.getCmp("Option2").getStore().getAt(sort+1).set("sort",sort);
	
											selecter.push(sort+1);
											Ext.getCmp("Option2").getStore().sort("sort","ASC");
										} else {
											return false;
										}
									}
	
									for (var i=0, loop=selecter.length;i<loop;i++) {
										Ext.getCmp("Option2").selModel.selectRow(selecter[i]);
									}
								}
							})
						],
						cm:new Ext.grid.ColumnModel([
							new Ext.ux.grid.CheckboxSelectionModel(),
							{
								dataIndex:"idx",
								hidden:true,
								hideable:false
							},{
								id:"title2",
								header:"세부옵션명",
								dataIndex:"title",
								sortable:false,
								menuDisabled:true,
								resizable:false,
								editor:new Ext.form.TextField({selectOnFocus:true})
							},{
								dataIndex:"sort",
								hidden:true,
								hideable:false
							}
						]),
						sm:new Ext.ux.grid.CheckboxSelectionModel(),
						store:new Ext.data.Store({
							proxy:new Ext.data.ScriptTagProxy({url:"<?php echo $_ENV['dir']; ?>/module/oneroom/exec/Admin.get.php"}),
							reader:new Ext.data.JsonReader({
								root:"lists",
								totalProperty:"totalCount",
								fields:["idx","title",{name:"sort",type:"int"}]
							}),
							remoteSort:false,
							sortInfo:{field:"sort",direction:"ASC"},
							baseParams:{action:"option",parent:"-1"},
							listeners:{load:{fn:function(store) {
								var parent = Ext.getCmp("Option1").getStore().find("idx",store.baseParams.parent,false,false);
								if (parent != -1) {
									Ext.getCmp("Option2").setTitle("세부옵션 ("+Ext.getCmp("Option1").getStore().getAt(parent).get("title")+")");
								}
							}}}
						}),
						autoExpandColumn:"title2",
						flex:1
					})
				]
			})
		]
	});
};
Ext.extend(ContentArea, Ext.Panel,{});
</script>