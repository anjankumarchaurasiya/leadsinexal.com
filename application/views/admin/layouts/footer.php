<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
					<!-- BEGIN .main-footer -->
					<footer class="main-footer">
						<?php echo isset($settings['records'][0]['footer_text'])!=''?$settings['records'][0]['footer_text']:'&copy;'.date('Y'); ?>
					</footer>
					<!-- END: .main-footer -->
				</div>
				<!-- END: .app-main -->
			</div>
			<!-- END: .app-container -->
		</div>
		<!-- END: .app-wrap -->
		<script src="<?php echo asset_url(); ?>admin/plugins/unifyMenu/unifyMenu.js"></script>
		<script src="<?php echo asset_url(); ?>admin/plugins/onoffcanvas/onoffcanvas.js"></script>
		<script src="<?php echo asset_url(); ?>admin/js/moment.js"></script>
		<!-- Slimscroll JS -->
		<script src="<?php echo asset_url(); ?>admin/plugins/slimscroll/slimscroll.min.js"></script>
		<script src="<?php echo asset_url(); ?>admin/plugins/slimscroll/custom-scrollbar.js"></script>
		<script src="<?php echo asset_url(); ?>admin/js/nifty.min.js"></script>
		<!-- Gallery JS -->
		<script src="<?php echo asset_url(); ?>admin/plugins/gallery/baguetteBox.js" async></script>
		<script src="<?php echo asset_url(); ?>admin/plugins/gallery/plugins.js" async></script>
		<script src="<?php echo asset_url(); ?>admin/plugins/gallery/custom-gallery.js" async></script>
		<!-- Data Tables CSS -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/plugins/datatables/dataTables.bs4.css" />
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/plugins/datatables/dataTables.bs4-custom.css" />
		<!-- Data Tables JS -->
		<script src="<?php echo asset_url(); ?>admin/plugins/datatables/dataTables.min.js"></script>
		<script src="<?php echo asset_url(); ?>admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
		<!-- Datepickers css -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/plugins/datetimepicker/datetimepicker.css" />
		<script src="<?php echo asset_url(); ?>admin/plugins/datetimepicker/datetimepicker.full.js"></script>
		<!-- Common JS -->
		<script src="<?php echo asset_url(); ?>admin/js/common.js?v=1.1"></script>
      
		<script src="<?php echo asset_url(); ?>js/common.js"></script>
      <script src="<?php echo asset_url(); ?>/select2/select2.min.js"></script>
      <script type="text/javascript" src="<?= asset_url(); ?>toaster/notific.js"></script>
      <script type="text/javascript">
         $('.select2').select2();
         var baseurl = "<?= base_url(); ?>"
      </script>
	</body>
</html>