# Kirby Likes

Kirby Likes adds routes, handy page methods and a panel field so you can easily add likes/hearts/votes to pages.

See it live on https://kirbysites.com

## Frontend

![Likes Frontend](https://user-images.githubusercontent.com/7975568/75246246-af5a5100-57cf-11ea-9021-0c1d0e33cb33.gif)

You can either use the `toggle` route or the separate `add` and `remove` routes.

```php
<a href="<?= $page->url() ?>/like/toggle">❤️ <span><?= $page->likeCount() ?></span></a>

<a href="<?= $page->url() ?>/like/add">👍</a>
<a href="<?= $page->url() ?>/like/remove">👎</a>
```

Kirby Likes works without JavaScript, so triggering either route applies its action and reloads the page. If you want to update the count "on the fly" (without reloading the whole page), you can `fetch` the route with a POST request and determine from the plugin's JSON response wether the user has liked as well as the final like count.

This may be achieved by copying this snippet inside an [event handler](https://developer.mozilla.org/en-US/docs/Web/API/EventTarget/addEventListener)'s callback function:

```js
// Select target selector
var button = document.querySelector('like-button');

// Add click handler
button.addEventListener('click', function(e) {
  fetch(this.getAttribute('href'), {
    method: 'POST'
  })
  .then((response) => {
    return response.json();
  })
  .then((data) => {
    this.querySelector('span').innerText = data.likeCount;

    if (data.hasLiked) {
      this.classList.add('has_liked');
    } else {
      this.classList.remove('has_liked');
    }
  });
})
```

## Backend

![Likes Field](https://user-images.githubusercontent.com/7975568/75246430-08c28000-57d0-11ea-88f3-783abe8cc0aa.png)

For displaying the counter in the backend, simply add this to the respective page blueprint:

```yml
fields:
  likes:
    label: Likes
    type: likes
```

## Page methods

In your templates, the following page methods are available:

### `likeCount()`
As seen in the example above, this exposes the current count for a given page.

### `hasLiked()`
This is especially useful for applying different styles or other attributes to the counter on your page. 
