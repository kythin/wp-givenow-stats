wp-givenow-stats
================
  
Simple wordpress plugin to show your givenow.com.au amount raised and thermometer image, and link to your givenow.com.au donation page.
  
  
Use shortcodes in combination with the name of your page id on givenow.com.au.  
E.g. if your givenow link is http://www.givenow.com.au/abc123, the page variable to use is abc123.   
  
```
To just show the current amount raised:
[givenow-raised page="abc123"]
```
  
```
To just show the current thermometer image which links to the donation page:
[givenow-gauge page="abc123"]
```
  
```
To show the thermometer with the raised amount underneath, both are links to the donation page:
[givenow page="abc123"]
```
  
  
I offer no support and take no responsibility for anything this plugin may do, use it at your own risk.   
  
Seriously though, it's like 10 lines of code wrapped in a plugin generator, so if it did anything I would be really surprised.


Installation  
----
Download the zip file of this master branch: https://github.com/kythin/wp-givenow-stats/archive/master.zip
  
Use the plugin uploader in wordpress to install it. Activate it. Then use any combination of the shortcodes above.
  
If you want it to work inside a widget, I suggest you find a plugin that makes shortcodes work inside widget text fields.


Tested and working in wordpress 3.6+ and 3.7+
