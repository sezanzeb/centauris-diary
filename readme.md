# Centauri's Diary

Very minimal website software that works like a blog.
- Controlled from the file system by using .html and .json files, no admin backend
- Can have blogs with articles, organized by categories, or static pages
- That's it. Runs on your apache php server

Example: www.hip70890b.de, or you can put this repository into your apache 2 server,
for me this was at `/var/www/html/`, and see some minimal starting setup.

## 1. style, script, etc.

Put those into `/static/`

## 2. Static Pages

For example, this is how you would create a page named "bar":

Create a subdirectory `/content/bar/` and create `page.json` and `index.html` in it.

The subdirectory name is what you will have to type in your adress bar and it should be valid for urls.
Don't use whitespaces for example.

in page.json, add a title property like this:

```json
{
    "title": "Baz"
}
```

put the content you want to display on the page into index.html

Alternatively, if you don't want to show navigation, header and the like, put your html file into the
static directory. For this you won't need any configuration file and the like.

## 3. Blog Items

To create a blog category named "foo" and an article named "new", create the directory
`/content/foo/` and add a file called `category.json`. It contains the following:

```json
{
    "title": "Stuff",
    "class": "color1",
    "icon": "fa fa-pencil"
}
```

`class`, and `icon` are optional. The icon is displayed inside the nav as the class of an `<i>` tag.
The "class" attribute will be inserted as the class of the nav item and the generated headline.
Font Awesome is supported for the icon names, but you have to link its css library in the header of
your template.php file first.

To create the article, create the subdirectory `/content/foo/new/` and put `article.json` and
index.html into it.

```json
{
    "title": "New"
}
```

the modificationtime of index.html is used as the date of the article, but it can be overwritten
using a unix timestamp in article.json like this: `"timestamp": 1554336000`

in index.html you can use any html.

## 4. Using Pictures in Static Pages and Blog Entries

Pictures for your articles or pages can be in the placed in for example `/content/foo/new/pic.png`, or in
`/static/pic.png`, `/static/stuff/pic.png` or `/content/foo/new/any/subdirectory/pic.png`. In your html
file you can use it like this, depending where you put it:

```html
<img src="foo/new/pic.png">
<img src="pic.png">
<img src="stuff/pic.png">
<img src="foo/new/any/subdirectory/pic.png">
```

as you can see, the `content/` and `static/` folder names are hidden in the url. As static files should
include important components of your website like script.js and style.css, they are prefered. So if you have
an image in `static/pic.jpg` and one in `content/pic.jpg`, the one form static will be served.

## 5. Modifying the Template

There is a template.php in the root directory. It accepts any php, additionally the `render` function
is available to put some generated stuff into it and your content.

`<?php render("nav") ?>`

The navigation, generated from the immediate subdirectories of the `content/` directory, but only those that
either contain a `category.json` or a `page.json` file.

`<?php render("toc") ?>`

The table of contents of a category, to create links that lead its articles.

`<?php render("content") ?>`

Your articles, blog entries, pages and html files contents that you are currently viewing

`<?php render("title") ?>`

The name of your current page, e.g. 'Home', 'Baz' or 'New'. On blog articles, this is already automatically
inserted as heading, but you can use this for example in your template for the title tag of the head
