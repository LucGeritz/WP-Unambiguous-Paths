#WP Unambiguous Paths

**A WordPress Plugin for unambiguous path and url access**

##What's the problem?
I find WordPress path and url strategy confusing at the least. Maybe it's just me but if I want to refer to my parent child theme folder I do not find it logical to refer to the stylesheet directory (`get_stylesheet_directory`) just because by coincidence the stylesheet is in my child theme. And `get_template_directory` gives me the parent folder..? Oh and `plugin_dir_path()` (or was it `get_plugin_directory_path_uri()` ?) only returns (quoting the official docs)  *will not return the directory of a plugin unless you call it within a file in the plugin’s base directory*. 

##Plugin
Admitted, it's only a small problem, but so is the plugin. Still testing it but it seems to work alright on a parent and child theme. It is really just a single class, making a plugin structure almost an overkill. You could easily use the class itself within your project without using the plugin. The one thing the pugin adds is autoloading.

##Usage
If using the plugin you usage is easy.    

`Tigrez\Path::parentThemeUrl();`

You want a trailing slash?

`Tigrez\Path::trailingSlash()->parentThemeUrl();`

You want a specific folder within

`Tigrez\Path::trailingSlash()->parentThemeUrl('asset');`

.. or a file

`Tigrez\Path::::parentThemeUrl('asset/logo.png');`

That's all really

I tried to use a consistent terminology. You either refer to a *url* or a *folder*. Available at the time of writing are:

- `parentThemeUrl()` *the parent theme's url. If this is a parent theme then the theme url is returned*  
- `parentThemeFolder()` *the parent theme's folder. If this is a parent theme then the theme folder is returned*
- `childThemeUrl()` *the child theme's url, if this is not a child theme an empty string is returned*
- childThemeFolder()
- `themeUrl()` *the url of the active theme, in case of a parent theme this returns the parent theme's url, in case of a child theme this returns the child theme's url.*
- `themeFolder` *the folder of the active theme, in case of a parent theme this returns the parent theme's folder, in case of a child theme this returns the child theme's folder.*
- `uploadFolder()` *the current upload folder (including year and month)*
- `uploadUrl()` *the current upload url (including year and month)*
- `uploadBaseFolder()` *the base upload folder*
- `uploadBaseUrl()` *the base upload url*
- `pluginFolder()` *the plugin folder* 
- `rootFolder()` *the root folder*
- `hostUrl()` *host*
- `scheme()` *http or https*  

All return a string, they do not echo anything!
All but `scheme` can take a string parameter to suffixed to the output.
     
`scheme()` is an exception being neither url or folder. Scheme returns either *http* or *https*. If *trailingSlash* is called before scheme a :// is added to the scheme. 

##Examples
The example code used for testing (Running locally with xampp) :

     echo '<br>parent theme url : '.Tigrez\Path::trailingSlash()->parentThemeUrl();
     echo '<br>parent theme fld : '.Tigrez\Path::trailingSlash()->parentThemeFolder();
     echo '<br>child  theme url : '.Tigrez\Path::trailingSlash()->childThemeUrl();
     echo '<br>child  theme fld : '.Tigrez\Path::trailingSlash()->childThemeFolder();
     echo '<br>upload folder    : '.Tigrez\Path::trailingSlash()->uploadFolder();
     echo '<br>upload url       : '.Tigrez\Path::trailingSlash()->uploadUrl();
     echo '<br>upload base fld  : '.Tigrez\Path::trailingSlash()->uploadBaseFolder();
     echo '<br>upload base url  : '.Tigrez\Path::trailingSlash()->uploadBaseUrl();
     echo '<br>plugin folder    : '.Tigrez\Path::trailingSlash()->pluginFolder();
     echo '<br>Root folder      : '.Tigrez\Path::trailingSlash()->rootFolder();
     echo '<br>Host url         : '.Tigrez\Path::trailingSlash()->hostUrl();
     echo '<br>Scheme           : '.Tigrez\Path::trailingSlash()->scheme();


When used in twenty-seventeen the output is:

     parent theme url : http://localhost/wp/wp-content/themes/twentyseventeen/
     parent theme fld : C:/xampp/htdocs/wp/wp-content/themes/twentyseventeen/
     child theme url  : 
     child theme fld  : 
     theme url        : http://localhost/wp/wp-content/themes/twentyseventeen/
     theme folder     : C:/xampp/htdocs/wp/wp-content/themes/twentyseventeen/
     upload folder    : C:/xampp/htdocs/wp/wp-content/uploads/2016/12/
     upload url       : http://localhost/wp/wp-content/uploads/2016/12/
     upload base fld  : C:/xampp/htdocs/wp/wp-content/uploads/
     upload base url  : http://localhost/wp/wp-content/uploads/
     plugin folder    : C:/xampp/htdocs/wp/wp-content/plugins/
     Root folder      : C:/xampp/htdocs/wp/
     Host url         : localhost/
     Scheme           : http://

When used in the 2017-child, a twenty-seventeen's child theme it outputs:

    parent theme url  : http://localhost/wp/wpcontent/themes/twentyseventeen/
    parent theme fld  : C:/xampp/htdocs/wp/wp-content/themes/twentyseventeen/
    child theme url   : http://localhost/wp/wp-content/themes/2017-child/
    child theme fld   : C:/xampp/htdocs/wp/wp-content/themes/2017-child/
    theme url         : http://localhost/wp/wp-content/themes/2017-child/
    theme folder      : C:/xampp/htdocs/wp/wp-content/themes/2017-child/
    upload folder     : C:/xampp/htdocs/wp/wp-content/uploads/2016/12/
    upload url        : http://localhost/wp/wp-content/uploads/2016/12/
    upload base fld   : C:/xampp/htdocs/wp/wp-content/uploads/
    upload base url   : http://localhost/wp/wp-content/uploads/
    plugin folder     : C:/xampp/htdocs/wp/wp-content/plugins/
    Root folder       : C:/xampp/htdocs/wp/
    Host url          : localhost/
    Scheme            : http://

 ##Considerations
 So when you want to refer to the theme folder/uri regardless of whether you're in a child or parent theme, use `themeUrl` or `themeFolder`. Hopefuly I didn't introduce my own ambiguity by letting the parent methods return the active theme when you're in this parent. Seemed logical to me..