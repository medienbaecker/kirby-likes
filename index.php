<?php

function like($page, $action) {
	$actions = ['add','remove','toggle'];
	if(page($page) && in_array($action, $actions)) {
		kirby()->impersonate('kirby');
		$page = page($page);
		$visitor = md5('v-' . kirby()->visitor()->ip());
		if(strpos($page->likes(), $visitor) !== false) {
			if($action == 'remove' OR $action == 'toggle') {
				if(strpos($page->likes(), $visitor) !== false) {
					$page->update(['likes' => str_replace($visitor . ';', '', $page->likes()->value())]);
				}
			}
		}
		else {
			if($action == 'add' OR $action == 'toggle') {
				if(strpos($page->likes(), $visitor) === false) {
					$page->update(['likes' => $page->likes()->value() . $visitor . ';']);
				}
			}
		}
		go($page);
	}
	else {
		go(site()->errorPage());
	}
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
			'action' => function($page, $action) {
				like($page, $action);
			}
		],
		[
			'pattern' => 'like/(:any)',
			'action' => function($action) {
				like(site()->homePage(), $action);
			}
		]
	],
	'pageMethods' => [
		'likeCount' => function() {
			$likes = $this->likes()->split(';');
			return count($likes);
		}
	],
]);
