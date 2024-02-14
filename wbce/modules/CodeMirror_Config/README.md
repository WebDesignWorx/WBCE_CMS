CodeMirror Cofiguator
=====================
> an AdminTool for WBCE CMS

## Configuration: customize the look & feel of the CodeMirror editor

To customize the editor go to ``AdminTools>>CodeMirror Cofiguator`` and you will find the following configuration options:

   - **Theme Selection**: Choose the desired theme for the CodeMirror Editor. Select from a list of predefined themes.

   - **Font-Type**: Specify the font type for the editor. Choose from available font options.

   - **Font-Size**: Set the font size for the editor. Select a suitable size from the available options.


## Infos for Module Developers
### Implementing CodeMirror editor in your module
The following is the most basic implementation of a CodeMirror instance:
``` php

// Check if CodeMirror is running
// (the Constant CODEMIRROR is defined and true if CodeMirror is running)
if(defined('CODEMIRROR')){

    // call the registerCodeMirror function
    registerCodeMirror(
       'code_area', // the id of the textarea to be replaced by a CodeMirror instance
       'php'        // the programming language to be rendered
    );
}
```

### Extended implementation
Sometimes you may need more settings when implementing the CodeMirror editor in your module.
In this case you can provide an array of settings in the third argument when calling the function:
``` php
<?php
if(defined('CODEMIRROR')){

    // call the registerCodeMirror function with custom settings in 3rd argument
    registerCodeMirror(
       'code_area', 
       'php',
        [
            // default settings:
            'readOnly'     => false,
            'lineNumbers'  => true,
            'foldGutter'   => true,
            'simpleScroll' => true,
            'lineWrapping' => true,   // DE:Zeilenumbruch
            'lineHeight'   => '150%',
            'height'       => '450', 
            'width'        => 'null' // null means: dimension should not be changed
        ]
    );
}
```
_(The above array represents the default settings.)_

### Changing a specific setting
Most often you probably would want to change the defualt height to a custom one.
This would work like this:
``` php
if(defined('CODEMIRROR')){

    registerCodeMirror(
       'code_area', 
       'php',
        [
            'height' => '300', // custom height
        ]
    );
}
```


## Support

If you encounter any issues or have any questions regarding this AdminTool, please feel free to reach out to us through the [WBCE CMS Community Forums](https://forum.wbce.org/).

We hope this AdminTool enhances your WBCE CMS experience.

Happy coding!