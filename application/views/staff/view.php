<div class="profile-header">
    <div class="profile-header-inner">
        <div class="profile-avatar">
            <?= strtoupper(substr($staff->name, 0, 1)) ?>
        </div>
        <div class="profile-info">
            <h1><?= htmlspecialchars($staff->full_title_name ?: $staff->name) ?></h1>
            <?php if ($staff->position): ?>
                <div class="position"><?= htmlspecialchars($staff->position) ?></div>
            <?php endif; ?>
            <div class="dept-faculty">
                <?= htmlspecialchars($staff->department_name) ?> &mdash; <?= htmlspecialchars($staff->faculty_name) ?>
            </div>

            <div class="profile-meta">
                <?php if ($staff->nip): ?>
                    <span class="meta-item"><i class="fas fa-id-card"></i> NIP: <?= htmlspecialchars($staff->nip) ?></span>
                <?php endif; ?>
                <?php if ($staff->email): ?>
                    <span class="meta-item"><i class="fas fa-envelope"></i> <?= htmlspecialchars($staff->email) ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Tabs -->
<div class="tabs-container">
    <div class="tabs">
        <a href="#profile"    class="tab-link active" data-tab="profile"><i class="fas fa-user"></i> Profil</a>
        <a href="#grants"     class="tab-link" data-tab="grants"><i class="fas fa-hand-holding-usd"></i> Grant &amp; Proyek</a>
        <a href="#research"   class="tab-link" data-tab="research"><i class="fas fa-flask"></i> Penelitian</a>
        <a href="#publications" class="tab-link" data-tab="publications"><i class="fas fa-file-alt"></i> Publikasi</a>
        <a href="#community"  class="tab-link" data-tab="community"><i class="fas fa-hands-helping"></i> Pengabdian</a>
    </div>
</div>

<div class="tab-content">

    <!-- ==================== PROFIL TAB ==================== -->
    <div id="profile" class="tab-pane active">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <h3 class="section-title">Biodata</h3>
            <?php if (is_admin_or_dosen()): ?>
            <button class="btn-tab-action btn-open-modal" data-modal="editProfilModal"><i class="fas fa-edit"></i> Edit Profil</button>
            <?php endif; ?>
        </div>
        <table class="info-table">
            <tr>
                <th>Nama Lengkap</th>
                <td><?= htmlspecialchars($staff->full_title_name ?: $staff->name) ?></td>
            </tr>
            <tr>
                <th>NIP</th>
                <td><?= htmlspecialchars($staff->nip ?: '-') ?></td>
            </tr>
            <tr>
                <th>NIDN</th>
                <td><?= htmlspecialchars($staff->nidn ?: '-') ?></td>
            </tr>
            <tr>
                <th>Jabatan Fungsional</th>
                <td><?= htmlspecialchars($staff->position ?: '-') ?></td>
            </tr>
            <tr>
                <th>Fakultas</th>
                <td><?= htmlspecialchars($staff->faculty_name) ?></td>
            </tr>
            <tr>
                <th>Program Studi</th>
                <td><?= htmlspecialchars($staff->department_name) ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= $staff->email ? '<a href="mailto:' . htmlspecialchars($staff->email) . '">' . htmlspecialchars($staff->email) . '</a>' : '-' ?></td>
            </tr>
            <tr>
                <th>Scopus ID</th>
                <td><?= $staff->scopus_id ? '<a href="https://www.scopus.com/authid/detail.uri?authorId=' . urlencode($staff->scopus_id) . '" target="_blank" rel="noopener">' . htmlspecialchars($staff->scopus_id) . ' <i class="fas fa-external-link-alt" style="font-size:.75em"></i></a>' : '-' ?></td>
            </tr>
            <tr>
                <th>SINTA ID</th>
                <td><?= $staff->sinta_id ? '<a href="https://sinta.kemdiktisaintek.go.id/authors/profile/' . urlencode($staff->sinta_id) . '" target="_blank" rel="noopener">' . htmlspecialchars($staff->sinta_id) . ' <i class="fas fa-external-link-alt" style="font-size:.75em"></i></a>' : '-' ?></td>
            </tr>
            <tr>
                <th>Google Scholar</th>
                <td><?= $staff->google_scholar ? '<a href="https://scholar.google.com/citations?user=' . urlencode($staff->google_scholar) . '" target="_blank" rel="noopener">Lihat Profil <i class="fas fa-external-link-alt" style="font-size:.75em"></i></a>' : '-' ?></td>
            </tr>
        </table>
    </div>

    <!-- ==================== GRANTS TAB ==================== -->
    <div id="grants" class="tab-pane">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <h3 class="section-title">Grant &amp; Proyek</h3>
            <?php if (is_admin_or_dosen() && !empty($grants)): ?>
            <button class="btn-tab-action btn-add btn-open-modal" data-modal="grantModal" data-mode="add"><i class="fas fa-plus"></i> Tambah Grant</button>
            <?php endif; ?>
        </div>

        <?php if (empty($grants)): ?>
            <div class="empty-state">
                <i class="fas fa-hand-holding-usd"></i>
                <p>Belum ada data grant &amp; proyek.</p>
                <?php if (is_admin_or_dosen()): ?>
                <button class="btn-tab-action btn-add btn-open-modal" style="margin-top: 24px;" data-modal="grantModal" data-mode="add"><i class="fas fa-plus"></i> Tambah Grant</button>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php foreach ($grants as $g): ?>
                <div class="data-card">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                        <h4><?= htmlspecialchars($g->title) ?></h4>
                        <div style="display:flex;gap:6px;flex-shrink:0;">
                        <button class="btn-tab-action btn-view btn-open-modal"
                            data-modal="grantDetailModal" data-mode="view"
                            data-title="<?= htmlspecialchars($g->title, ENT_QUOTES) ?>"
                            data-funder="<?= htmlspecialchars($g->funder, ENT_QUOTES) ?>"
                            data-role="<?= htmlspecialchars($g->role, ENT_QUOTES) ?>"
                            data-year-start="<?= $g->year_start ?>"
                            data-year-end="<?= $g->year_end ?>"
                            data-amount="<?= $g->amount ?>"
                            data-description="<?= htmlspecialchars($g->description, ENT_QUOTES) ?>"
                            data-document="<?= htmlspecialchars($g->document_path ?? '', ENT_QUOTES) ?>"
                        ><i class="fas fa-eye"></i></button>
                        <?php if (is_admin_or_dosen()): ?>
                        <button class="btn-tab-action btn-edit btn-open-modal"
                            data-modal="grantModal" data-mode="edit"
                            data-id="<?= $g->id ?>"
                            data-title="<?= htmlspecialchars($g->title) ?>"
                            data-funder="<?= htmlspecialchars($g->funder) ?>"
                            data-role="<?= htmlspecialchars($g->role) ?>"
                            data-year-start="<?= $g->year_start ?>"
                            data-year-end="<?= $g->year_end ?>"
                            data-amount="<?= $g->amount ?>"
                            data-description="<?= htmlspecialchars($g->description) ?>"
                        ><i class="fas fa-edit"></i></button>
                        <button class="btn-tab-action btn-danger btn-confirm-delete"
                            data-action="<?= site_url('staff/delete_grant/' . $staff->id) ?>"
                            data-id-name="grant_id" data-id="<?= $g->id ?>"
                        ><i class="fas fa-trash"></i></button>
                        <?php endif; ?>
                        </div>
                    </div>
                    <div class="meta">
                        <i class="fas fa-building"></i> <?= htmlspecialchars($g->funder ?: '-') ?>
                        &nbsp;&bull;&nbsp;
                        <i class="fas fa-calendar"></i> <?= $g->year_start ?><?= $g->year_end ? ' - ' . $g->year_end : '' ?>
                        &nbsp;&bull;&nbsp;
                        <span class="badge <?= $g->role === 'Ketua' ? 'badge-ketua' : 'badge-anggota' ?>"><?= htmlspecialchars($g->role ?: '-') ?></span>
                    </div>
                    <?php if ($g->amount): ?>
                        <div class="meta"><i class="fas fa-money-bill"></i> Rp <?= number_format($g->amount, 0, ',', '.') ?></div>
                    <?php endif; ?>
                    <?php if ($g->description): ?>
                        <p><?= htmlspecialchars($g->description) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($g->document_path)): ?>
                        <div class="meta" style="margin-top:8px">
                            <i class="fas fa-file-pdf" style="color:#e53e3e"></i>
                            <a href="<?= base_url($g->document_path) ?>" target="_blank">Lihat Dokumen</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- ==================== PENELITIAN TAB ==================== -->
    <div id="research" class="tab-pane">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <h3 class="section-title">Penelitian</h3>
            <?php if (is_admin_or_dosen() && !empty($research)): ?>
            <button class="btn-tab-action btn-add btn-open-modal" data-modal="researchModal" data-mode="add"><i class="fas fa-plus"></i> Tambah Penelitian</button>
            <?php endif; ?>
        </div>

        <?php if (empty($research)): ?>
            <div class="empty-state">
                <i class="fas fa-flask"></i>
                <p>Belum ada data penelitian.</p>
                <?php if (is_admin_or_dosen()): ?>
                <button class="btn-tab-action btn-add btn-open-modal" style="margin-top: 24px;" data-modal="researchModal" data-mode="add"><i class="fas fa-plus"></i> Tambah Penelitian</button>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php foreach ($research as $r): ?>
                <div class="data-card">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                        <h4><?= htmlspecialchars($r->title) ?></h4>
                        <div style="display:flex;gap:6px;flex-shrink:0;">
                        <button class="btn-tab-action btn-view btn-open-modal"
                            data-modal="researchDetailModal" data-mode="view"
                            data-title="<?= htmlspecialchars($r->title, ENT_QUOTES) ?>"
                            data-authors="<?= htmlspecialchars($r->authors, ENT_QUOTES) ?>"
                            data-date="<?= $r->research_date ?>"
                            data-abstract="<?= htmlspecialchars($r->abstract, ENT_QUOTES) ?>"
                            data-gok="<?= htmlspecialchars($r->group_of_knowledge, ENT_QUOTES) ?>"
                            data-lang="<?= htmlspecialchars($r->original_language, ENT_QUOTES) ?>"
                            data-level="<?= htmlspecialchars($r->level, ENT_QUOTES) ?>"
                            data-status="<?= htmlspecialchars($r->status, ENT_QUOTES) ?>"
                            data-document="<?= htmlspecialchars($r->document_path ?? '', ENT_QUOTES) ?>"
                        ><i class="fas fa-eye"></i></button>
                        <?php if (is_admin_or_dosen()): ?>
                        <button class="btn-tab-action btn-edit btn-open-modal"
                            data-modal="researchModal" data-mode="edit"
                            data-id="<?= $r->id ?>"
                            data-title="<?= htmlspecialchars($r->title) ?>"
                            data-authors="<?= htmlspecialchars($r->authors) ?>"
                            data-date="<?= $r->research_date ?>"
                            data-abstract="<?= htmlspecialchars($r->abstract) ?>"
                            data-gok="<?= htmlspecialchars($r->group_of_knowledge) ?>"
                            data-lang="<?= htmlspecialchars($r->original_language) ?>"
                            data-level="<?= htmlspecialchars($r->level) ?>"
                            data-status="<?= htmlspecialchars($r->status) ?>"
                        ><i class="fas fa-edit"></i></button>
                        <button class="btn-tab-action btn-danger btn-confirm-delete"
                            data-action="<?= site_url('staff/delete_research/' . $staff->id) ?>"
                            data-id-name="research_id" data-id="<?= $r->id ?>"
                        ><i class="fas fa-trash"></i></button>
                        <?php endif; ?>
                        </div>
                    </div>
                    <div class="meta">
                        <?php if ($r->authors): ?>
                            <i class="fas fa-users"></i> <?= htmlspecialchars($r->authors) ?>
                            &nbsp;&bull;&nbsp;
                        <?php endif; ?>
                        <?php if ($r->research_date): ?>
                            <i class="fas fa-calendar"></i> <?= date('d M Y', strtotime($r->research_date)) ?>
                            &nbsp;&bull;&nbsp;
                        <?php endif; ?>
                        <?php if ($r->level): ?>
                            <span class="badge badge-journal"><?= htmlspecialchars($r->level) ?></span>
                        <?php endif; ?>
                        <?php if ($r->status): ?>
                            &nbsp;<span class="badge badge-anggota"><?= htmlspecialchars($r->status) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if ($r->group_of_knowledge): ?>
                        <div class="meta"><i class="fas fa-layer-group"></i> <?= htmlspecialchars($r->group_of_knowledge) ?></div>
                    <?php endif; ?>
                    <?php if ($r->abstract): ?>
                        <p class="abstract-text"><?= htmlspecialchars($r->abstract) ?></p>
                    <?php endif; ?>
                    <?php if ($r->original_language): ?>
                        <div class="meta" style="font-size:12px;color:var(--gray-500)"><i class="fas fa-language"></i> <?= htmlspecialchars($r->original_language) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($r->document_path)): ?>
                        <div class="meta" style="margin-top:8px">
                            <i class="fas fa-file-pdf" style="color:#e53e3e"></i>
                            <a href="<?= base_url($r->document_path) ?>" target="_blank">Lihat Dokumen</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- ==================== PUBLIKASI TAB ==================== -->
    <div id="publications" class="tab-pane">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <h3 class="section-title">Publikasi</h3>
            <?php if (is_admin_or_dosen() && !empty($publications)): ?>
            <button class="btn-tab-action btn-add btn-open-modal" data-modal="publikasiModal" data-mode="add"><i class="fas fa-plus"></i> Tambah Publikasi</button>
            <?php endif; ?>
        </div>

        <?php if (empty($publications)): ?>
            <div class="empty-state">
                <i class="fas fa-file-alt"></i>
                <p>Belum ada data publikasi.</p>
                <?php if (is_admin_or_dosen()): ?>
                <button class="btn-tab-action btn-add btn-open-modal" style="margin-top: 24px;" data-modal="publikasiModal" data-mode="add"><i class="fas fa-plus"></i> Tambah Publikasi</button>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php foreach ($publications as $p): ?>
                <div class="data-card">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                        <div>
                            <span class="badge badge-<?= $p->type ?>"><?= ucfirst(str_replace('_', ' ', $p->type)) ?></span>
                            <?php if (!empty($p->level)): ?>
                                <span class="badge badge-journal" style="margin-left:4px"><?= htmlspecialchars($p->level) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($p->status)): ?>
                                <span class="badge badge-anggota" style="margin-left:4px"><?= htmlspecialchars($p->status) ?></span>
                            <?php endif; ?>
                        </div>
                        <div style="display:flex;gap:6px;flex-shrink:0;">
                        <button class="btn-tab-action btn-view btn-open-modal"
                            data-modal="pubDetailModal" data-mode="view"
                            data-title="<?= htmlspecialchars($p->title, ENT_QUOTES) ?>"
                            data-type="<?= htmlspecialchars($p->type, ENT_QUOTES) ?>"
                            data-journal="<?= htmlspecialchars($p->journal_name, ENT_QUOTES) ?>"
                            data-year="<?= $p->year ?>"
                            data-volume="<?= htmlspecialchars($p->volume, ENT_QUOTES) ?>"
                            data-pages="<?= htmlspecialchars($p->pages, ENT_QUOTES) ?>"
                            data-doi="<?= htmlspecialchars($p->doi, ENT_QUOTES) ?>"
                            data-url="<?= htmlspecialchars($p->url, ENT_QUOTES) ?>"
                            data-authors="<?= htmlspecialchars($p->authors, ENT_QUOTES) ?>"
                            data-abstract="<?= htmlspecialchars($p->abstract, ENT_QUOTES) ?>"
                            data-gok="<?= htmlspecialchars($p->group_of_knowledge, ENT_QUOTES) ?>"
                            data-lang="<?= htmlspecialchars($p->original_language, ENT_QUOTES) ?>"
                            data-level="<?= htmlspecialchars($p->level, ENT_QUOTES) ?>"
                            data-status="<?= htmlspecialchars($p->status, ENT_QUOTES) ?>"
                            data-document="<?= htmlspecialchars($p->document_path ?? '', ENT_QUOTES) ?>"
                        ><i class="fas fa-eye"></i></button>
                        <?php if (is_admin_or_dosen()): ?>
                        <button class="btn-tab-action btn-edit btn-open-modal"
                            data-modal="publikasiModal" data-mode="edit"
                            data-id="<?= $p->id ?>"
                            data-title="<?= htmlspecialchars($p->title) ?>"
                            data-type="<?= htmlspecialchars($p->type) ?>"
                            data-journal="<?= htmlspecialchars($p->journal_name) ?>"
                            data-year="<?= $p->year ?>"
                            data-volume="<?= htmlspecialchars($p->volume) ?>"
                            data-pages="<?= htmlspecialchars($p->pages) ?>"
                            data-doi="<?= htmlspecialchars($p->doi) ?>"
                            data-url="<?= htmlspecialchars($p->url) ?>"
                            data-authors="<?= htmlspecialchars($p->authors) ?>"
                            data-abstract="<?= htmlspecialchars($p->abstract) ?>"
                            data-gok="<?= htmlspecialchars($p->group_of_knowledge) ?>"
                            data-lang="<?= htmlspecialchars($p->original_language) ?>"
                            data-level="<?= htmlspecialchars($p->level) ?>"
                            data-status="<?= htmlspecialchars($p->status) ?>"
                        ><i class="fas fa-edit"></i></button>
                        <button class="btn-tab-action btn-danger btn-confirm-delete"
                            data-action="<?= site_url('staff/delete_publication/' . $staff->id) ?>"
                            data-id-name="pub_id" data-id="<?= $p->id ?>"
                        ><i class="fas fa-trash"></i></button>
                        <?php endif; ?>
                        </div>
                    </div>
                    <h4 style="margin-top:8px"><?= htmlspecialchars($p->title) ?></h4>
                    <div class="meta">
                        <?php if ($p->journal_name): ?>
                            <i class="fas fa-book-open"></i> <?= htmlspecialchars($p->journal_name) ?>
                            &nbsp;&bull;&nbsp;
                        <?php endif; ?>
                        <i class="fas fa-calendar"></i> <?= $p->year ?>
                        <?php if ($p->volume): ?>
                            &nbsp;&bull;&nbsp; Vol. <?= htmlspecialchars($p->volume) ?>
                        <?php endif; ?>
                        <?php if ($p->pages): ?>
                            , pp. <?= htmlspecialchars($p->pages) ?>
                        <?php endif; ?>
                    </div>
                    <?php if ($p->authors): ?>
                        <div class="meta"><i class="fas fa-users"></i> <?= htmlspecialchars($p->authors) ?></div>
                    <?php endif; ?>
                    <?php if ($p->doi): ?>
                        <div class="meta"><i class="fas fa-link"></i> DOI: <a href="https://doi.org/<?= htmlspecialchars($p->doi) ?>" target="_blank"><?= htmlspecialchars($p->doi) ?></a></div>
                    <?php endif; ?>
                    <?php if (!empty($p->group_of_knowledge)): ?>
                        <div class="meta"><i class="fas fa-layer-group"></i> <?= htmlspecialchars($p->group_of_knowledge) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($p->abstract)): ?>
                        <p class="abstract-text"><?= htmlspecialchars($p->abstract) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($p->document_path)): ?>
                        <div class="meta" style="margin-top:8px">
                            <i class="fas fa-file-pdf" style="color:#e53e3e"></i>
                            <a href="<?= base_url($p->document_path) ?>" target="_blank">Lihat Dokumen</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- ==================== PENGABDIAN TAB ==================== -->
    <div id="community" class="tab-pane">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <h3 class="section-title">Pengabdian Masyarakat</h3>
            <?php if (is_admin_or_dosen() && !empty($community_service)): ?>
            <button class="btn-tab-action btn-add btn-open-modal" data-modal="communityModal" data-mode="add"><i class="fas fa-plus"></i> Tambah Pengabdian</button>
            <?php endif; ?>
        </div>

        <?php if (empty($community_service)): ?>
            <div class="empty-state">
                <i class="fas fa-hands-helping"></i>
                <p>Belum ada data pengabdian masyarakat.</p>
                <?php if (is_admin_or_dosen()): ?>
                <button class="btn-tab-action btn-add btn-open-modal" style="margin-top: 24px;" data-modal="communityModal" data-mode="add"><i class="fas fa-plus"></i> Tambah Pengabdian</button>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php foreach ($community_service as $cs): ?>
                <div class="data-card">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                        <h4><?= htmlspecialchars($cs->title) ?></h4>
                        <div style="display:flex;gap:6px;flex-shrink:0;">
                        <button class="btn-tab-action btn-view btn-open-modal"
                            data-modal="communityDetailModal" data-mode="view"
                            data-title="<?= htmlspecialchars($cs->title, ENT_QUOTES) ?>"
                            data-authors="<?= htmlspecialchars($cs->authors, ENT_QUOTES) ?>"
                            data-date="<?= $cs->service_date ?>"
                            data-abstract="<?= htmlspecialchars($cs->abstract, ENT_QUOTES) ?>"
                            data-gok="<?= htmlspecialchars($cs->group_of_knowledge, ENT_QUOTES) ?>"
                            data-lang="<?= htmlspecialchars($cs->original_language, ENT_QUOTES) ?>"
                            data-level="<?= htmlspecialchars($cs->level, ENT_QUOTES) ?>"
                            data-status="<?= htmlspecialchars($cs->status, ENT_QUOTES) ?>"
                            data-document="<?= htmlspecialchars($cs->document_path ?? '', ENT_QUOTES) ?>"
                        ><i class="fas fa-eye"></i></button>
                        <?php if (is_admin_or_dosen()): ?>
                        <button class="btn-tab-action btn-edit btn-open-modal"
                            data-modal="communityModal" data-mode="edit"
                            data-id="<?= $cs->id ?>"
                            data-title="<?= htmlspecialchars($cs->title) ?>"
                            data-authors="<?= htmlspecialchars($cs->authors) ?>"
                            data-date="<?= $cs->service_date ?>"
                            data-abstract="<?= htmlspecialchars($cs->abstract) ?>"
                            data-gok="<?= htmlspecialchars($cs->group_of_knowledge) ?>"
                            data-lang="<?= htmlspecialchars($cs->original_language) ?>"
                            data-level="<?= htmlspecialchars($cs->level) ?>"
                            data-status="<?= htmlspecialchars($cs->status) ?>"
                        ><i class="fas fa-edit"></i></button>
                        <button class="btn-tab-action btn-danger btn-confirm-delete"
                            data-action="<?= site_url('staff/delete_community_service/' . $staff->id) ?>"
                            data-id-name="cs_id" data-id="<?= $cs->id ?>"
                        ><i class="fas fa-trash"></i></button>
                        <?php endif; ?>
                        </div>
                    </div>
                    <div class="meta">
                        <?php if ($cs->authors): ?>
                            <i class="fas fa-users"></i> <?= htmlspecialchars($cs->authors) ?>
                            &nbsp;&bull;&nbsp;
                        <?php endif; ?>
                        <?php if ($cs->service_date): ?>
                            <i class="fas fa-calendar"></i> <?= date('d M Y', strtotime($cs->service_date)) ?>
                            &nbsp;&bull;&nbsp;
                        <?php endif; ?>
                        <?php if ($cs->level): ?>
                            <span class="badge badge-journal"><?= htmlspecialchars($cs->level) ?></span>
                        <?php endif; ?>
                        <?php if ($cs->status): ?>
                            &nbsp;<span class="badge badge-anggota"><?= htmlspecialchars($cs->status) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if ($cs->group_of_knowledge): ?>
                        <div class="meta"><i class="fas fa-layer-group"></i> <?= htmlspecialchars($cs->group_of_knowledge) ?></div>
                    <?php endif; ?>
                    <?php if ($cs->abstract): ?>
                        <p class="abstract-text"><?= htmlspecialchars($cs->abstract) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($cs->document_path)): ?>
                        <div class="meta" style="margin-top:8px">
                            <i class="fas fa-file-pdf" style="color:#e53e3e"></i>
                            <a href="<?= base_url($cs->document_path) ?>" target="_blank">Lihat Dokumen</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>

<!-- ==================== MODAL: GRANT DETAIL ==================== -->
<div id="grantDetailModal" class="modal-overlay">
    <div class="modal-container" style="max-width: 600px;">
        <div class="modal-header">
            <h3><i class="fas fa-hand-holding-usd" style="color:var(--accent,#e8a817);margin-right:8px"></i>Detail Grant &amp; Proyek</h3>
            <button type="button" class="modal-close" aria-label="Tutup">&times;</button>
        </div>
        <div class="modal-body">
            <div class="detail-section">
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-file-alt"></i> Judul</span>
                    <span class="detail-value" id="dg_title"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-building"></i> Sumber Dana</span>
                    <span class="detail-value" id="dg_funder"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-user-tag"></i> Peran</span>
                    <span class="detail-value" id="dg_role"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-calendar"></i> Tahun</span>
                    <span class="detail-value" id="dg_year"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-money-bill"></i> Dana</span>
                    <span class="detail-value" id="dg_amount"></span>
                </div>
            </div>
            <div class="detail-section" id="dg_desc_section">
                <div class="detail-row" style="flex-direction:column;gap:6px;">
                    <span class="detail-label"><i class="fas fa-align-left"></i> Deskripsi</span>
                    <div class="detail-abstract" id="dg_description"></div>
                </div>
            </div>
            <div id="dg_doc_section">
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-paperclip"></i> Dokumen</span>
                    <span class="detail-value" id="dg_document"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== MODAL: PENELITIAN DETAIL ==================== -->
<div id="researchDetailModal" class="modal-overlay">
    <div class="modal-container" style="max-width: 640px;">
        <div class="modal-header">
            <h3><i class="fas fa-flask" style="color:var(--accent,#e8a817);margin-right:8px"></i>Detail Penelitian</h3>
            <button type="button" class="modal-close" aria-label="Tutup">&times;</button>
        </div>
        <div class="modal-body">
            <div class="detail-section">
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-file-alt"></i> Judul</span>
                    <span class="detail-value" id="dr_title"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-users"></i> Peneliti</span>
                    <span class="detail-value" id="dr_authors"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-calendar"></i> Tanggal</span>
                    <span class="detail-value" id="dr_date"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-globe"></i> Level</span>
                    <span class="detail-value" id="dr_level"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-check-circle"></i> Status</span>
                    <span class="detail-value" id="dr_status"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-layer-group"></i> Bidang Ilmu</span>
                    <span class="detail-value" id="dr_gok"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-language"></i> Bahasa</span>
                    <span class="detail-value" id="dr_lang"></span>
                </div>
            </div>
            <div class="detail-section" id="dr_abstract_section">
                <div class="detail-row" style="flex-direction:column;gap:6px;">
                    <span class="detail-label"><i class="fas fa-align-left"></i> Abstrak</span>
                    <div class="detail-abstract" id="dr_abstract"></div>
                </div>
            </div>
            <div id="dr_doc_section">
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-paperclip"></i> Dokumen</span>
                    <span class="detail-value" id="dr_document"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== MODAL: PUBLIKASI DETAIL ==================== -->
<div id="pubDetailModal" class="modal-overlay">
    <div class="modal-container" style="max-width: 680px;">
        <div class="modal-header">
            <h3><i class="fas fa-file-alt" style="color:var(--accent,#e8a817);margin-right:8px"></i>Detail Publikasi</h3>
            <button type="button" class="modal-close" aria-label="Tutup">&times;</button>
        </div>
        <div class="modal-body">
            <div class="detail-section">
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-file-alt"></i> Judul</span>
                    <span class="detail-value" id="dp_title"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-users"></i> Penulis</span>
                    <span class="detail-value" id="dp_authors"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-tag"></i> Tipe</span>
                    <span class="detail-value" id="dp_type"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-book-open"></i> Jurnal / Prosiding</span>
                    <span class="detail-value" id="dp_journal"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-calendar"></i> Tahun</span>
                    <span class="detail-value" id="dp_year"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-list-ol"></i> Volume / Halaman</span>
                    <span class="detail-value" id="dp_vol_pages"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-link"></i> DOI</span>
                    <span class="detail-value" id="dp_doi"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-external-link-alt"></i> URL</span>
                    <span class="detail-value" id="dp_url"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-globe"></i> Level</span>
                    <span class="detail-value" id="dp_level"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-check-circle"></i> Status</span>
                    <span class="detail-value" id="dp_status"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-layer-group"></i> Bidang Ilmu</span>
                    <span class="detail-value" id="dp_gok"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-language"></i> Bahasa</span>
                    <span class="detail-value" id="dp_lang"></span>
                </div>
            </div>
            <div class="detail-section" id="dp_abstract_section">
                <div class="detail-row" style="flex-direction:column;gap:6px;">
                    <span class="detail-label"><i class="fas fa-align-left"></i> Abstrak</span>
                    <div class="detail-abstract" id="dp_abstract"></div>
                </div>
            </div>
            <div id="dp_doc_section">
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-paperclip"></i> Dokumen</span>
                    <span class="detail-value" id="dp_document"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== MODAL: PENGABDIAN DETAIL ==================== -->
<div id="communityDetailModal" class="modal-overlay">
    <div class="modal-container" style="max-width: 640px;">
        <div class="modal-header">
            <h3><i class="fas fa-hands-helping" style="color:var(--accent,#e8a817);margin-right:8px"></i>Detail Pengabdian Masyarakat</h3>
            <button type="button" class="modal-close" aria-label="Tutup">&times;</button>
        </div>
        <div class="modal-body">
            <div class="detail-section">
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-file-alt"></i> Judul</span>
                    <span class="detail-value" id="dc_title"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-users"></i> Tim</span>
                    <span class="detail-value" id="dc_authors"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-calendar"></i> Tanggal</span>
                    <span class="detail-value" id="dc_date"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-globe"></i> Level</span>
                    <span class="detail-value" id="dc_level"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-check-circle"></i> Status</span>
                    <span class="detail-value" id="dc_status"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-layer-group"></i> Bidang Ilmu</span>
                    <span class="detail-value" id="dc_gok"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-language"></i> Bahasa</span>
                    <span class="detail-value" id="dc_lang"></span>
                </div>
            </div>
            <div class="detail-section" id="dc_abstract_section">
                <div class="detail-row" style="flex-direction:column;gap:6px;">
                    <span class="detail-label"><i class="fas fa-align-left"></i> Abstrak / Deskripsi</span>
                    <div class="detail-abstract" id="dc_abstract"></div>
                </div>
            </div>
            <div id="dc_doc_section">
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-paperclip"></i> Dokumen</span>
                    <span class="detail-value" id="dc_document"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== MODAL: EDIT PROFIL ==================== -->
<div id="editProfilModal" class="modal-overlay">
    <div class="modal-container" style="max-width: 620px;">
        <div class="modal-header">
            <h3>Edit Profil Dosen</h3>
            <button type="button" class="modal-close" aria-label="Tutup">&times;</button>
        </div>
        <div class="modal-body">
            <form action="<?= site_url('staff/update_profile/' . $staff->id) ?>" method="POST" class="upload-form">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 20px;">

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Nama Lengkap (dengan gelar)</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($staff->full_title_name ?: $staff->name) ?>" readonly disabled style="background:var(--gray-100);cursor:not-allowed;">
                        <small style="color:var(--gray-500)">Nama dikelola oleh sistem. Hubungi admin untuk perubahan nama.</small>
                    </div>

                    <div class="form-group">
                        <label for="edit_nip">NIP</label>
                        <input type="text" id="edit_nip" name="nip" value="<?= htmlspecialchars($staff->nip) ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="edit_nidn">NIDN</label>
                        <input type="text" id="edit_nidn" name="nidn" value="<?= htmlspecialchars($staff->nidn) ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="edit_position">Jabatan Fungsional</label>
                        <select id="edit_position" name="position" class="form-control">
                            <option value="">Pilih Jabatan</option>
                            <?php foreach (['Asisten Ahli','Lektor','Lektor Kepala','Guru Besar'] as $pos): ?>
                            <option value="<?= $pos ?>" <?= $staff->position == $pos ? 'selected' : '' ?>><?= $pos === 'Guru Besar' ? 'Guru Besar (Profesor)' : $pos ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" id="edit_email" name="email" value="<?= htmlspecialchars($staff->email) ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="edit_scopus_id">Scopus ID</label>
                        <input type="text" id="edit_scopus_id" name="scopus_id" value="<?= htmlspecialchars($staff->scopus_id ?? '') ?>" class="form-control" placeholder="Contoh: 57203456789">
                    </div>

                    <div class="form-group">
                        <label for="edit_sinta_id">SINTA ID</label>
                        <input type="text" id="edit_sinta_id" name="sinta_id" value="<?= htmlspecialchars($staff->sinta_id ?? '') ?>" class="form-control" placeholder="Contoh: 6723456">
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label for="edit_google_scholar">Google Scholar ID</label>
                        <input type="text" id="edit_google_scholar" name="google_scholar" value="<?= htmlspecialchars($staff->google_scholar ?? '') ?>" class="form-control" placeholder="Contoh: AbCdEfGhIjKlMnO">
                    </div>

                </div>

                <div class="form-actions" style="margin-top: 12px; border-top: 1px solid var(--gray-200); padding-top: 20px;">
                    <button type="button" class="btn-tab-action modal-cancel">Batal</button>
                    <button type="submit" class="btn-tab-action btn-edit"><i class="fas fa-save"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==================== MODAL: GRANT ==================== -->
<div id="grantModal" class="modal-overlay">
    <div class="modal-container" style="max-width: 620px;">
        <div class="modal-header">
            <h3 class="modal-title-text">Tambah Grant &amp; Proyek</h3>
            <button type="button" class="modal-close" aria-label="Tutup">&times;</button>
        </div>
        <div class="modal-body">
            <form action="<?= site_url('staff/save_grant/' . $staff->id) ?>" method="POST" enctype="multipart/form-data" class="upload-form">
                <input type="hidden" name="grant_id" id="grant_id_field" value="">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 20px;">

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Judul Penelitian / Proyek <span style="color:red">*</span></label>
                        <input type="text" name="title" id="grant_title" class="form-control" required>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Sumber Dana / Pemberi Grant</label>
                        <input type="text" name="funder" id="grant_funder" class="form-control" placeholder="Contoh: Kemdikbud, LPDP, dst.">
                    </div>

                    <div class="form-group">
                        <label>Peran</label>
                        <select name="role" id="grant_role" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Ketua">Ketua</option>
                            <option value="Anggota">Anggota</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Dana (Rp)</label>
                        <input type="number" name="amount" id="grant_amount" class="form-control" placeholder="0">
                    </div>

                    <div class="form-group">
                        <label>Tahun Mulai</label>
                        <input type="number" name="year_start" id="grant_year_start" class="form-control" min="2000" max="2100" placeholder="2024">
                    </div>

                    <div class="form-group">
                        <label>Tahun Selesai</label>
                        <input type="number" name="year_end" id="grant_year_end" class="form-control" min="2000" max="2100" placeholder="2026">
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Deskripsi</label>
                        <textarea name="description" id="grant_description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Dokumen <small style="color:var(--gray-500)">(PDF/DOC/DOCX, maks. 10MB)</small></label>
                        <input type="file" name="document" id="grant_document" class="form-control" accept=".pdf,.doc,.docx">
                    </div>
                </div>
                <div class="form-actions" style="margin-top:12px;border-top:1px solid var(--gray-200);padding-top:20px;">
                    <button type="button" class="btn-tab-action modal-cancel">Batal</button>
                    <button type="submit" class="btn-tab-action btn-add"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==================== MODAL: PENELITIAN ==================== -->
<div id="researchModal" class="modal-overlay">
    <div class="modal-container" style="max-width: 680px;">
        <div class="modal-header">
            <h3 class="modal-title-text">Tambah Penelitian</h3>
            <button type="button" class="modal-close" aria-label="Tutup">&times;</button>
        </div>
        <div class="modal-body">
            <form action="<?= site_url('staff/save_research/' . $staff->id) ?>" method="POST" enctype="multipart/form-data" class="upload-form">
                <input type="hidden" name="research_id" id="research_id_field" value="">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 20px;">

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Judul <span style="color:red">*</span></label>
                        <input type="text" name="title" id="research_title" class="form-control" required>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Penulis / Tim Peneliti</label>
                        <input type="text" name="authors" id="research_authors" class="form-control" placeholder="Nama1, Nama2, ...">
                    </div>

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="research_date" id="research_date" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Bahasa Asli</label>
                        <input type="text" name="original_language" id="research_lang" class="form-control" placeholder="Indonesia / English">
                    </div>

                    <div class="form-group">
                        <label>Level</label>
                        <select name="level" id="research_level" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Lokal">Lokal</option>
                            <option value="Nasional">Nasional</option>
                            <option value="Internasional">Internasional</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="research_status" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Ongoing">Ongoing</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Bidang Ilmu (Group of Knowledge)</label>
                        <input type="text" name="group_of_knowledge" id="research_gok" class="form-control" placeholder="Contoh: Ilmu Komputer, Kedokteran, dst.">
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Abstrak</label>
                        <textarea name="abstract" id="research_abstract" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Dokumen <small style="color:var(--gray-500)">(PDF/DOC/DOCX, maks. 10MB)</small></label>
                        <input type="file" name="document" id="research_document" class="form-control" accept=".pdf,.doc,.docx">
                    </div>
                </div>
                <div class="form-actions" style="margin-top:12px;border-top:1px solid var(--gray-200);padding-top:20px;">
                    <button type="button" class="btn-tab-action modal-cancel">Batal</button>
                    <button type="submit" class="btn-tab-action btn-add"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==================== MODAL: PUBLIKASI ==================== -->
<div id="publikasiModal" class="modal-overlay">
    <div class="modal-container" style="max-width: 720px;">
        <div class="modal-header">
            <h3 class="modal-title-text">Tambah Publikasi</h3>
            <button type="button" class="modal-close" aria-label="Tutup">&times;</button>
        </div>
        <div class="modal-body">
            <form action="<?= site_url('staff/save_publication/' . $staff->id) ?>" method="POST" enctype="multipart/form-data" class="upload-form">
                <input type="hidden" name="pub_id" id="pub_id_field" value="">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 20px;">

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Judul <span style="color:red">*</span></label>
                        <input type="text" name="title" id="pub_title" class="form-control" required>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Penulis</label>
                        <input type="text" name="authors" id="pub_authors" class="form-control" placeholder="Nama1, Nama2, ...">
                    </div>

                    <div class="form-group">
                        <label>Tipe</label>
                        <select name="type" id="pub_type" class="form-control">
                            <option value="journal">Jurnal</option>
                            <option value="conference">Konferensi</option>
                            <option value="book">Buku</option>
                            <option value="book_chapter">Book Chapter</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tahun</label>
                        <input type="number" name="year" id="pub_year" class="form-control" min="1900" max="2100">
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Nama Jurnal / Prosiding</label>
                        <input type="text" name="journal_name" id="pub_journal" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Volume</label>
                        <input type="text" name="volume" id="pub_volume" class="form-control" placeholder="12(1)">
                    </div>

                    <div class="form-group">
                        <label>Halaman</label>
                        <input type="text" name="pages" id="pub_pages" class="form-control" placeholder="45-58">
                    </div>

                    <div class="form-group">
                        <label>DOI</label>
                        <input type="text" name="doi" id="pub_doi" class="form-control" placeholder="10.xxxx/...">
                    </div>

                    <div class="form-group">
                        <label>URL</label>
                        <input type="url" name="url" id="pub_url" class="form-control" placeholder="https://...">
                    </div>

                    <div class="form-group">
                        <label>Level</label>
                        <select name="level" id="pub_level" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Nasional">Nasional</option>
                            <option value="Internasional">Internasional</option>
                            <option value="Internasional Bereputasi">Internasional Bereputasi</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="pub_status" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Published">Published</option>
                            <option value="Accepted">Accepted</option>
                            <option value="Submitted">Submitted</option>
                            <option value="In Review">In Review</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Bahasa Asli</label>
                        <input type="text" name="original_language" id="pub_lang" class="form-control" placeholder="Indonesia / English">
                    </div>

                    <div class="form-group">
                        <label>Bidang Ilmu (Group of Knowledge)</label>
                        <input type="text" name="group_of_knowledge" id="pub_gok" class="form-control">
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Abstrak</label>
                        <textarea name="abstract" id="pub_abstract" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Dokumen <small style="color:var(--gray-500)">(PDF/DOC/DOCX, maks. 10MB)</small></label>
                        <input type="file" name="document" id="pub_document" class="form-control" accept=".pdf,.doc,.docx">
                    </div>
                </div>
                <div class="form-actions" style="margin-top:12px;border-top:1px solid var(--gray-200);padding-top:20px;">
                    <button type="button" class="btn-tab-action modal-cancel">Batal</button>
                    <button type="submit" class="btn-tab-action btn-add"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==================== MODAL: PENGABDIAN ==================== -->
<div id="communityModal" class="modal-overlay">
    <div class="modal-container" style="max-width: 680px;">
        <div class="modal-header">
            <h3 class="modal-title-text">Tambah Pengabdian Masyarakat</h3>
            <button type="button" class="modal-close" aria-label="Tutup">&times;</button>
        </div>
        <div class="modal-body">
            <form action="<?= site_url('staff/save_community_service/' . $staff->id) ?>" method="POST" enctype="multipart/form-data" class="upload-form">
                <input type="hidden" name="cs_id" id="cs_id_field" value="">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 20px;">

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Judul <span style="color:red">*</span></label>
                        <input type="text" name="title" id="cs_title" class="form-control" required>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Penulis / Tim</label>
                        <input type="text" name="authors" id="cs_authors" class="form-control" placeholder="Nama1, Nama2, ...">
                    </div>

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="service_date" id="cs_date" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Bahasa Asli</label>
                        <input type="text" name="original_language" id="cs_lang" class="form-control" placeholder="Indonesia / English">
                    </div>

                    <div class="form-group">
                        <label>Level</label>
                        <select name="level" id="cs_level" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Lokal">Lokal</option>
                            <option value="Nasional">Nasional</option>
                            <option value="Internasional">Internasional</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="cs_status" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Ongoing">Ongoing</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Bidang Ilmu (Group of Knowledge)</label>
                        <input type="text" name="group_of_knowledge" id="cs_gok" class="form-control">
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Abstrak / Deskripsi</label>
                        <textarea name="abstract" id="cs_abstract" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Dokumen <small style="color:var(--gray-500)">(PDF/DOC/DOCX, maks. 10MB)</small></label>
                        <input type="file" name="document" id="cs_document" class="form-control" accept=".pdf,.doc,.docx">
                    </div>
                </div>
                <div class="form-actions" style="margin-top:12px;border-top:1px solid var(--gray-200);padding-top:20px;">
                    <button type="button" class="btn-tab-action modal-cancel">Batal</button>
                    <button type="submit" class="btn-tab-action btn-add"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==================== MODAL: KONFIRMASI HAPUS ==================== -->
<div id="deleteConfirmModal" class="modal-overlay">
    <div class="modal-container" style="max-width:400px;">
        <div class="modal-header">
            <h3><i class="fas fa-trash" style="color:#e53e3e;margin-right:8px"></i>Konfirmasi Hapus</h3>
            <button type="button" class="modal-close" aria-label="Tutup">&times;</button>
        </div>
        <div class="modal-body" style="text-align:center;padding:24px 20px;">
            <p style="margin-bottom:20px;color:var(--gray-700)">Yakin ingin menghapus data ini? Tindakan tidak dapat dibatalkan.</p>
            <form id="deleteConfirmForm" method="POST" action="">
                <input type="hidden" id="deleteItemId" name="" value="">
                <div style="display:flex;gap:10px;justify-content:center;">
                    <button type="button" class="btn-tab-action modal-cancel">Batal</button>
                    <button type="submit" class="btn-tab-action btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==================== SCRIPTS ==================== -->
<script>
document.addEventListener('DOMContentLoaded', () => {

    // ---- Tab switching ----
    document.querySelectorAll('.tab-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.tab-link').forEach(l => l.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            document.getElementById(this.dataset.tab).classList.add('active');
        });
    });

    // ---- Modal helpers ----
    function openModal(id) {
        const m = document.getElementById(id);
        if (m) m.classList.add('active');
    }
    function closeAllModals() {
        document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('active'));
    }

    document.querySelectorAll('.modal-close, .modal-cancel').forEach(btn => btn.addEventListener('click', closeAllModals));

    // ---- Delete confirm ----
    document.querySelectorAll('.btn-confirm-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = document.getElementById('deleteConfirmForm');
            const input = document.getElementById('deleteItemId');
            form.action = this.dataset.action;
            input.name  = this.dataset.idName;
            input.value = this.dataset.id;
            openModal('deleteConfirmModal');
        });
    });
    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', e => { if (e.target === modal) closeAllModals(); });
    });

    // ---- Generic open-modal buttons ----
    document.querySelectorAll('.btn-open-modal').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const modalId = this.dataset.modal;
            const mode    = this.dataset.mode || 'add';
            const modal   = document.getElementById(modalId);
            if (!modal) return;

            // Handle view-only detail modals
            if (mode === 'view') {
                const d = this.dataset;
                if (modalId === 'grantDetailModal')     populateGrantDetail(d);
                if (modalId === 'researchDetailModal')  populateResearchDetail(d);
                if (modalId === 'pubDetailModal')       populatePubDetail(d);
                if (modalId === 'communityDetailModal') populateCommunityDetail(d);
                openModal(modalId);
                return;
            }

            // Reset form
            const form = modal.querySelector('form');
            if (form) form.reset();

            // Update title
            const titleEl = modal.querySelector('.modal-title-text');

            // Fill data for edit mode
            if (mode === 'edit') {
                if (titleEl) titleEl.textContent = titleEl.textContent.replace('Tambah', 'Edit');

                const d = this.dataset;

                // Grant
                if (modalId === 'grantModal') {
                    if (titleEl) titleEl.textContent = 'Edit Grant & Proyek';
                    setVal(modal, '#grant_id_field', d.id);
                    setVal(modal, '#grant_title', d.title);
                    setVal(modal, '#grant_funder', d.funder);
                    setVal(modal, '#grant_role', d.role);
                    setVal(modal, '#grant_year_start', d.yearStart);
                    setVal(modal, '#grant_year_end', d.yearEnd);
                    setVal(modal, '#grant_amount', d.amount);
                    setVal(modal, '#grant_description', d.description);
                }

                // Research
                if (modalId === 'researchModal') {
                    if (titleEl) titleEl.textContent = 'Edit Penelitian';
                    setVal(modal, '#research_id_field', d.id);
                    setVal(modal, '#research_title', d.title);
                    setVal(modal, '#research_authors', d.authors);
                    setVal(modal, '#research_date', d.date);
                    setVal(modal, '#research_abstract', d.abstract);
                    setVal(modal, '#research_gok', d.gok);
                    setVal(modal, '#research_lang', d.lang);
                    setVal(modal, '#research_level', d.level);
                    setVal(modal, '#research_status', d.status);
                }

                // Publikasi
                if (modalId === 'publikasiModal') {
                    if (titleEl) titleEl.textContent = 'Edit Publikasi';
                    setVal(modal, '#pub_id_field', d.id);
                    setVal(modal, '#pub_title', d.title);
                    setVal(modal, '#pub_type', d.type);
                    setVal(modal, '#pub_journal', d.journal);
                    setVal(modal, '#pub_year', d.year);
                    setVal(modal, '#pub_volume', d.volume);
                    setVal(modal, '#pub_pages', d.pages);
                    setVal(modal, '#pub_doi', d.doi);
                    setVal(modal, '#pub_url', d.url);
                    setVal(modal, '#pub_authors', d.authors);
                    setVal(modal, '#pub_abstract', d.abstract);
                    setVal(modal, '#pub_gok', d.gok);
                    setVal(modal, '#pub_lang', d.lang);
                    setVal(modal, '#pub_level', d.level);
                    setVal(modal, '#pub_status', d.status);
                }

                // Community
                if (modalId === 'communityModal') {
                    if (titleEl) titleEl.textContent = 'Edit Pengabdian Masyarakat';
                    setVal(modal, '#cs_id_field', d.id);
                    setVal(modal, '#cs_title', d.title);
                    setVal(modal, '#cs_authors', d.authors);
                    setVal(modal, '#cs_date', d.date);
                    setVal(modal, '#cs_abstract', d.abstract);
                    setVal(modal, '#cs_gok', d.gok);
                    setVal(modal, '#cs_lang', d.lang);
                    setVal(modal, '#cs_level', d.level);
                    setVal(modal, '#cs_status', d.status);
                }
            } else {
                // Reset title to "Tambah ..."
                if (titleEl) {
                    const titles = {
                        grantModal:    'Tambah Grant & Proyek',
                        researchModal: 'Tambah Penelitian',
                        publikasiModal:'Tambah Publikasi',
                        communityModal:'Tambah Pengabdian Masyarakat',
                    };
                    if (titles[modalId]) titleEl.textContent = titles[modalId];
                }
            }

            openModal(modalId);
        });
    });

    function setVal(modal, selector, value) {
        const el = modal.querySelector(selector);
        if (!el || value === undefined || value === null) return;
        el.value = value;
    }

    // ---- View-mode helpers ----
    function setText(id, value, fallback) {
        const el = document.getElementById(id);
        if (!el) return;
        el.textContent = (value && value.trim()) ? value : (fallback || '—');
    }
    function setHtml(id, html) {
        const el = document.getElementById(id);
        if (el) el.innerHTML = html;
    }
    function fmtDate(val) {
        if (!val) return '—';
        const d = new Date(val);
        if (isNaN(d)) return val;
        return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
    }
    function fmtIDR(val) {
        if (!val || val === '0') return '—';
        return 'Rp ' + parseInt(val).toLocaleString('id-ID');
    }
    function docLink(path) {
        if (!path) return '<span style="color:var(--gray-400)">—</span>';
        return '<a href="<?= base_url() ?>' + path + '" target="_blank" class="detail-doc-link"><i class="fas fa-file-pdf"></i> Lihat Dokumen</a>';
    }
    function doiLink(doi) {
        if (!doi) return '—';
        return '<a href="https://doi.org/' + encodeURIComponent(doi) + '" target="_blank" class="detail-link">' + doi + '</a>';
    }
    function urlLink(url) {
        if (!url) return '—';
        return '<a href="' + url + '" target="_blank" class="detail-link">' + url + '</a>';
    }

    // ---- View-mode handlers ----
    function populateGrantDetail(d) {
        setText('dg_title',       d.title);
        setText('dg_funder',      d.funder);
        setText('dg_role',        d.role);
        const yr = [d.yearStart, d.yearEnd].filter(Boolean).join(' – ');
        document.getElementById('dg_year').textContent = yr || '—';
        document.getElementById('dg_amount').textContent = fmtIDR(d.amount);

        const descEl = document.getElementById('dg_description');
        const descSec = document.getElementById('dg_desc_section');
        if (d.description && d.description.trim()) {
            descEl.textContent = d.description;
            descSec.style.display = '';
        } else {
            descSec.style.display = 'none';
        }
        setHtml('dg_document', docLink(d.document));
    }
    function populateResearchDetail(d) {
        setText('dr_title',   d.title);
        setText('dr_authors', d.authors);
        document.getElementById('dr_date').textContent   = fmtDate(d.date);
        setText('dr_level',   d.level);
        setText('dr_status',  d.status);
        setText('dr_gok',     d.gok);
        setText('dr_lang',    d.lang);

        const absEl  = document.getElementById('dr_abstract');
        const absSec = document.getElementById('dr_abstract_section');
        if (d.abstract && d.abstract.trim()) {
            absEl.textContent = d.abstract;
            absSec.style.display = '';
        } else {
            absSec.style.display = 'none';
        }
        setHtml('dr_document', docLink(d.document));
    }
    function populatePubDetail(d) {
        setText('dp_title',   d.title);
        setText('dp_authors', d.authors);
        const typeMap = { journal:'Jurnal', conference:'Konferensi', book:'Buku', book_chapter:'Book Chapter', other:'Lainnya' };
        document.getElementById('dp_type').textContent = typeMap[d.type] || d.type || '—';
        setText('dp_journal', d.journal);
        document.getElementById('dp_year').textContent = d.year || '—';
        const volPages = [d.volume ? 'Vol. ' + d.volume : '', d.pages ? 'pp. ' + d.pages : ''].filter(Boolean).join(', ');
        document.getElementById('dp_vol_pages').textContent = volPages || '—';
        setHtml('dp_doi',    doiLink(d.doi));
        setHtml('dp_url',    urlLink(d.url));
        setText('dp_level',  d.level);
        setText('dp_status', d.status);
        setText('dp_gok',    d.gok);
        setText('dp_lang',   d.lang);

        const absEl  = document.getElementById('dp_abstract');
        const absSec = document.getElementById('dp_abstract_section');
        if (d.abstract && d.abstract.trim()) {
            absEl.textContent = d.abstract;
            absSec.style.display = '';
        } else {
            absSec.style.display = 'none';
        }
        setHtml('dp_document', docLink(d.document));
    }
    function populateCommunityDetail(d) {
        setText('dc_title',   d.title);
        setText('dc_authors', d.authors);
        document.getElementById('dc_date').textContent   = fmtDate(d.date);
        setText('dc_level',   d.level);
        setText('dc_status',  d.status);
        setText('dc_gok',     d.gok);
        setText('dc_lang',    d.lang);

        const absEl  = document.getElementById('dc_abstract');
        const absSec = document.getElementById('dc_abstract_section');
        if (d.abstract && d.abstract.trim()) {
            absEl.textContent = d.abstract;
            absSec.style.display = '';
        } else {
            absSec.style.display = 'none';
        }
        setHtml('dc_document', docLink(d.document));
    }
});
</script>

<style>
.btn-danger {
    background: #fff0f0;
    color: #e53e3e;
    border: 1px solid #fed7d7;
}
.btn-danger:hover {
    background: #e53e3e;
    color: #fff;
    border-color: #e53e3e;
}
.abstract-text {
    color: var(--gray-700);
    font-size: 14px;
    line-height: 1.7;
    margin-top: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
