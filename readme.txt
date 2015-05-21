=== Long Comment Filter ===
Contributors: itsananderson
Requires at least: 4.2
Tested up to: 4.2
Stable tag: 1.0

Description: Prevents users from posting comments that are longer than a configurable maximum

== Description ==

Sometimes comments become so long that they lose their value.

Long Comment Filter solves this problem by preventing visitors from posting long comments.

= Features =

Long Comment Filter Plugin is pretty flexible. Here are some things you can customize.

* Filter Type - This determines whether to apply a maximum word or maximum character filter
* Maximum Count - Sets the maximum number of words/characters (depending on Filter Type) that comments can contain.
* Default Filter Action - This determines whether filtered comments are deleted, or simply flagged as spam
* Filter Registered Users - If turned off, registered users will not be filtered. They can create comments of any length.
* Check Client Side - If turned on, JavaScript will be used on the client side to make sure comments aren't too long. On by default.

== Installation ==

*Manual Installation*

1. Upload the complete `long-comment-filter` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to Settings > Long Comment Filter to customize the plugin settings.
4. If you wish to use client side JavaScript filtering, make sure your comment form has ID "commentform" and your comment textbox has ID "comment"


*WordPress Admin Installation*

1. Log into your WordPress Admin
2. Go to Plugins &raquo; Add New
3. Search for "Long Comment Filter"
4. Click "Install"
5. Click "Activate"
6. Navigate to Settings > Long Comment Filter to customize the plugin settings.
7. If you wish to use client side JavaScript filtering, make sure your comment form has ID "commentform" and your comment textbox has ID "comment"
