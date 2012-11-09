
jQuery(document).ready(function(){	
	var timeCalendar = ###TIMECALENDAR###;
	var dateInit = new Date();
	dateInit.setTime(timeCalendar*1000);
	var jfcalplugin = jQuery("#mycalendar").jFrontierCal({
		date: dateInit,
		dayClickCallback: myDayClickHandler,
		agendaClickCallback: myAgendaClickHandler,
		agendaDropCallback: myAgendaDropHandler,
		agendaMouseoverCallback: myAgendaMouseoverHandler,
		applyAgendaTooltipCallback: myApplyTooltip,
		agendaDragStartCallback : myAgendaDragStart,
		agendaDragStopCallback : myAgendaDragStop,
		dragAndDropEnabled: false //pour l'instant
	}).data("plugin");
	
	//fonction click sur le calendrier
	function myDayClickHandler(eventObj){
		//alert('myDayClickHandler');
	}
	//fonction click sur un evenement du calendrier
	function myAgendaClickHandler(eventObj){
		//alert('myAgendaClickHandler');
		var agendaId = eventObj.data.agendaId;
		var agendaItem = jfcalplugin.getAgendaItemById("#mycalendar",agendaId);
		jQuery('#read-event-form').dialog('option','agendaItem',agendaItem);
		
		jQuery('#read-event-form').dialog('open');
	}
		
	//fonction activer au drop d'un evenement
	function myAgendaDropHandler(eventObj){
		//alert('myAgendaDropHandler');
	}
	//fonction hover sur un evenement du calendrier
	function myAgendaMouseoverHandler(eventObj){
		//voir a quoi sa sert
		var agendaId = eventObj.data.agendaId;
		var agendaItem = jfcalplugin.getAgendaItemById("#mycalendar",agendaId);
	}
	
	//fonction activer a chaque affichage d'un evenement
	function myApplyTooltip(divElm,agendaItem){
		// Destroy currrent tooltip if present
		if(divElm.data("qtip")){
			divElm.qtip("destroy");
		}
		
		var displayData = "";
		var display = jQuery("#tooltip-event").clone();
		
		display.find("#title").html(agendaItem.title);
		if(!agendaItem.allDay){
			display.find("#dateDisplay").show();
			display.find("#dateDeb").html(agendaItem.data.dateDebDisplay);
			display.find("#dateFin").html(agendaItem.data.dateFinDisplay);
		} else {
			display.find("#dateDisplay").hide();
		}
		display.find("#description").html(agendaItem.data.description);
		
		var myStyle = {
			border: {
				width: 1,
				radius: 5,
				color:agendaItem.displayProp.backgroundColor,
			},
			backgroundColor : agendaItem.displayProp.backgroundColor,
			color : agendaItem.displayProp.foregroundColor,
			padding: 5, 
			textAlign: "left",
			tip: true,
			name: "dark",// other style properties are inherited from dark theme
		};
		
		// apply tooltip
		divElm.qtip({
			content: display,
			position: {
				corner: {
					tooltip: "bottomMiddle",
					target: "topMiddle"			
				},
				adjust: { 
					mouse: true,
					x: 0,
					y: -15
				},
				target: "mouse"
			},
			show: { 
				when: { 
					event: 'mouseover'
				}
			},
			style: myStyle
		});
		
	}
	//fonction activer au dragstart d'un evenement
	function myAgendaDragStart(eventObj,divElm,agendaItem){
		if(divElm.data("qtip")){
			divElm.qtip("destroy");
		}
	};
	
	//fonction activer au dragstop d'un evenement quand on le drop a un endroit non autoriser pour le supprimer par exemple
	function myAgendaDragStop(eventObj,divElm,agendaItem){
		//alert('myAgendaDragStop');	
	};


	jfcalplugin.setAspectRatio("#mycalendar",1);
	
	jQuery("#dateSelect").datepicker({
		showOtherMonths: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat: 'dd/mm/yy'
	});
	jQuery("#dateSelect").change(function(){
		var date = jQuery(this).datepicker("getDate");
		jQuery('#timeCalendar').val(date.getTime()/1000);
	});
	
	
	/**
	 * Initialize previous month button
	 */
	jQuery("#BtnPreviousMonth").button();
	jQuery("#BtnPreviousMonth").click(function() {
		jfcalplugin.showPreviousMonth("#mycalendar");
		var calDate = jfcalplugin.getCurrentDate("#mycalendar"); // returns Date object
		var cyear = calDate.getFullYear();
		var cmonth = calDate.getMonth();
		var cday = calDate.getDate();
		jQuery("#dateSelect").datepicker("setDate",cday+"/"+(cmonth+1)+"/"+cyear);
		getEvents(calDate);
		return false;
	});
	/**
	 * Initialize next month button
	 */
	jQuery("#BtnNextMonth").button();
	jQuery("#BtnNextMonth").click(function() {
		jfcalplugin.showNextMonth("#mycalendar");
		var calDate = jfcalplugin.getCurrentDate("#mycalendar");
		var cyear = calDate.getFullYear();
		var cmonth = calDate.getMonth();
		var cday = calDate.getDate();
		jQuery("#dateSelect").datepicker("setDate",cday+"/"+(cmonth+1)+"/"+cyear);
		getEvents(calDate);
		return false;
	});
	/**
	 * Initialize load button
	 */
	/* 
	jQuery("#BtnLoad").button();
	jQuery("#BtnLoad").click(function() {
		
	});
	*/
	/**fonction ajax pour charger automatiquement les evenements**/
	var tableEvents = new Array();
	var tableMonthEvents = new Array();
	
	function getEvents(date){
		if(!tableMonthEvents[date.getMonth() + 1]){
			
			jQuery('#loading').dialog('open');
			//vérifier qu'on a pas charger ce moi
			jQuery.ajax({
				url : "###URLAJAX###",
				type : "POST",
				data : {
					tx_ioceancalendar_pi1 : {
						timeCalendar : date.getTime()/1000,
					}
				},
				dataType: "json",
				success : function(data){
					tableMonthEvents[jfcalplugin.getCurrentDate("#mycalendar").getMonth()+1] = true;
					if(data.load) {
						ajoutEvents(data.load);
					}
					jQuery('#loading').dialog('close');
					
				},
				error : function(data){
					alert('error');
					alert(data);
					jQuery('#loading').dialog('close');
					
				}
			});
		} else {
			//alert('mois deja charger');
		}
	}
	/**
	* Creation des differents dialogs
	*/
	//pour le loading
	jQuery("#loading").dialog({
		autoOpen: false,
		modal: true,
	});
	
	//pour la visualisation
	jQuery("#read-event-form").dialog({
		autoOpen: false,
		minWidth: 350,
		modal: true,
		open : function(event, ui){
			var obj = jQuery(this).dialog('option','agendaItem');
			jQuery(this).find("#title").html(obj.title);
			if(!obj.allDay){
				jQuery(this).find("#dateDisplay").show();
				jQuery(this).find("#dateDeb").html(obj.data.dateDebDisplay);
				jQuery(this).find("#dateFin").html(obj.data.dateFinDisplay);
			} else {
				jQuery(this).find("#dateDisplay").hide();
			}
			if(obj.data.image){
				jQuery(this).find("#image").attr('src',obj.data.image);
			}
			jQuery(this).find("#description").html(obj.data.description);
			if(obj.data.linkDetail){
				jQuery(this).find("#linkDetail").attr('href',obj.data.linkDetail);
			}
		},
		close : function(){
			//alert("close dialog");
			jQuery(this).find("#title").html('');
			jQuery(this).find("#image").attr('src','clear.gif');
			jQuery(this).find("#description").html('');
			jQuery(this).find("#linkDetail").attr('href','#');
		}
	});
	
	/**
	* fonction d'ajout d'event par rapport a un tableu
	*/
	function ajoutEvents(data){
		jQuery(data).each(function(index,el){
			if(!tableEvents[el.id])	{
				jfcalplugin.addAgendaItem("#mycalendar",el.title,convertDate(el.dateDeb),convertDate(el.dateFin),el.allDay,el.data,el.displayProp);
				tableEvents[el.id] = el;
			}
		})
	}
	
	function convertDate(tsp){
		var date = new Date();
		date.setTime(tsp * 1000);
		return date;
	}
	
	getEvents(jfcalplugin.getCurrentDate("#mycalendar"));
});