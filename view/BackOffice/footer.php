    <footer class="footer pt-3">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-sm text-muted text-lg-start">
              © <script>document.write(new Date().getFullYear())</script>,
              made with <i class="fa fa-heart"></i> by
              <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>
</main>

<!-- Fixed Plugin -->
<div class="fixed-plugin">
  <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
    <i class="fa fa-cog py-2"></i>
  </a>
  <!-- Configurator content here if needed -->
</div>

<!-- Core JS Files -->
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="assets/js/plugins/chartjs.min.js"></script>

<script>
  var win = navigator.platform.indexOf('Win') > -1;
  if (win && document.querySelector('#sidenav-scrollbar')) {
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), { damping: '0.5' });
  }
</script>
<!-- Bootstrap 5 JS Bundle (avec Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-q3fj8wP/d9vywgq6Z9erjRzCQXDpUe1koXSPo6e7i0rGUNShUMpOWcZH/5wCFYl8" crossorigin="anonymous"></script>

<script src="assets/js/soft-ui-dashboard.min.js?v=1.1.0"></script>
</body>
</html>
