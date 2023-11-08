<?php

class SearchPosts {
    protected $wpdb;
    public string $keyword;

    public function __construct( string $keyword )
    {
        global $wpdb;
        $this->wpdb    = $wpdb;
        $this->keyword = sanitize_text_field( $keyword );
    }

    public function getPostIds(): array
    {
        $post_ids      = $this->findPosts();
        $meta_post_ids = $this->findPostMeta();

        $all_post_ids = array_merge(
            wp_list_pluck( $post_ids, 'ID' ),
            wp_list_pluck( $meta_post_ids, 'post_id' )
        );

        return array_unique( $all_post_ids );
    }

    protected function findPosts(): array
    {
        $query = $this->wpdb->prepare(
            "SELECT ID
		    FROM {$this->wpdb->posts}
		    WHERE (post_title LIKE '%%%s%%' OR post_content LIKE '%%%s%%')
		    AND post_type = 'post'
		    AND post_status = 'publish'
		    AND ID NOT IN (
		        SELECT ID
		        FROM {$this->wpdb->posts}
		        WHERE post_type = 'revision'
		    )",
            $this->keyword,
            $this->keyword
        );

        return $this->wpdb->get_results( $query );
    }

    protected function findPostMeta(): array
    {
        $meta_query = $this->wpdb->prepare(
            "SELECT post_id
            FROM {$this->wpdb->postmeta}
            WHERE meta_key = '_yoast_wpseo_metadesc' AND meta_value LIKE '%%%s%%'
            OR meta_key = '_yoast_wpseo_title' AND meta_value LIKE '%%%s%%'",
            $this->keyword,
            $this->keyword
        );

        return $this->wpdb->get_results( $meta_query );
    }
}