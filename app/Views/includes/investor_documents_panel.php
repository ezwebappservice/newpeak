<?php
$availableYears = $available_years ?? [];
$defaultYear = (string) ($default_year ?? ($availableYears[0] ?? ''));
$documentsPerPage = max(1, min(50, (int) ($documents_per_page ?? 10)));
$filtersReady = $defaultYear !== '';
?>
<div class="investor-documents-panel reveal" data-reveal>
  <div class="investor-filters-card">
    <div class="investor-filters-heading">
      <span class="section-label">Search & Filter</span>
      <h2 class="section-title mb-1">Document Library</h2>
      <p class="mb-0">Use the filters below to find downloadable files for <?= cms_text($investor_category['category_name'] ?? 'this category') ?>.</p>
    </div>

  <div class="investor-filters">
    <div class="row g-3 align-items-end">
      <div class="col-md-3 col-sm-6">
        <label for="investor-year" class="form-label">Year *</label>
        <select id="investor-year" class="form-control investor-filter">
          <?php if ($availableYears === []): ?>
            <option value="">No years available</option>
          <?php else: ?>
            <?php foreach ($availableYears as $year): ?>
              <option value="<?= cms_attr($year) ?>" <?= $year === $defaultYear ? 'selected' : '' ?>><?= cms_text($year) ?></option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>
      <div class="col-md-3 col-sm-6">
        <label for="investor-type" class="form-label">Document Type</label>
        <select id="investor-type" class="form-control investor-filter" <?= $filtersReady ? '' : 'disabled' ?>>
          <option value="">All Types</option>
          <?php foreach (($document_types ?? []) as $type): ?>
            <option value="<?= cms_attr($type) ?>"><?= cms_text($type) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4 col-sm-8">
        <label for="investor-keyword" class="form-label">Search by Title</label>
        <input type="text" id="investor-keyword" class="form-control investor-filter" placeholder="Search documents..." <?= $filtersReady ? '' : 'disabled' ?>>
      </div>
      <div class="col-md-2 col-sm-4">
        <button type="button" id="investor-reset" class="btn btn-outline-secondary w-100">Reset</button>
      </div>
    </div>
  </div>
  </div>

  <div id="investor-message" class="alert alert-info mt-4<?= $filtersReady ? ' d-none' : '' ?>" role="alert">
    <?= $availableYears === [] ? 'No documents are available for this category yet.' : 'Loading documents...' ?>
  </div>

  <div class="table-responsive investor-table-wrap mt-4 d-none" id="investor-table-wrap">
    <table class="table table-striped table-hover investor-doc-table">
      <thead>
        <tr>
          <th>File Title</th>
          <th>Title Type</th>
          <th>Document Type</th>
          <th>Upload Date</th>
          <th class="text-end">Download / View</th>
        </tr>
      </thead>
      <tbody id="investor-documents-body"></tbody>
    </table>
  </div>

  <div class="investor-pagination-meta mt-3 d-none" id="investor-pagination-meta"></div>
  <nav class="mt-2 d-none" id="investor-pagination-wrap" aria-label="Investor documents pagination">
    <ul class="pagination justify-content-center flex-wrap" id="investor-pagination"></ul>
  </nav>
</div>

<script>
(function () {
  var baseUrl = <?= json_encode(base_url()) ?>;
  var categoryId = <?= json_encode((int) ($category_id ?? 0)) ?>;
  var defaultYear = <?= json_encode($defaultYear) ?>;
  var availableYears = <?= json_encode(array_values($availableYears)) ?>;
  var perPage = <?= json_encode($documentsPerPage) ?>;
  var currentPage = 1;
  var debounceTimer = null;

  var els = {
    year: document.getElementById('investor-year'),
    type: document.getElementById('investor-type'),
    keyword: document.getElementById('investor-keyword'),
    reset: document.getElementById('investor-reset'),
    message: document.getElementById('investor-message'),
    tableWrap: document.getElementById('investor-table-wrap'),
    tbody: document.getElementById('investor-documents-body'),
    paginationMeta: document.getElementById('investor-pagination-meta'),
    paginationWrap: document.getElementById('investor-pagination-wrap'),
    pagination: document.getElementById('investor-pagination')
  };

  function setMessage(text, type) {
    els.message.className = 'alert mt-4 alert-' + (type || 'info');
    els.message.textContent = text;
    els.message.classList.remove('d-none');
  }

  function hideResults() {
    els.tableWrap.classList.add('d-none');
    els.paginationMeta.classList.add('d-none');
    els.paginationWrap.classList.add('d-none');
  }

  function showResults() {
    els.tableWrap.classList.remove('d-none');
  }

  function fetchJson(url) {
    return fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } }).then(function (r) { return r.json(); });
  }

  function loadDocumentTypes() {
    var year = els.year.value;
    if (!year) {
      els.type.disabled = true;
      els.keyword.disabled = true;
      return Promise.resolve();
    }

    return fetchJson(baseUrl + 'investor/document_types?category_id=' + encodeURIComponent(categoryId) + '&year=' + encodeURIComponent(year)).then(function (res) {
      var types = res.data || [];
      var current = els.type.value;
      els.type.innerHTML = '<option value="">All Types</option>';
      types.forEach(function (t) {
        var o = document.createElement('option');
        o.value = t;
        o.textContent = t;
        if (current === t) o.selected = true;
        els.type.appendChild(o);
      });
      els.type.disabled = false;
      els.keyword.disabled = false;
    });
  }

  function createPageItem(label, pageNum, disabled, active) {
    var li = document.createElement('li');
    li.className = 'page-item' + (disabled ? ' disabled' : '') + (active ? ' active' : '');
    var a = document.createElement('a');
    a.className = 'page-link';
    a.href = '#';
    a.textContent = label;
    if (!disabled && !active) {
      a.addEventListener('click', function (e) {
        e.preventDefault();
        currentPage = pageNum;
        loadDocuments();
        window.scrollTo({ top: els.tableWrap.offsetTop - 120, behavior: 'smooth' });
      });
    }
    li.appendChild(a);
    return li;
  }

  function renderPagination(pagination) {
    els.pagination.innerHTML = '';
    els.paginationMeta.textContent = '';

    if (!pagination || pagination.total <= 0) {
      els.paginationMeta.classList.add('d-none');
      els.paginationWrap.classList.add('d-none');
      return;
    }

    var total = pagination.total;
    var page = pagination.page;
    var pageSize = pagination.per_page;
    var totalPages = pagination.total_pages;
    var from = ((page - 1) * pageSize) + 1;
    var to = Math.min(page * pageSize, total);

    els.paginationMeta.textContent = 'Showing ' + from + '–' + to + ' of ' + total + ' document' + (total === 1 ? '' : 's');
    els.paginationMeta.classList.remove('d-none');

    if (totalPages <= 1) {
      els.paginationWrap.classList.add('d-none');
      return;
    }

    els.paginationWrap.classList.remove('d-none');
    els.pagination.appendChild(createPageItem('Previous', page - 1, page <= 1, false));

    var start = Math.max(1, page - 2);
    var end = Math.min(totalPages, page + 2);

    if (start > 1) {
      els.pagination.appendChild(createPageItem('1', 1, false, page === 1));
      if (start > 2) {
        var dots = document.createElement('li');
        dots.className = 'page-item disabled';
        dots.innerHTML = '<span class="page-link">...</span>';
        els.pagination.appendChild(dots);
      }
    }

    for (var p = start; p <= end; p++) {
      els.pagination.appendChild(createPageItem(String(p), p, false, p === page));
    }

    if (end < totalPages) {
      if (end < totalPages - 1) {
        var dotsEnd = document.createElement('li');
        dotsEnd.className = 'page-item disabled';
        dotsEnd.innerHTML = '<span class="page-link">...</span>';
        els.pagination.appendChild(dotsEnd);
      }
      els.pagination.appendChild(createPageItem(String(totalPages), totalPages, false, page === totalPages));
    }

    els.pagination.appendChild(createPageItem('Next', page + 1, page >= totalPages, false));
  }

  function loadDocuments() {
    var year = els.year.value;
    if (!year) {
      hideResults();
      setMessage('No documents are available for this category yet.', 'warning');
      return;
    }

    var params = new URLSearchParams({
      category_id: String(categoryId),
      year: year,
      page: String(currentPage),
      per_page: String(perPage)
    });
    if (els.type.value) params.set('document_type', els.type.value);
    if (els.keyword.value.trim()) params.set('keyword', els.keyword.value.trim());

    setMessage('Loading documents...', 'secondary');
    hideResults();

    fetchJson(baseUrl + 'investor/documents?' + params.toString()).then(function (res) {
      var rows = res.data || [];
      if (!rows.length) {
        setMessage('No documents found for the selected filters.', 'warning');
        renderPagination({ total: 0, page: 1, per_page: perPage, total_pages: 0 });
        return;
      }

      els.message.classList.add('d-none');
      showResults();
      els.tbody.innerHTML = '';
      rows.forEach(function (row) {
        var tr = document.createElement('tr');
        var actions = '<a class="btn btn-sm btn-primary investor-action-btn" href="' + row.download_url + '">Download</a>';
        if (row.is_pdf && row.view_url) {
          actions += '<a class="btn btn-sm btn-outline-primary investor-action-btn" href="' + row.view_url + '" target="_blank" rel="noopener">View PDF</a>';
        }
        tr.innerHTML =
          '<td>' + escapeHtml(row.file_title) + '</td>' +
          '<td>' + escapeHtml(row.title_type) + '</td>' +
          '<td>' + escapeHtml(row.document_type) + '</td>' +
          '<td>' + escapeHtml(row.upload_date || '') + '</td>' +
          '<td class="text-end">' + actions + '</td>';
        els.tbody.appendChild(tr);
      });
      renderPagination(res.pagination || {});
    }).catch(function () {
      setMessage('Unable to load documents. Please try again.', 'danger');
    });
  }

  function escapeHtml(str) {
    return String(str || '').replace(/[&<>"']/g, function (m) {
      return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[m];
    });
  }

  function resetFilters() {
    currentPage = 1;
    els.year.value = defaultYear;
    els.type.value = '';
    els.keyword.value = '';

    if (!defaultYear) {
      els.type.disabled = true;
      els.keyword.disabled = true;
      hideResults();
      setMessage('No documents are available for this category yet.', 'warning');
      return;
    }

    loadDocumentTypes().then(loadDocuments);
  }

  els.year.addEventListener('change', function () {
    currentPage = 1;
    els.type.value = '';
    loadDocumentTypes().then(loadDocuments);
  });
  els.type.addEventListener('change', function () {
    currentPage = 1;
    loadDocuments();
  });
  els.keyword.addEventListener('input', function () {
    currentPage = 1;
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(loadDocuments, 350);
  });
  els.reset.addEventListener('click', resetFilters);

  if (defaultYear) {
    loadDocumentTypes().then(loadDocuments);
  }
})();
</script>
