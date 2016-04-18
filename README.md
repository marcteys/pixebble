Pixebble
========

[Pixebble](http://half4.com/pixebble/)

Pixebble is the fastest way to preview your designs accurately on Pebble devices. With Pixebble, you can make sure your designs appear exactly the way you want on the Pebble OG, Pebble Time or Pebble Time Round. 

Pixebble is included with a Dither library, who automatically convert the colors of your design to match the samrtwatch's color palette. 

Email [marc.teys@gmail.com][support] for questions or support.


Getting Started
---------------

Pixebble is a combinaison of a web service and an app. Because it's complex to send image data to a Pebble, we cannot refresh the image in real time ; the user have to manually upload his design. 

 * Download [Pixebble Watchapp](http://apps.getpebble.com/en_US/application/56a63eaeed368bd240000035?dev_settings=true&native=false&query=pixebble&section=watchapps) in the store
 * Open [Pixebble website](http://half4.com/pixebble/) on your favorite browser 
 * Set a custom *Unique Identifier* and add it in the settings of the watchapp.
 * Upload your image on the website
 * Shake the watch or press the middle button to get the image on the watch
 


Features
--------

 * You can keep records of your uploaded image. Clicking one on the gallery will select is as main image. 
 * The **Dither library** allows you to convert any image for pebble.
 * You library can be shared using the link **http://half4.com/pixebble/#*<your identifier>* **

TODOs
--------

 * Explore previous images with up/down buttons
 * Send an image without any ratio, just to verify the color saturation. Add a bolean. 

Contributing
-----------------

First of all, thank for your help if you want to contribute. There are two solutions for you.

**You are a developer**

Fork the repo, create a branch, do your work, and make a pull request. Please respect the [commits style](http://github.com/marcteys/pixebble/commits/master).
If your contribution make sense, I will merge it in master. You can fix typos. 

Web application is located on [master](http://github.com/marcteys/pixebble/tree/master) branch, Watchapp is on [watchapp](http://github.com/marcteys/pixebble/tree/watchapp) branch.


**You are a user**

 Contact me and submit your ideas at [@marcteyssier](http://twitter.com/marcteyssier) or by [email][support].
 Found a bug ? Report it on the [issue tracker](https://github.com/marcteys/pixebble/issues).


License
-------

All Project Pixebble is licensed with the MIT License. For more details, see [LICENSE](http://github.com/marcteys/pixebble/blob/master/LICENSE).
Pixebble is based on [pebble-faces](http://github.com/pebble-examples/pebble-faces) example, under MIT License.

Libraries :

 * [DitherJs](http://github.com/dpiccone/ditherjs), GPL License
 * [Zepto](http://zeptojs.com/), MIT License
 * [DropzoneJS](http://github.com/enyo/dropzone/), MIT License



[support]: mailto:marc.teys@gmail.com
