    </main>
    <footer class="footer bg-dark text-light mt-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <h3 class="h5 fw-bold mb-3"><?php echo SITE_NAME; ?></h3>
                    <p class="text-muted">Your trusted partner for amazing deals and offers.</p>
                </div>
                <div class="col-12 col-md-4">
                    <h3 class="h5 fw-bold mb-3">Quick Links</h3>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>" class="text-muted text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="https://thiyagi.com" class="text-muted text-decoration-none" target="_blank">Main Website</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-4">
                    <h3 class="h5 fw-bold mb-3">Connect With Us</h3>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-muted fs-4"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-muted fs-4"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-muted fs-4"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="text-muted mb-0">&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JavaScript CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <!-- Custom JavaScript -->
    <script src="<?php echo SITE_URL; ?>/assets/js/script.js"></script>
    
    <!-- Floating Social Share Widget -->
    <?php include 'floating-share.php'; ?>
    
    <!-- Service Worker Registration for Mobile Performance -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('<?php echo SITE_URL; ?>/sw.js')
                    .then(function(registration) {
                        console.log('ServiceWorker registration successful');
                    })
                    .catch(function(err) {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }
    </script>
</body>
</html>