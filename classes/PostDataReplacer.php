<?php

class PostDataReplacer {
    protected $wpdb;

    public function __construct( protected array $postIds )
    {
        global $wpdb;
        $this->wpdb = $wpdb;
    }

    public function replaceFields( $from, $to, $fieldKey ): void
    {
        foreach ( $this->postIds as $postId ) {
            if ( $value = $this->getMetaValue( $postId, $fieldKey ) ) {
                $newValue = str_replace( $from, $to, $value );
                $this->updateMetaField( $postId, $fieldKey, $newValue );
            } else {
                $value    = $this->getPostFieldValue( $postId, $fieldKey );
                $newValue = str_replace( $from, $to, $value );
                $this->updatePostField( $postId, $fieldKey, $newValue );
            }
        }
    }

    protected function getMetaValue( $postId, $fieldKey ): string
    {
        return get_post_meta( $postId, $fieldKey, true );
    }

    protected function getPostFieldValue( $postId, $fieldKey ): string
    {
        return get_post_field( $fieldKey, $postId );
    }

    protected function updateMetaField( $postId, $fieldKey, $newValue ): void
    {
        update_post_meta( $postId, $fieldKey, $newValue );
    }

    protected function updatePostField( $postId, $fieldKey, $newValue ): void
    {
        wp_update_post( [
            'ID'      => $postId,
            $fieldKey => $newValue,
        ] );
    }

}