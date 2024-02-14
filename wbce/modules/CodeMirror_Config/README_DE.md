CodeMirror-Konfigurator
=====================

> Ein Admin-Tool für WBCE CMS

## Konfiguration: Anpassung des Aussehens des CodeMirror-Editors

Um den Editor anzupassen, gehen Sie zu ``AdminTools>>CodeMirror Cofiguator`` und Sie finden folgende Konfigurationsoptionen:

- **Theme-Auswahl**: Wählen Sie das gewünschte Thema für den CodeMirror-Editor aus. Wählen Sie aus einer Liste von vordefinierten Themen.
- **Schriftart**: Geben Sie die Schriftart für den Editor an. Wählen Sie aus den verfügbaren Schriftarten.
- **Schriftgröße**: Legen Sie die Schriftgröße für den Editor fest. Wählen Sie eine geeignete Größe aus den verfügbaren Optionen.

## Informationen für Modulentwickler

### Implementierung des CodeMirror-Editors im Modul

Die folgende Implementierung zeigt die grundlegendste Implementierung einer CodeMirror-Instanz:

``` php
// Überprüfen Sie, ob CodeMirror ausgeführt wird
// (die Konstante CODEMIRROR ist definiert und true, wenn CodeMirror ausgeführt wird)
if(defined('CODEMIRROR')){
    // rufen Sie die registerCodeMirror-Funktion auf
    registerCodeMirror(
        'code_area', // die ID des Textbereichs, der durch eine CodeMirror-Instanz ersetzt werden soll
        'php' // die zu rendernde Programmiersprache
    );
}
```

### Erweiterte Implementierung

Manchmal werden möglicherweise weitere Einstellungen bei der Implementierung des CodeMirror-Editors im Modul benötigt. In diesem Fall können kann ein Array mit Einstellungen im dritten Argument bereitgestellt werden:

``` php
<?php
if(defined('CODEMIRROR')){
    // rufen Sie die registerCodeMirror-Funktion mit benutzerdefinierten Einstellungen im 3. Argument auf
    registerCodeMirror(
        'code_area',
        'php',
        [ // Standard-Einstellungen:
            'readOnly' => false,
            'lineNumbers' => true,
            'foldGutter' => true,
            'simpleScroll' => true,
            'lineWrapping' => true, // DE:Zeilenumbruch
            'lineHeight' => '150%',
            'height' => '450',
            'width' => 'null' // null bedeutet: Dimension sollte nicht geändert werden
        ]
    );
}
```

_(Das obige Array stellt die Standard-Einstellungen dar.)_

### Ändern einer bestimmten Einstellung

In den meisten Fällen möchten Sie wahrscheinlich die Standardhöhe in eine benutzerdefinierte Höhe ändern. Dies würde wie folgt funktionieren:

``` php
if(defined('CODEMIRROR')){
    registerCodeMirror(
        'code_area',
        'php',
        [
            'height' => '300', // benutzerdefinierte Höhe
        ]
    );
}
```

## Unterstützung

Bei Problemen oder Fragen zu diesem Admin-Tool, kontaktiert uns gerne über das [WBCE CMS Community Forum](https://forum.wbce.org/). 

Wir hoffen, dass dieses Admin-Tool Dein WBCE CMS-Erlebnis verbessert. 

Viel Spaß beim Programmieren!
