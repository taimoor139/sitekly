<style>
	#template-list .imgcon {
		box-shadow: 0 1px 5px -1px rgba(40, 40, 40, 0.3), inset 0 0 0 1px rgba(83, 82, 82, 0.15);
		width: 32%;
		box-sizing: border-box;
		cursor: default;
		margin: .5%;
		padding: 20px;
		padding-bottom: 10px;
	}

	#template-list .img {
		background-size: cover;
		position: relative;
		background-position: top;
		cursor: default;
	}

	#template-list .overbox {
		display: flex;
		background-color: #fff;
		box-sizing: border-box;
		justify-content: space-between;
		padding-top: 2%;
	}

	#template-list .button {
		font-size: 16px;
		color: #d9d9d9;
		text-align: center;
		width: 49%;
		border: none;
		cursor: pointer;
		line-height: 2.5;
		background-color: #444143;
		border-radius: 3px;
	}

	#template-list .button:hover {
		background-color: #535052;
	}

	#template-list form {
		width: 49%;
	}

	#template-list form .button {
		width: 100%;
		background-color: #138DD4;
	}

	#template-list form .button:hover {
		background-color: #19A0EE;
	}

	@media (max-width:800px) {
		#template-list .imgcon {
			width: 49%;
		}
	}

	@media (max-width:500px) {
		#template-list .imgcon {
			width: 100%;
			margin: .5% 0;
		}
	}
</style>
<?= form_open(); ?>
<?= form_dropdown('templatecategoryselect', $categories_all, set_value('templatecategoryselect', 'all'), ['class' => 'form-control', 'id' => $key, 'onchange' => 'this.form.submit()']); ?>
<?= form_close(); ?>

<?php if ($list) : ?>
	<div class="gallery sitekly-edit template-gallery nofull" id="template-list">
		<div class="colover">
			<div class="colcon">
				<?php foreach ($list as $k => $template) : ?>

					<div <?= $k >= 6 ? 'style="display:none;"' : '' ?> class="imgcon">
						<div class="img" tsrc="<?= $template['FullThumb'] ?>" style="background-image: url('<?= $template['FullThumb'] ?>')">
						</div>
						<div class="overbox">
							<a class="button" href="<?= base_url($template['Link']) ?>">Preview</a>
							<form method="post" action="<?= namedRoute('dashboard/newsite') ?>">
								<?= csrf_field() ?>
								<input type="hidden" name="theme" value="<?= $template['id'] ?>" />
								<button type="submit" class="button"><?= lang('app.use-this') ?></button>
							</form>

						</div>

					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
	<script>
		(function() {
			function scrollFunction() {
				console.log('scroll');
				var colcon = $('#template-list .colcon');
				var visible = $(window).scrollTop() + $(window).height();
				var last = $('#template-list .imgcon:visible').last();

				if (visible > last.offset().top) {
					last.nextAll().slice(0, 3).show();
				}

			}
			window.onscroll = scrollFunction;
			window.addEventListener("pageshow", scrollFunction);

		})();
	</script>
<?php endif ?>