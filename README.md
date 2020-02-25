# Kirby Likes (WIP)

Super simple plugin that adds routes, a page method and a panel field so you can easily add likes/hearts/votes to your pages.

## Frontend:

![Likes Frontend](https://user-images.githubusercontent.com/7975568/75246246-af5a5100-57cf-11ea-9021-0c1d0e33cb33.gif)
```php
<a href="<?= $page->url() ?>/like/toggle">❤️ <?= $page->likeCount() ?></a>

<a href="<?= $page->url() ?>/like/add">👍</a>
<a href="<?= $page->url() ?>/like/remove">👎</a>
```

## Backend:

![Likes Field](https://user-images.githubusercontent.com/7975568/75246430-08c28000-57d0-11ea-88f3-783abe8cc0aa.png)
```yml
fields:
  likes:
    label: Likes
    type: likes
```
