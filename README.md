# CakePHP 3.6+ Slugify Behavior
A behavior for CakePHP 3.6+ that makes slug generation automatic.
It will change your amazing title or name to a seo-friendly slug.
For example:
Your article titled: `My brother's amazing story` will generate the following slug: `my-brothers-amazing-story`.

The behavior uses transliteration so you don't lose any important foreign letters:
Your product named: `Postcard from Kraków` will generate the following slug: `postcard-from-krakow`.

### Requirements:
* PHP 7.1+
* CakePHP 3.6+ (might work on earlier versions, but it was not tested. Works on CakePHP 4+ as well).

## Installation and basic usage

Drop the SlugifyBehavior.php file into `/src/Model/Behavior`.

Your table MUST contain a column for slug (default: `slug`, but it is configurable).
Your column SHOULD also contain a column that serves as a base to generate slug from (like article title, defaults to `name`, but it is configurable).

To use the behavior, add the following line to your desired table `initialize` method:

`$this->addBehavior('Slugify');`

If your table matches the default values above, your slugs will be automatically slugified to a pretty version.

## How it works

The magic is happening during Before Marshall Event, so before the data is turned into entity. This is to make sure the slug undergoes validation.

The Behavior looks for the `slug` (or it counterpart - more information in Advanced Usage section) key first. This allows your users to set the slug manually.
If it is present, the Behavior makes sure it is SEO-friendly (by making sure your user did not accidentally add a space or special character).

Example:
If your user sent a slug like: `my amazing-sluG` it will be changed to `my-amazing-slug`.

If the slug key is empty (it is either not sent or user left it empty to let the Behavior work it's magic), the Bahavior looks for the key it can use to make the slug from.
It defaults to `name`, but is configurable (more information in Advanced Usage section).
If it is present, the Behavior will slugify it and save in the `slug` (or your counterpart) column.

If neither of the fields is present, the propagation will stop.

## Advanced Usage

When loading the Behavior you may change the names of columns. The key for slug is `field`, while the key for the column you want to generate the slug from is `parentField`.
So, if you are posting articles, you might store their title in `title` column, while the slug might be saved in `url` column.
Then your Behavior should be initialized like so:
`$this->addBehavior('Slugify', ['parentField' => 'title', 'field' => 'url']);`

You may configure one of the fields, both or neither.

As improbable as it is, you don't need a parentField in the database, but in such cases your request needs to contain some value for slug.
A column for slug is always required, but does not need to be present in the request as long as you do have a parentField.