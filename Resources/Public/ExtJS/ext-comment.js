/*!
 * Ext JS Library 3.4.0
 * Copyright(c) 2006-2011 Sencha Inc.
 * licensing@sencha.com
 * http://www.sencha.com/license
 */
Ext.ns('TYPO3.Comment');
TYPO3.Comment = {
	storeCreate : false,
	templatePanel : false,
	form : false,
	champs : {
		comment : false,
	}
}
TYPO3.Comment.store = Ext.extend(Ext.data.Store,{
	autoLoad: false,
	reader : new Ext.data.JsonReader({
		totalProperty : 'totalCount',
		root : 'rows',
		id : 'id'
	},[
	   {name: 'id', mapping: 'id'},
       {name: 'nom', mapping: 'nom'},
       {name: 'uri', mapping: 'uri'},
       {name: 'image', mapping: 'image'},
       {name: 'date', mapping: 'date', type: 'date', dateFormat: 'timestamp'},
       {name: 'comment', mapping: 'comment'}
	]),
	paramNames : {
		start : "tx_ioceancomment_pi1[start]",
		limit : "tx_ioceancomment_pi1[limit]"
	},
	listeners : {
		load : function(storeLoad,dataLoad,paramsLoad){
			
		}
	}
});
TYPO3.Comment.dataView =  Ext.extend(Ext.DataView,{
     itemSelector: 'div.commentSingle'
});
TYPO3.Comment.toolBar = Ext.extend(Ext.Toolbar,{
	autoWidth : true,
    height: 30,
});
TYPO3.Comment.pagingToolbar = Ext.extend(Ext.PagingToolbar,{
	pageSize: 20,
    displayInfo: true,
});
TYPO3.Comment.panel = Ext.extend(Ext.Panel,{
	autoHeight : true,
	autoScroll:true,
});
TYPO3.Comment.window = Ext.extend(Ext.Window ,{
	width : 700,
	autoHeight : true,
	closeAction : "hide",
});
TYPO3.Comment.form = Ext.extend(Ext.form.FormPanel ,{
	labelAlign: 'right',
	labelWidth: 150,
	buttonAlign: 'right'
});
TYPO3.Comment.champHtml = Ext.extend(Ext.form.HtmlEditor,{
	enableColors : false,
	enableFont : false,
	enableFontSize : false,
	defaultFont  : "arial"
});

function createCommentExtJs(id,url,conf){
	var result = false;
	//création de la datastore
	var store = new TYPO3.Comment.store({
		url : url
	});
	//création du formulaire avec la window si ajout est bon
	if(conf.ajout == 1) {
		var form = new TYPO3.Comment.form();
		var comment = new TYPO3.Comment.champHtml({
			fieldLabel: IO.translate.get("extjs_comment_labelFieldComment"),
			name: 'tx_ioceancomment_pi1[comment]',
			value : conf.descLong,
		});
		form.add(
				comment
		);
		var window = new TYPO3.Comment.window({
			title : IO.translate.get("extjs_comment_labelWindowTitle"),
			items : form
		});
		form.addButton(IO.translate.get("extjs_comment_labelSave"), function(){
			if(comment.isValid()){
				this.getForm().submit({
					url : "index.php?type=451",
					method : "post",
					params : {
						"tx_ioceancomment_pi1[action]" : "add",
						"tx_ioceancomment_pi1[format]" : "json",
						"tx_ioceancomment_pi1[table]" : conf.tableRef,
						"tx_ioceancomment_pi1[uid]" : conf.idContent,
						"tx_ioceancomment_pi1[confDefault]" : Ext.util.JSON.encode({
	     				   "id" : id,
	     				   "conf" : conf,
	     				   "url" : url
	     			   })
					},
					waitMsg : IO.translate.get("extjs_comment_labelPatientez"),
					success : function(form,action){
						
						//window.removeAll();
						window.hide();
						Ext.Msg.show({
							title:IO.translate.get("extjs_comment_labelOK"),
							msg:action.result.msg,
						});
						//createStoreComment(action.result.confDefault.id,action.result.confDefault.url,action.result.confDefault.conf);
						store.load({params:{start:0, limit:20}});
											
					},
					failure : function(form,action){
						
						//window.removeAll();
						window.hide();
						Ext.Msg.show({
							title:IO.translate.get("extjs_comment_labelERROR"),
							msg:action.result.msg,
						});
					}
				});
			} 
		}, form);
	}
	
	//création du panel et son template
	var template =  new Ext.XTemplate(
	   '<tpl for=".">',
	   '<div class="commentSingle">',
	   		'<div class="infoPersonne">',
	   			'<div class="name"><a href="{uri}">{nom}</a></div>',
	   			'<div class="image"><image src="{image}"/></div>',
	   			'<div class="date">'+IO.translate.get("extjs_comment_templateDateDeb")+'{date:date("d/m/Y")}'+IO.translate.get("extjs_comment_templateDateFin")+'{date:date("H:i")}</div>',
	   		'</div>',
	   		'<div class="commentText">{comment}</div>',
	   		'<div class="nettoyeur"></div>',
	   	'</div></tpl>'
	);
	
	var confPanel = {
			applyTo: id,
			title: IO.translate.get("extjs_comment_titlePanel"),
			items: new TYPO3.Comment.dataView({
				tpl: template,
				store: store
			}),
			bbar: new TYPO3.Comment.pagingToolbar({
		        store: store,
		        pageSize: conf.pageSize,
		        displayMsg: IO.translate.get("extjs_comment_pagingDisplayMsg"),
		        emptyMsg: IO.translate.get("extjs_comment_pagingEmptyMsg")
		    })	
	}
	if(conf.ajout == 1) {
		confPanel.tbar = new TYPO3.Comment.toolBar({
			items: [
		        {
		            text: IO.translate.get("extjs_comment_labelButtonAdd"),
		            handler:function(){
		            	window.show();
		            }
		        }
		    ]
		});
	}
	var panelComment = new TYPO3.Comment.panel(confPanel);
	
	store.load({params:{"tx_ioceancomment_pi1[start]":conf.start, "tx_ioceancomment_pi1[limit]":conf.limit}});
}