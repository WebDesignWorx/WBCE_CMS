function getScriptDirUrl() {
    var scripts = document.getElementsByTagName('script');
    var script = scripts[scripts.length - 1].src;
    return script.substring(0, script.lastIndexOf('/'));
};