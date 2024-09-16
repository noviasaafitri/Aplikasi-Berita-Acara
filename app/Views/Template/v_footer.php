  <!-- Footer -->
  <footer class="sticky-footer bg-white">
      <div class="container my-auto">
          <div class="copyright text-center my-auto">
              <span>Copyright &copy; Novia Safitri 2024</span>
          </div>
      </div>
  </footer>
  <!-- End of Footer -->

  </div>
  <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Apakah Anda Ingin Keluar?</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                  </button>
              </div>
              <div class="modal-body">Pilih "Logout" di bawah ini jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
              <div class="modal-footer">
                  <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                  <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Logout</a>
              </div>
          </div>
      </div>
  </div>

  </script>
  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url() ?>/Assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url() ?>/Assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url() ?>/Assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url() ?>/Assets/js/sb-admin-2.min.js"></script>

  <!-- Page tabel responsive -->
  <script src="<?= base_url() ?>https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="<?= base_url() ?>https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
  <script>
      $(document).ready(function() {
          $('#example').DataTable();
      });
  </script>

  </body>

  </html>