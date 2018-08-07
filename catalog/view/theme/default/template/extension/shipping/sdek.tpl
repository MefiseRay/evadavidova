<div class="cdek_description">
<?php if($period) { ?>
	<?php echo $period.'<BR>'; ?>
<?php } ?>

<?php if($delivery_data) { ?>
	<?php echo $delivery_data.'<BR>'; ?>
<?php } ?>

<?php if($usePvz) { ?>
	<div class="sdek_pvz_info">
		<a id="selectCdekPvz" href="javascript:" onclick="cdekPvzClick('<?php echo $code; ?>', '<?php echo $pvzType; ?>');">Выбрать пункт выдачи</a>
		<?php
			$pvz_address = '';
			if(isset($selected_pvz[$code])) {
				$pvz_address = $selected_pvz[$code];
			}
		?>
		<span class="cdek_selectedPvzInfo" id="cdek_selectedPvzInfo_<?php echo $code; ?>"><?php echo $pvz_address; ?></span>
	</div>
	<input type="hidden" name="need_pvz[]" value="<?php echo $code; ?>">
<?php } else { ?>
	Доставка курьером
<?php } ?>
</div>