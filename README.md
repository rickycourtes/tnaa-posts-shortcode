# TNAA Posts
Wordpress shortcode plugin displaying TNAA posts via the `[tnaa-posts]` in a post or page.

## How to Use

Template: `[tnaa-posts limit="5" sort="desc" sortby="date" categories="13"]` 

### Options

+ `limit` - Maximum number of items to be returned in result set.
  - Default: `5`
+ `order` - Order sort attribute ascending or descending.
  - Default: `desc`
  - One of: `asc`, `desc`
+ `orderby` - Sort post collection by object attribute.
  - Default: `date`
  - One of: `title`, `author`, `date`, `id`, `include`, `modified`, `parent`, `relevance`, `slug`, `include_slugs`
+ `categories` - Limit result to all items that have the specified term assigned in the categories taxonomy.

