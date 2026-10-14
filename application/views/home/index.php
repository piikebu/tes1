<section class="hero">
    <h1>STAF <span>AKADEMIK</span></h1>
    <p>Portal Direktori Dosen Universitas Sam Ratulangi</p>

    <div class="hero-search-wrap" style="animation: 1s ease-out 0.35s both fadeInUp; position: relative; z-index: 10; margin-top: 36px;">
        <form class="hero-search" action="<?= base_url('search') ?>" method="get" id="heroSearchForm">
            <input type="text" name="q" id="heroSearchInput"
                placeholder="Cari nama dosen, NIP, atau keahlian..."
                class="hero-search-input" autocomplete="off">
            <button type="submit" class="hero-search-btn">
                <i class="fas fa-search"></i> Cari
            </button>
        </form>
        <div id="heroDropdown" class="fac-dropdown" hidden>
            <ul class="fac-dropdown-list"></ul>
        </div>
    </div>

    <script>
        (function() {
            const input = document.getElementById('heroSearchInput');
            const dropdown = document.getElementById('heroDropdown');
            const list = dropdown.querySelector('.fac-dropdown-list');
            const suggestUrl = '<?= base_url('search/suggest') ?>';
            const staffBase = '<?= base_url('staff/') ?>';
            let timer, active = -1;

            function initial(name) {
                return name.replace(/^(Prof\.|Dr\.|Ir\.|Drs\.|Dra\.)\s*/i, '').trim().charAt(0).toUpperCase();
            }

            function render(items) {
                if (!items.length) {
                    list.innerHTML = '<li class="fac-dd-empty">Tidak ada hasil ditemukan</li>';
                } else {
                    list.innerHTML = items.map((s, i) =>
                        `<li class="fac-dd-item" data-index="${i}">
                        <a href="${staffBase}${s.slug}" class="fac-dd-link">
                            <span class="fac-dd-avatar">${initial(s.name)}</span>
                            <span class="fac-dd-info">
                                <span class="fac-dd-name">${s.name}</span>
                                <span class="fac-dd-dept">${s.department_name}</span>
                            </span>
                            <i class="fas fa-arrow-right fac-dd-arrow"></i>
                        </a>
                    </li>`
                    ).join('');
                }
                active = -1;
                dropdown.hidden = false;
            }

            function hide() {
                dropdown.hidden = true;
                active = -1;
            }

            input.addEventListener('input', function() {
                clearTimeout(timer);
                const q = this.value.trim();
                if (q.length < 2) {
                    hide();
                    return;
                }
                timer = setTimeout(() => {
                    fetch(suggestUrl + '?q=' + encodeURIComponent(q))
                        .then(r => r.json()).then(render).catch(hide);
                }, 260);
            });

            input.addEventListener('keydown', function(e) {
                const items = list.querySelectorAll('.fac-dd-item');
                if (!items.length) return;
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    active = Math.min(active + 1, items.length - 1);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    active = Math.max(active - 1, 0);
                } else if (e.key === 'Enter' && active >= 0) {
                    e.preventDefault();
                    items[active].querySelector('a').click();
                    return;
                } else if (e.key === 'Escape') {
                    hide();
                    return;
                }
                items.forEach((el, i) => el.classList.toggle('fac-dd-item--active', i === active));
            });

            document.addEventListener('click', function(e) {
                if (!e.target.closest('.hero-search-wrap')) hide();
            });

            input.addEventListener('focus', function() {
                if (this.value.trim().length >= 2 && list.children.length) dropdown.hidden = false;
            });

            document.getElementById('heroSearchForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const items = list.querySelectorAll('.fac-dd-item');
                if (active >= 0 && items[active]) {
                    items[active].querySelector('a').click();
                    return;
                }
                if (items.length) {
                    items[0].querySelector('a').click();
                    return;
                }
                const q = input.value.trim();
                if (q.length < 2) return;
                fetch(suggestUrl + '?q=' + encodeURIComponent(q))
                    .then(r => r.json())
                    .then(data => {
                        if (data.length) {
                            window.location.href = staffBase + data[0].slug;
                        }
                    })
                    .catch(() => {});
            });
        })();
    </script>

    <div style="margin-top: 28px; animation: 1s ease-out 0.5s both fadeInUp; position: relative; z-index: 1;">
        <button id="toggleFaculty" class="btn-hero-glass">
            Jelajahi Fakultas <i class="fas fa-chevron-down" style="margin-left: 8px; transition: transform 0.4s ease;"></i>
        </button>
    </div>
</section>

<div class="container" id="facultyWrapper" style="display: none; opacity: 0; transition: opacity 0.5s ease;">
    <div class="section">
        <h2 class="section-title">Fakultas</h2>

        <div class="faculty-grid">
            <?php foreach ($faculties as $f): ?>
                <a href="<?= base_url('faculty/' . $f->slug) ?>" class="faculty-card">
                    <div class="icon">
                        <i class="fas <?= $f->icon ?: 'fa-building-columns' ?>"></i>
                    </div>
                    <div class="info">
                        <h3><?= htmlspecialchars($f->name) ?></h3>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('toggleFaculty');
        const wrapper = document.getElementById('facultyWrapper');
        const icon = btn.querySelector('i');

        btn.addEventListener('click', function() {
            if (wrapper.style.display === 'none') {
                wrapper.style.display = 'block';
                // Trigger reflow for transition
                void wrapper.offsetWidth;
                wrapper.style.opacity = '1';
                icon.style.transform = 'rotate(-180deg)';
                btn.style.boxShadow = '0 0 20px rgba(255,255,255,0.3)';

                setTimeout(() => {
                    wrapper.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 100);
            } else {
                wrapper.style.opacity = '0';
                icon.style.transform = 'rotate(0deg)';
                btn.style.boxShadow = 'none';

                setTimeout(() => {
                    wrapper.style.display = 'none';
                }, 500); // Matches CSS transition duration
            }
        });
    });
</script>