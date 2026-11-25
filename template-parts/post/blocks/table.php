<?php
/** Data table and comparison matrix block. @package Velstadt */
$caption = get_field( 'caption' );
$layout = get_field( 'layout' );
$layout = in_array( $layout, array( 'standard', 'comparison', 'ioc', 'mitre' ), true ) ? $layout : 'standard';
$comparison = 'comparison' === $layout;
$row_headers = $comparison || (bool) get_field( 'row_headers' );
$columns = get_field( 'columns' ) ?: array();
$rows = get_field( 'rows' ) ?: array();
if ( ! $columns || ! $rows ) {
	velstadt_post_block_empty( $is_preview, __( 'Add table columns and rows.', 'velstadt' ) );
	return;
}
$id = velstadt_post_block_id( $block, 'table' );
$cell_classes = array();
foreach ( $columns as $column ) {
	$alignment = isset( $column['alignment'] ) && in_array( $column['alignment'], array( 'left', 'center', 'right' ), true ) ? $column['alignment'] : 'left';
	$cell_classes[] = 'post__table-cell is-align-' . $alignment . ( ! empty( $column['highlight'] ) ? ' is-highlighted' : '' );
}
?>
<figure id="<?php echo esc_attr( $id ); ?>" class="post__block post__table<?php echo 'standard' !== $layout ? ' post__table--' . esc_attr( $layout ) : ''; ?>" style="--table-columns: <?php echo (int) count( $columns ); ?>;">
	<?php if ( $caption ) : ?><figcaption id="<?php echo esc_attr( $id . '-caption' ); ?>" class="post__table-caption"><?php echo esc_html( $caption ); ?></figcaption><?php endif; ?>
	<div class="post__table-scroll" role="region" tabindex="0"<?php if ( $caption ) : ?> aria-labelledby="<?php echo esc_attr( $id . '-caption' ); ?>"<?php else : ?> aria-label="<?php echo esc_attr( $comparison ? __( 'Comparison table', 'velstadt' ) : __( 'Data table', 'velstadt' ) ); ?>"<?php endif; ?>>
		<table class="post__table-grid"<?php if ( $caption ) : ?> aria-labelledby="<?php echo esc_attr( $id . '-caption' ); ?>"<?php endif; ?>>
			<colgroup>
				<?php foreach ( $columns as $column ) : $width = ! empty( $column['width'] ) ? max( 1, min( 100, (float) $column['width'] ) ) : 0; ?>
					<col<?php if ( $width ) : ?> style="width: <?php echo esc_attr( (string) $width ); ?>%;"<?php endif; ?>>
				<?php endforeach; ?>
			</colgroup>
			<thead><tr>
				<?php foreach ( $columns as $index => $column ) : ?>
					<th scope="col" class="<?php echo esc_attr( $cell_classes[ $index ] ); ?>"><span class="post__table-heading"><?php echo esc_html( isset( $column['heading'] ) ? $column['heading'] : '' ); ?><?php if ( ! empty( $column['badge'] ) ) : ?><span class="post__table-badge"><?php echo esc_html( $column['badge'] ); ?></span><?php endif; ?></span></th>
				<?php endforeach; ?>
			</tr></thead>
			<tbody>
				<?php foreach ( $rows as $row ) : $cells = isset( $row['cells'] ) && is_array( $row['cells'] ) ? array_values( $row['cells'] ) : array(); ?>
					<tr>
						<?php foreach ( $columns as $index => $column ) : $cell_args = array( 'cell' => $cells[ $index ] ?? array(), 'layout' => $layout, 'column' => $index, 'is_preview' => ! empty( $is_preview ) ); ?>
							<?php if ( $row_headers && 0 === $index ) : ?>
								<th scope="row" class="<?php echo esc_attr( $cell_classes[ $index ] ); ?>"><?php get_template_part( 'template-parts/post/blocks/table-cell', null, $cell_args ); ?></th>
							<?php else : ?>
								<td class="<?php echo esc_attr( $cell_classes[ $index ] ); ?>"><?php get_template_part( 'template-parts/post/blocks/table-cell', null, $cell_args ); ?></td>
							<?php endif; ?>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</figure>
