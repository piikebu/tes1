</main>

<footer class="footer">
    <div class="footer-inner">
        <div>
            <h4>Universitas Sam Ratulangi</h4>
            <p>
                Jl. Kampus Unsrat, Bahu<br>
                Manado, Sulawesi Utara 95115<br>
                Telp: (0431) 863886
            </p>
        </div>
        <div>
            <h4>Tautan</h4>
            <p>
                <a href="<?= base_url() ?>">Beranda</a><br>
                <a href="<?= base_url('search') ?>">Pencarian Staff</a>
            </p>
        </div>
        <div>
            <h4>Tentang</h4>
            <p>
                Staf Akademik adalah portal direktori<br>
                dosen dan tenaga akademik<br>
                Universitas Sam Ratulangi.
            </p>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; <?= date('Y') ?> Universitas Sam Ratulangi. All rights reserved.
    </div>
</footer>

<script>
    (function() {
        const btn = document.getElementById('roleSwitcherBtn');
        const dropdown = document.getElementById('roleDropdown');

        if (!btn || !dropdown) return;

        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const isOpen = dropdown.classList.toggle('show');
            btn.setAttribute('aria-expanded', isOpen);
            btn.querySelector('.role-chevron').style.transform = isOpen ? 'rotate(180deg)' : '';
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('show');
                btn.setAttribute('aria-expanded', 'false');
                btn.querySelector('.role-chevron').style.transform = '';
            }
        });
    })();
</script>

</body>

</html>