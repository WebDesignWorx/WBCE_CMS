jQuery Modul: Sticky Elements

**** Hinweise: *********************************

+++
Es sind mehrere Aufrufe des jQuerys auf einer Seite möglich.

+++
Cookies:
Das jQuery legt für jeden Aufruf einen Cookie an, in dem die Zustände/Eigenschaften der Boxen/Elemente (geöffnet/geschlossen/Klasse für Farbe, etc.) gespeichert werden. 
Es werden keine Daten zur Identifikation (weder über den User, Rechner, Browser) erhoben.


++++++ Html-Code-Beispiel (Standard-Anwendung)

<div class="stickybox">
	Dynamisches Element, das geöffnet oder geschlossen werden kann,
	oder dem per Klasse eine Eigenschaft (e.g. Farbe) zugewiesen werden kann.
</div>

++++++ jQuery-Aufruf

// Einfacher Aufruf zum Öffnen/Schließen von Boxen
$(document).ready(function() {
	$('.stickybox').stickyElements();
});

// Erweiterter Aufruf für Elemente mit einer Eigenschaftsklasse (e.g. .blau):
// Der Name der Eigenschaftsklasse, die dem Element hinzugefügt wird ist: .stickyByClassColor
// ACHTUNG: FÜR DIESEN EINSATZ MÜSSEN BEIDE OPTIONEN GESETZT WERDEN:
// stickyMethod: 'class' 
// --> dann ist auch die zusätzliche Option zur Benennung der Klasse erforderlich: stickyFormatClass: 'stickyByClassColor'
$(document).ready(function() {
	$('.stickyByClassElement').stickyElements({
		stickyMethod: 'class',
		stickyFormatClass: 'stickyByClassColor'
	});
});

// ADVANCED OPTION
// pageModus
// Standardmäßig sind nur die Elemente auf der spezifischen Seite sticky
// Sollen Elemente Domain-Weit sticky gemacht werden erfolgt dies über die Option
// pageModus: 'domainWide',
$(document).ready(function() {
	$('.stickyByClassElement').stickyElements({
		pageModus: 'domainWide'
	});
});