<?php

class DataPresenter {
    public function __construct( protected array $postIds )
    {
    }

	public function providePostsData(): array
	{
		$data = [];

		if ( empty($this->postIds) ) {
			 $data['error'] = 'no posts';
			 return $data;
		}

		foreach ($this->postIds as $postId) {
			$metaTitle = strip_tags(get_post_meta($postId, '_yoast_wpseo_title', true));
			$metaDesc = strip_tags(get_post_meta($postId, '_yoast_wpseo_metadesc', true));

			$remove_patterns = '/%%(.*?)%%/';

			$data[] = [
				'post_id' => $postId,
				'post_title' => strip_tags(get_post_field('post_title', $postId)),
				'post_content' => strip_tags(get_post_field('post_content', $postId)),
				'meta_title' => preg_replace($remove_patterns, '', $metaTitle),
				'meta_desc' => preg_replace($remove_patterns, '', $metaDesc),
			];
		}

		return $data;
	}
}