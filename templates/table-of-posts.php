<?php if ( $dataPosts['error'] ) : ?>
    <?= $dataPosts['error']; ?>
<?php else : ?>

    <table>

        <tr>
            <th><?php _e( 'ID', DOMAIN ) ?></th>
            <th><?php _e( 'Title', DOMAIN ) ?></th>
            <th><?php _e( 'Content', DOMAIN ) ?></th>
            <th><?php _e( 'Meta Title', DOMAIN ) ?></th>
            <th><?php _e( 'Meta Description', DOMAIN ) ?></th>
        </tr>

        <tr>
            <td></td>
            <td>
                <div class="replace-form"><?php render_replace_form( 'post_title', $oldKeyword ?? $keyword ) ?></div>
            </td>
            <td>
                <div class="replace-form"><?php render_replace_form( 'post_content', $oldKeyword ?? $keyword ) ?></div>
            </td>
            <td>
                <div class="replace-form"><?php render_replace_form( '_yoast_wpseo_title', $oldKeyword ?? $keyword ) ?></div>
            </td>
            <td>
                <div class="replace-form"><?php render_replace_form( '_yoast_wpseo_metadesc', $oldKeyword ?? $keyword ) ?></div>
            </td>
        </tr>
        <?php foreach ( $dataPosts as $post ) :
            $postContentShort = substr( $post['post_content'], 0, 20 ) . ( strlen( $post['post_content'] ) > 20 ? '...' : '' );
            ?>
            <tr>
                <td data-post-id="<?= $post['post_id'] ?>"><?= $post['post_id'] ?></td>
                <td><?= $post['post_title'] ?></td>
                <td><?= $postContentShort ?></td>
                <td><?= $post['meta_title'] ?></td>
                <td><?= $post['meta_desc'] ?></td>
            </tr>
        <?php endforeach; ?>

    </table>

<?php
endif;

function render_replace_form( $fieldKey, $oldKeyword ): void {
    echo '<input type="text" placeholder="' . __( 'keyword...', DOMAIN ) . '"><button class="replace-btn" type="button" data-old-keyword="' . $oldKeyword . '" data-field="' . $fieldKey . '">' . __( 'Replace', DOMAIN ) . '</button>';
}

?>