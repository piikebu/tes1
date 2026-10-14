<div class="container">
    <div class="breadcrumb">
        <a href="<?= base_url() ?>">Beranda</a>
        <span class="sep">/</span>
        <strong><?= htmlspecialchars($faculty->name) ?></strong>
    </div>
</div>

<div class="container">
    <div class="section" style="padding-top:0">
        <h2 class="section-title"><?= htmlspecialchars($faculty->name) ?></h2>
        <p style="color:var(--gray-500);margin-top:-16px;margin-bottom:24px">
            <?php if ($current_keyword): ?>
                Ditemukan <?= count($staff_list) ?> hasil untuk "<strong><?= htmlspecialchars($current_keyword) ?></strong>"
                &mdash; <a href="<?= base_url('faculty/' . $faculty->slug) ?>">Tampilkan semua</a>
            <?php else: ?>
                <?= $total_staff ?> dosen terdaftar
            <?php endif; ?>
        </p>

        <!-- Search with live suggest -->
        <div class="fac-search-wrap" style="margin-bottom:24px">
            <form class="fac-search-form" action="<?= base_url('faculty/' . $faculty->slug) ?>" method="get">
                <i class="fas fa-search fac-search-icon"></i>
                <input type="text" name="q" id="facSearchInput"
                       class="fac-search-input"
                       placeholder="Cari dosen di fakultas ini..."
                       value="<?= htmlspecialchars($current_keyword) ?>"
                       autocomplete="off">
                <button type="submit" class="fac-search-btn">Cari</button>
            </form>
            <div id="facDropdown" class="fac-dropdown" hidden>
                <ul class="fac-dropdown-list"></ul>
            </div>
        </div>

        <script>
        (function () {
            const input      = document.getElementById('facSearchInput');
            const dropdown   = document.getElementById('facDropdown');
            const list       = dropdown.querySelector('.fac-dropdown-list');
            const suggestUrl = '<?= base_url('faculty/' . $faculty->slug . '/suggest') ?>';
            const staffBase  = '<?= base_url('staff/') ?>';
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

            function hide() { dropdown.hidden = true; active = -1; }

            function fetchSuggest(q) {
                fetch(suggestUrl + '?q=' + encodeURIComponent(q))
                    .then(r => r.json()).then(render).catch(hide);
            }

            input.addEventListener('input', function () {
                clearTimeout(timer);
                const q = this.value.trim();
                if (q.length < 2) { hide(); return; }
                timer = setTimeout(() => fetchSuggest(q), 260);
            });

            input.addEventListener('keydown', function (e) {
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
                    hide(); return;
                }
                items.forEach((el, i) => el.classList.toggle('fac-dd-item--active', i === active));
            });

            document.addEventListener('click', function (e) {
                if (!e.target.closest('.fac-search-wrap')) hide();
            });

            input.addEventListener('focus', function () {
                if (this.value.trim().length >= 2 && list.children.length) dropdown.hidden = false;
            });

            input.closest('form').addEventListener('submit', function (e) {
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
                        if (data.length) window.location.href = staffBase + data[0].slug;
                    })
                    .catch(() => {});
            });
        })();
        </script>

        <!-- Letter Filter -->
        <div class="letter-filter">
            <a href="<?= base_url('faculty/' . $faculty->slug) ?>"
               class="<?= !$current_letter ? 'active' : '' ?>">Semua</a>
            <?php foreach (range('A', 'Z') as $l): ?>
            <a href="<?= base_url('faculty/' . $faculty->slug . '?letter=' . $l) ?>"
               class="<?= $current_letter === $l ? 'active' : '' ?>"><?= $l ?></a>
            <?php endforeach; ?>
        </div>

        <!-- Staff List -->
        <?php if (empty($staff_list)): ?>
        <div class="empty-state">
            <i class="fas fa-users-slash"></i>
            <p>Tidak ada dosen ditemukan<?= $current_letter ? ' untuk huruf "' . $current_letter . '"' : '' ?>.</p>
        </div>
        <?php else: ?>
        <div class="staff-grid">
            <?php foreach ($staff_list as $s): ?>
            <div class="staff-card">
                <div class="staff-avatar">
                    <?= strtoupper(substr($s->name, 0, 1)) ?>
                </div>
                <div class="info">
                    <h3><a href="<?= base_url('staff/' . $s->slug) ?>"><?= htmlspecialchars($s->full_title_name ?: $s->name) ?></a></h3>
                    <p class="dept"><?= htmlspecialchars($s->department_name) ?></p>
                    <?php if ($s->expertise): ?>
                    <span class="expertise"><?= htmlspecialchars($s->expertise) ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
