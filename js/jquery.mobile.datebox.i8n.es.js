/*
 * jQuery Mobile Framework : plugin to provide a date and time picker.
 * Copyright (c) JTSage
 * CC 3.0 Attribution.  May be relicensed without permission/notifcation.
 * https://github.com/jtsage/jquery-mobile-datebox
 *
 * Translation by: Unknown
 *
 */

jQuery.extend(jQuery.mobile.datebox.prototype.options.lang, {
	'es-ES': {
		setDateButtonLabel: "Guardar Fecha",
		setTimeButtonLabel: "Guardar Hora",
		setDurationButtonLabel: "Guardar Duracion",
		calTodayButtonLabel: "Hoy",
		titleDateDialogLabel: "Elija fecha",
		titleTimeDialogLabel: "Elegir el tiempo",
		daysOfWeek: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
		daysOfWeekShort: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
		monthsOfYear: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviemebre", "Diciembre"],
		monthsOfYearShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
		durationLabel: ["DÃ­as", "Horas", "Minutos", "Segundos"],
		durationDays: ["DÃ­a", "DÃ­as"],
		tooltip: "Abrir El Calendario",
		nextMonth: "Mes PrÃ³ximo",
		prevMonth: "Mes Anterior",
		timeFormat: 12,
		headerFormat: '%A, %-d %B, %Y',
		dateFieldOrder: ['d','m','y'],
		timeFieldOrder: ['h', 'i', 'a'],
		slideFieldOrder: ['y', 'm', 'd'],
		dateFormat: "%d/%m/%Y",
		useArabicIndic: false,
		isRTL: false,
		calStartDay: 0,
		clearButton: "Claro"
	}
});
jQuery.extend(jQuery.mobile.datebox.prototype.options, {
	useLang: 'es-ES'
});

