# Kirby Likes

Kirby Likes adds routes, handy page methods and a panel field so you can easily add likes/hearts/votes to pages.

See it live on https://kirbysites.com

## Frontend

![Likes Frontend](https://user-images.githubusercontent.com/7975568/75246246-af5a5100-57cf-11ea-9021-0c1d0e33cb33.gif)

You can either use the `toggle` route or separate `add` and `remove` routes.

```php
<a href="<?= $page->url() ?>/like/toggle">❤️ <span><?= $page->likeCount() ?></span></a>

<a href="<?= $page->url() ?>/like/add">👍</a>
<a href="<?= $page->url() ?>/like/remove">👎</a>
```

Kirby Likes works without JavaScript. If you fetch the routes with the POST method, the plugin automatically returns a JSON with the page, wether the user has liked and the final like count.

```js
fetch(this.getAttribute('href'), {
  method: 'POST'
})
.then((response) => {
  return response.json();
})
.then((data) => {
  this.querySelector("span").innerText = data.likeCount;
  if(data.hasLiked) {
    this.classList.add('has_liked');
  }
  else {
    this.classList.remove('has_liked');
  }
});
```

## Backend

![Likes Field](https://user-images.githubusercontent.com/7975568/75246430-08c28000-57d0-11ea-88f3-783abe8cc0aa.png)

```yml
fields:
  likes:
    label: Likes
    type: likes
```
