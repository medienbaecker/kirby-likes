<?php

function like($page, $action) {
	$actions = ['add','remove','toggle'];
	$result = false;
	if(page($page) && in_array($action, $actions)) {
		kirby()->impersonate('kirby');
		$page = page($page);
		$visitor = md5('v-' . kirby()->visitor()->ip());
		if(strpos($page->likes(), $visitor) !== false) {
			if($action == 'remove' OR $action == 'toggle') {
				if(strpos($page->likes(), $visitor) !== false) {
					$page = $page->update(['likes' => str_replace($visitor . ';', '', $page->likes()->value())]);
					$result = [
						'page' => $page,
						'hasLiked' => false,
						'likeCount' => $page->likeCount()
					];
				}
			}
		}
		else {
			if($action == 'add' OR $action == 'toggle') {
				if(strpos($page->likes(), $visitor) === false) {
					$page = $page->update(['likes' => $page->likes()->value() . $visitor . ';']);
					$result = [
						'page' => $page,
						'hasLiked' => true,
						'likeCount' => $page->likeCount()
					];
				}
			}
		}
	}
	return $result;
}

Kirby::plugin('medienbaecker/likes', [
	'fields' => [
		'likes' => [
			'computed' => [
				'likeCount' => function () {
					return $this->model()->likeCount();
				}
			]
		]
	],
	'routes' => [
		[
			'pattern' => '(:all)/like/(:any)',
			'method' => 'GET|POST',
			'action' => function($page, $action) {
				$result = like($page, $action);
				if($result) {
					if($this->method() == 'POST') {
						return response::json($result);
					}
					else {
						go($result['page']);
					}
				}
				else {
					go(site()->errorPage());
				}
			}
		],
		[
			'pattern' => 'like/(:any)',
			'method' => 'GET|POST',
			'action' => function($action) {
				$result = like(site()->homePage(), $action);
				if($result) {
					if($this->method() == 'POST') {
						return response::json($result);
					}
					else {
						go($result['page']);
					}
				}
				else {
					go(site()->errorPage());
				}
			}
		]
	],
	'pageMethods' => [
		'likeCount' => function() {
			$likes = $this->likes()->split(';');
			return count($likes);
		},
		'hasLiked' => function() {
			$likes = $this->likes()->split(';');
			return in_array(md5('v-' . kirby()->visitor()->ip()), $likes);
		},
	],
]);
