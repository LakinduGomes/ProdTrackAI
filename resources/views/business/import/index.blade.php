@extends('layouts.business')
@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --accent: #6366f1;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --surface: #fff;
            --bg: #f8fafc;
            --muted: #64748b;
            --border: rgba(0, 0, 0, 0.06);
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 4px 12px rgba(0, 0, 0, 0.04);
        }

        body,
        .content-wrapper {
            background: var(--bg) !important;
            font-family: 'DM Sans', sans-serif;
        }

        .pt-page {
            padding: 1.5rem;
        }

        .pt-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }

        .pt-sub {
            color: var(--muted);
            font-size: .82rem;
            margin-top: 2px;
        }

        .card-pt {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 1.25rem;
            box-shadow: var(--shadow);
        }

        .card-title {
            font-family: 'Syne', sans-serif;
            font-size: .95rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 1rem;
        }

        .drop-zone {
            border: 2px dashed rgba(99, 102, 241, .3);
            border-radius: 16px;
            background: rgba(99, 102, 241, .03);
            padding: 2.5rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: .2s;
        }

        .drop-zone:hover,
        .drop-zone.dragover {
            border-color: #6366f1;
            background: rgba(99, 102, 241, .07);
        }

        .drop-zone i {
            font-size: 2rem;
            color: #6366f1;
        }

        .drop-zone .dz-title {
            font-weight: 700;
            font-size: .95rem;
            color: #0f172a;
            margin-top: .6rem;
        }

        .drop-zone .dz-sub {
            font-size: .78rem;
            color: var(--muted);
            margin-top: 2px;
        }

        .file-chip {
            display: none;
            align-items: center;
            gap: .5rem;
            background: #eef2ff;
            color: #4338ca;
            font-size: .8rem;
            font-weight: 600;
            padding: .5rem .9rem;
            border-radius: 10px;
            margin-top: 1rem;
        }

        table.import-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .82rem;
        }

        table.import-table th {
            text-align: left;
            font-size: .68rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--muted);
            font-weight: 700;
            padding: .6rem .5rem;
            border-bottom: 1px solid var(--border);
        }

        table.import-table td {
            padding: .7rem .5rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .status-badge {
            font-size: .68rem;
            font-weight: 700;
            padding: .25rem .6rem;
            border-radius: 8px;
            text-transform: capitalize;
        }

        .status-badge.completed {
            background: #dcfce7;
            color: #16a34a;
        }

        .status-badge.processing {
            background: #fef3c7;
            color: #b45309;
        }

        .status-badge.failed {
            background: #fee2e2;
            color: #dc2626;
        }

        .icon-btn {
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: #fff;
            color: var(--muted);
            text-decoration: none;
        }

        .icon-btn:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .icon-btn.danger:hover {
            background: #fee2e2;
            color: #dc2626;
        }
    </style>

    <div class="pt-page">
        <div class="mb-4">
            <div class="pt-title"><i class="fas fa-file-excel me-2 text-primary"></i>Excel Import & Analysis</div>
            <div class="pt-sub">Upload a task report to auto-run ML delay predictions</div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="border-radius:12px;font-size:.85rem;">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" style="border-radius:12px;font-size:.85rem;">{{ session('error') }}</div>
        @endif

        <div class="card-pt mb-4">
            <div class="card-title"><i class="fas fa-upload me-2 text-primary"></i>Upload Task Report</div>

            <form id="uploadForm" action="{{ route('import.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="drop-zone" id="dropZone">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <div class="dz-title">Drag & drop your file here, or click to browse</div>
                    <div class="dz-sub">.xlsx, .xls or .csv &nbsp;•&nbsp; max 10MB</div>
                    <input type="file" id="fileInput" name="file" accept=".xlsx,.xls,.csv" style="display:none;">
                </div>
                <div class="file-chip" id="fileChip">
                    <i class="fas fa-file-alt"></i>
                    <span id="fileName"></span>
                </div>
                <button type="submit" id="submitBtn" class="btn btn-primary mt-3" disabled
                    style="background:#6366f1;border:none;border-radius:10px;font-weight:600;font-size:.85rem;padding:.55rem 1.4rem;">
                    <span id="submitLabel"><i class="fas fa-bolt me-1"></i>Import & Predict</span>
                </button>
            </form>
        </div>

        <div class="card-pt">
            <div class="card-title"><i class="fas fa-history me-2 text-primary"></i>Import History</div>

            @if ($sessions->isEmpty())
                <div style="font-size:.85rem;color:var(--muted);padding:1rem 0;">No imports yet. Upload a file above to
                    get started.</div>
            @else
                <table class="import-table">
                    <thead>
                        <tr>
                            <th>File</th>
                            <th>Rows</th>
                            <th>Status</th>
                            <th>Uploaded</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sessions as $s)
                            <tr>
                                <td style="font-weight:600;">{{ $s->original_filename }}</td>
                                <td>{{ $s->tasks_count }}</td>
                                <td><span class="status-badge {{ $s->status }}">{{ $s->status }}</span></td>
                                <td style="color:var(--muted);">{{ $s->created_at->format('d M Y, h:i A') }}</td>
                                <td style="text-align:right;">
                                    <a href="{{ route('import.analysis', $s->id) }}" class="icon-btn" title="View analysis">
                                        <i class="fas fa-chart-bar"></i>
                                    </a>
                                    <form action="{{ route('import.destroy', $s->id) }}" method="POST" style="display:inline;"
                                        onsubmit="return confirm('Delete this import and all its tasks?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-btn danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">{{ $sessions->links() }}</div>
            @endif
        </div>
    </div>

    <script>
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const fileChip = document.getElementById('fileChip');
        const fileName = document.getElementById('fileName');
        const submitBtn = document.getElementById('submitBtn');
        const submitLabel = document.getElementById('submitLabel');
        const uploadForm = document.getElementById('uploadForm');

        dropZone.addEventListener('click', () => fileInput.click());

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                showFile(fileInput.files[0]);
            }
        });

        fileInput.addEventListener('change', () => {
            if (fileInput.files.length) {
                showFile(fileInput.files[0]);
            }
        });

        function showFile(file) {
            fileName.textContent = file.name;
            fileChip.style.display = 'inline-flex';
            submitBtn.disabled = false;
        }

        uploadForm.addEventListener('submit', () => {
            submitBtn.disabled = true;
            submitLabel.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Importing & predicting...';
        });
    </script>
@endsection