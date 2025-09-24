@extends('layouts.front')

@section('front')
<div class="wrapper">
    <!-- Navbar -->
    <x-front-dashboard-navbar></x-front-dashboard-navbar>
    <!-- /.Navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/dashboard" class="brand-link">
            <img src="{{ asset('favicon.ico') }}" alt="Sonic Logo"
                 class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Sonic</span>
        </a>

        <!-- Sidebar Menu -->
        <x-front-sidemenu></x-front-sidemenu>
        <!-- /.sidebar Menu -->
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Armada</h1></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item active">Armada</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row"><div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            @if (session('update')) <div class="alert alert-success">{{ session('update') }}</div>@endif
                            @if (session('delete')) <div class="alert alert-success">{{ session('delete') }}</div>@endif
                            @if (session('store'))  <div class="alert alert-success">{{ session('store') }}</div>@endif
                            @if (session('sameTrain')) <div class="alert alert-danger">{{ session('sameTrain') }}</div>@endif

                            <div class="row mb-2">
                                <div class="col-sm-6"><h3 class="card-title">Data Armada</h3></div>
                                @can('isAdmin')
                                <div class="col-sm-6">
                                    <button class="btn btn-warning btn-sm float-sm-right" type="button"
                                            data-toggle="modal" data-target="#modal-tambah-train">
                                        Tambah Armada
                                    </button>

                                    {{-- Modal Tambah --}}
                                    <div class="modal fade" id="modal-tambah-train">
                                        <div class="modal-dialog modal-lg"><div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Form Tambah Armada</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form action="/trains" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    {{-- Armada --}}
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Armada</label>
                                                        <input type="text" class="col-sm-10 form-control"
                                                               name="name" value="{{ old('name') }}" required>
                                                    </div>
                                                    {{-- Kelas --}}
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Kelas</label>
                                                        <input type="text" class="col-sm-10 form-control"
                                                               name="class" value="{{ old('class') }}" required>
                                                    </div>
                                                    {{-- Nopol --}}
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Nopol</label>
                                                        <input type="text" class="col-sm-10 form-control"
                                                               name="nopol" value="{{ old('nopol') }}" required>
                                                    </div>

                                                    {{-- Foto Armada & Foto Kursi (BARU) --}}
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Foto Armada</label>
                                                        <input type="file" class="col-sm-10 form-control"
                                                               name="foto_armada" accept="image/*">
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Foto Kursi</label>
                                                        <input type="file" class="col-sm-10 form-control"
                                                               name="foto_kursi" accept="image/*">
                                                    </div>

                                                    {{-- ===== Seat Layout Builder (Tambah) ===== --}}
                                                    <hr>
                                                    <div class="form-group">
                                                      <label class="d-block mb-1">Seat Layout Builder</label>

                                                      <div class="d-flex flex-wrap align-items-center">
                                                        <div class="form-inline mr-2 mb-2">
                                                          <label class="mr-2">Rows</label>
                                                          <input type="number" id="slbR" class="form-control form-control-sm" value="{{ old('rows', 10) }}" min="1" style="width:90px">
                                                        </div>
                                                        <div class="form-inline mr-2 mb-2">
                                                          <label class="mr-2">Cols</label>
                                                          <input type="number" id="slbC" class="form-control form-control-sm" value="{{ old('cols', 4) }}" min="1" style="width:90px">
                                                        </div>

                                                        <button type="button" id="slbGen" class="btn btn-primary btn-sm mr-2 mb-2">Generate Grid</button>

                                                        <div class="custom-control custom-checkbox mr-3 mb-2">
                                                          <input type="checkbox" class="custom-control-input" id="slbAuto" checked>
                                                          <label class="custom-control-label" for="slbAuto">Auto-number seats</label>
                                                        </div>

                                                        <button type="button" id="slbFill"  class="btn btn-success btn-sm mr-2 mb-2">Pilih Semua</button>
                                                        <button type="button" id="slbClear" class="btn btn-secondary btn-sm mb-2">Kosongkan</button>
                                                      </div>

                                                      <small class="text-muted d-block mb-2">
                                                        Klik kotak untuk toggle: <span class="badge badge-success">Kursi</span> / <span class="badge badge-light">Kosong</span>.
                                                      </small>

                                                      <div id="slbGrid" class="border p-2" style="display:inline-block; max-width:100%; overflow:auto;"></div>

                                                      <div class="mt-2">
                                                        <strong>Ringkasan:</strong> <span id="slbSum">0 seats • 0 rows × 0 cols</span>
                                                      </div>
                                                    </div>

                                                    {{-- Hidden fields terisi otomatis saat submit --}}
                                                    <textarea name="layout" id="slbLayout" class="d-none">{{ old('layout') }}</textarea>
                                                    <input type="hidden" name="total_seats" id="slbTotal" value="{{ old('total_seats', 0) }}">
                                                    <input type="hidden" name="rows"        id="slbRows"  value="{{ old('rows', 0) }}">
                                                    <input type="hidden" name="cols"        id="slbCols"  value="{{ old('cols', 0) }}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success">Submit</button>
                                                </div>
                                            </form>
                                        </div></div>
                                    </div>
                                </div>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Nopol</th>
                                        <th>Foto Armada</th>
                                        <th>Foto Kursi</th>
                                        <th>Total</th>
                                        <th>Rows</th>
                                        <th>Cols</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($trains as $train)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $train->id }}</td>
                                        <td>{{ $train->name }}</td>
                                        <td>{{ $train->class }}</td>
                                        <td>{{ $train->nopol }}</td>
                                        <td>
                                            @if($train->foto_armada)
                                                <img src="{{ asset('storage/'.$train->foto_armada) }}" width="80">
                                            @else-@endif
                                        </td>
                                        <td>
                                            @if($train->foto_kursi)
                                                <img src="{{ asset('storage/'.$train->foto_kursi) }}" width="80">
                                            @else-@endif
                                        </td>
                                        <td>{{ $train->total_seats ?? 0 }}</td>
                                        <td>{{ $train->rows ?? 0 }}</td>
                                        <td>{{ $train->cols ?? 0 }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-xs btn-edit-train"
                                                data-toggle="modal" data-target="#modal-edit-train"
                                                data-id="{{ $train->id }}"
                                                data-name="{{ $train->name }}"
                                                data-class="{{ $train->class }}"
                                                data-nopol="{{ $train->nopol }}"
                                                data-foto_armada="{{ $train->foto_armada ? asset('storage/'.$train->foto_armada) : '' }}"
                                                data-foto_kursi="{{ $train->foto_kursi ? asset('storage/'.$train->foto_kursi) : '' }}"
                                                data-total_seats="{{ $train->total_seats ?? 0 }}"
                                                data-seat_rows="{{ $train->rows ?? 0 }}"
                                                data-seat_cols="{{ $train->cols ?? 0 }}"
                                                data-rows="{{ $train->rows ?? 0 }}"
                                                data-cols="{{ $train->cols ?? 0 }}"
                                                data-layout='@json($train->layout)'>Ubah</button>

                                            <button type="button" class="btn btn-danger btn-xs btn-delete-train"
                                                data-toggle="modal" data-target="#modal-delete-train"
                                                data-id="{{ $train->id }}" data-name="{{ $train->name }}"
                                                data-nopol="{{ $train->nopol }}">Hapus</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div></div>
            </div>
        </section>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modal-edit-train">
        <div class="modal-dialog modal-lg"><div class="modal-content">
            <form id="form-edit-train" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h4 class="modal-title">Form Edit Armada</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Armada</label>
                        <input type="text" class="col-sm-10 form-control" name="name" id="edit-name" required></div>
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Kelas</label>
                        <input type="text" class="col-sm-10 form-control" name="class" id="edit-class" required></div>
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Nopol</label>
                        <input type="text" class="col-sm-10 form-control" name="nopol" id="edit-nopol" required></div>

                    {{-- Foto Armada & Foto Kursi (BARU) --}}
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Foto Armada</label>
                        <input type="file" class="col-sm-10 form-control" name="foto_armada" id="edit-foto-armada" accept="image/*">
                        <div class="col-sm-10 offset-sm-2 mt-2" id="edit-foto-armada-preview-wrap" style="display:none;">
                            <img id="edit-foto-armada-preview" src="" width="120">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Foto Kursi</label>
                        <input type="file" class="col-sm-10 form-control" name="foto_kursi" id="edit-foto-kursi" accept="image/*">
                        <div class="col-sm-10 offset-sm-2 mt-2" id="edit-foto-kursi-preview-wrap" style="display:none;">
                            <img id="edit-foto-kursi-preview" src="" width="120">
                        </div>
                    </div>

                    {{-- ===== Seat Layout Builder (Edit) ===== --}}
                    <hr>
                    <div class="form-group">
                      <label class="d-block mb-1">Seat Layout Builder</label>

                      <div class="d-flex flex-wrap align-items-center">
                        <div class="form-inline mr-2 mb-2">
                          <label class="mr-2">Rows</label>
                          <input type="number" id="slbR_edit" class="form-control form-control-sm" value="10" min="1" style="width:90px">
                        </div>
                        <div class="form-inline mr-2 mb-2">
                          <label class="mr-2">Cols</label>
                          <input type="number" id="slbC_edit" class="form-control form-control-sm" value="4" min="1" style="width:90px">
                        </div>

                        <button type="button" id="slbGen_edit" class="btn btn-primary btn-sm mr-2 mb-2">Generate Grid</button>

                        <div class="custom-control custom-checkbox mr-3 mb-2">
                          <input type="checkbox" class="custom-control-input" id="slbAuto_edit" checked>
                          <label class="custom-control-label" for="slbAuto_edit">Auto-number seats</label>
                        </div>

                        <button type="button" id="slbFill_edit"  class="btn btn-success btn-sm mr-2 mb-2">Pilih Semua</button>
                        <button type="button" id="slbClear_edit" class="btn btn-secondary btn-sm mb-2">Kosongkan</button>
                      </div>

                      <small class="text-muted d-block mb-2">
                        Klik kotak untuk toggle: <span class="badge badge-success">Kursi</span> / <span class="badge badge-light">Kosong</span>.
                      </small>

                      <div id="slbGrid_edit" class="border p-2" style="display:inline-block; max-width:100%; overflow:auto;"></div>

                      <div class="mt-2">
                        <strong>Ringkasan:</strong> <span id="slbSum_edit">0 seats • 0 rows × 0 cols</span>
                      </div>
                    </div>

                    {{-- Hidden fields untuk EDIT --}}
                    <textarea name="layout" id="slbLayout_edit" class="d-none"></textarea>
                    <input type="hidden" name="total_seats" id="slbTotal_edit">
                    <input type="hidden" name="rows"        id="slbRows_edit">
                    <input type="hidden" name="cols"        id="slbCols_edit">

                    {{-- textarea sumber preload (diisi via tombol Edit) --}}
                    <textarea id="edit-layout" class="d-none"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div></div>
    </div>

    {{-- Modal Hapus --}}
    <div class="modal fade" id="modal-delete-train">
        <div class="modal-dialog"><div class="modal-content">
            <form id="form-delete-train" method="POST">@csrf @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Armada</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body"><p id="delete-text">Apakah yakin?</p></div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Ya</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div></div>
    </div>

    {{-- CSS Seat Builder --}}
    <style>
      .slb-row { display:flex; }
      .slb-cell {
        width: 36px; height: 36px; margin: 3px; border: 1px solid #ccc;
        border-radius: 6px; display:flex; align-items:center; justify-content:center;
        user-select:none; cursor:pointer; font-size:12px; background:#f8f9fa;
      }
      .slb-cell.seat { background:#d4edda; border-color:#28a745; }
      .slb-cell.seat span { font-weight:600; }
      @media (max-width: 420px){
        .slb-cell{ width:30px;height:30px;margin:2px;font-size:11px; }
      }
    </style>

    {{-- Scripts --}}
    <script>
    /** ===== Utility Builder ===== */
    function makeSeatBuilder(cfg){
      const rootGrid = document.getElementById(cfg.gridId);
      const rInp     = document.getElementById(cfg.rowsId);
      const cInp     = document.getElementById(cfg.colsId);
      const genBtn   = document.getElementById(cfg.genId);
      const fillBtn  = document.getElementById(cfg.fillId);
      const clearBtn = document.getElementById(cfg.clearId);
      const autoCb   = document.getElementById(cfg.autoId);
      const sumEl    = document.getElementById(cfg.sumId);

      let R = 0, C = 0;
      let matrix = []; // true = seat, false = empty

      const pad2 = n => n.toString().padStart(2,'0');

      function buildEmpty(rows, cols){
        R = Math.max(1, parseInt(rows||'1',10));
        C = Math.max(1, parseInt(cols||'1',10));
        matrix = Array.from({length:R}, _ => Array.from({length:C}, _ => false));
        render();
        updateSummary();
      }

      function setFromLayout(layout2d){
        if(!Array.isArray(layout2d) || layout2d.length === 0){
          buildEmpty(rInp.value, cInp.value);
          return;
        }
        R = layout2d.length;
        C = layout2d[0]?.length || 0;
        rInp.value = R;
        cInp.value = C;
        matrix = Array.from({length:R}, (_,r)=> Array.from({length:C},(_,c)=> !!(layout2d[r][c] && layout2d[r][c] !== "")));
        render();
        renumber();
        updateSummary();
      }

      function render(){
        rootGrid.innerHTML = '';
        for(let r=0;r<R;r++){
          const row = document.createElement('div');
          row.className = 'slb-row';
          for(let c=0;c<C;c++){
            const cell = document.createElement('div');
            cell.className = 'slb-cell' + (matrix[r][c] ? ' seat' : '');
            cell.dataset.r = r; cell.dataset.c = c;
            const span = document.createElement('span');
            cell.appendChild(span);
            cell.addEventListener('click', e=>{
              const rr = +e.currentTarget.dataset.r;
              const cc = +e.currentTarget.dataset.c;
              matrix[rr][cc] = !matrix[rr][cc];
              e.currentTarget.classList.toggle('seat', matrix[rr][cc]);
              renumber(); updateSummary();
            });
            row.appendChild(cell);
          }
          rootGrid.appendChild(row);
        }
        renumber();
      }

      function renumber(){
        const labels = rootGrid.querySelectorAll('.slb-cell span');
        labels.forEach(sp => sp.textContent = '');
        if(!autoCb.checked) return;
        let no=1;
        for(let r=0;r<R;r++){
          for(let c=0;c<C;c++){
            if(matrix[r][c]){
              const cell = rootGrid.children[r].children[c];
              cell.querySelector('span').textContent = pad2(no++);
            }
          }
        }
      }

      function updateSummary(){
        sumEl.textContent = `${countSeats()} seats • ${R} rows × ${C} cols`;
      }

      function countSeats(){
        let t=0; for(let r=0;r<R;r++) for(let c=0;c<C;c++) if(matrix[r][c]) t++;
        return t;
      }

      function toJson(){
        let no=1, out=[];
        for(let r=0;r<R;r++){
          const row=[];
          for(let c=0;c<C;c++){
            row.push(matrix[r][c] ? pad2(no++) : "");
          }
          out.push(row);
        }
        return out;
      }

      genBtn && genBtn.addEventListener('click', ()=> {
        buildEmpty(rInp.value, cInp.value);
      });
      fillBtn && fillBtn.addEventListener('click', ()=>{
        for(let r=0;r<R;r++) for(let c=0;c<C;c++) matrix[r][c]=true;
        render(); updateSummary();
      });
      clearBtn && clearBtn.addEventListener('click', ()=>{
        for(let r=0;r<R;r++) for(let c=0;c<C;c++) matrix[r][c]=false;
        render(); updateSummary();
      });
      autoCb && autoCb.addEventListener('change', renumber);

      // init default
      buildEmpty(rInp.value, cInp.value);

      return {
        setFromLayout,
        getRows: ()=>R,
        getCols: ()=>C,
        getTotal: ()=>countSeats(),
        getLayoutJson: ()=>toJson()
      };
    }

    document.addEventListener('DOMContentLoaded',function(){
        // === Tombol Edit ===
        $(document).on('click','.btn-edit-train',function(){
            const id=$(this).data('id');
            $('#form-edit-train').attr('action','/trains/'+id);
            $('#edit-name').val($(this).data('name'));
            $('#edit-class').val($(this).data('class'));
            $('#edit-nopol').val($(this).data('nopol'));

            // Preview foto armada
            const fArmada=$(this).data('foto_armada');
            if(fArmada){
              $('#edit-foto-armada-preview').attr('src',fArmada);
              $('#edit-foto-armada-preview-wrap').show();
            } else {
              $('#edit-foto-armada-preview-wrap').hide();
            }

            // Preview foto kursi
            const fKursi=$(this).data('foto_kursi');
            if(fKursi){
              $('#edit-foto-kursi-preview').attr('src',fKursi);
              $('#edit-foto-kursi-preview-wrap').show();
            } else {
              $('#edit-foto-kursi-preview-wrap').hide();
            }

            // Simpan layout ke textarea preload
            let layout=$(this).data('layout'); if(typeof layout==='object') layout=JSON.stringify(layout);
            $('#edit-layout').val(layout??'');

            // Prefill rows/cols input edit jika tersedia
            const r = $(this).data('rows') ?? $(this).data('seat_rows') ?? 0;
            const c = $(this).data('cols') ?? $(this).data('seat_cols') ?? 0;
            if(r) $('#slbR_edit').val(r);
            if(c) $('#slbC_edit').val(c);
        });

        // === Tombol Hapus ===
        $(document).on('click','.btn-delete-train',function(){
            const id=$(this).data('id');
            $('#form-delete-train').attr('action','/trains/'+id);
            $('#delete-text').html('Hapus armada <b>'+$(this).data('name')+'</b> ('+$(this).data('nopol')+') ?');
        });

        /* ====== Instance TAMBAH ====== */
        const addForm = document.querySelector('#modal-tambah-train form');
        const sbAdd = makeSeatBuilder({
          gridId:'slbGrid', rowsId:'slbR', colsId:'slbC',
          genId:'slbGen', fillId:'slbFill', clearId:'slbClear',
          autoId:'slbAuto', sumId:'slbSum'
        });

        // Prefill dari old('layout') jika ada
        try {
          const oldLayout = document.getElementById('slbLayout').textContent.trim();
          if(oldLayout){
            const parsed = JSON.parse(oldLayout);
            sbAdd.setFromLayout(parsed);
          }
        } catch(e){}

        addForm && addForm.addEventListener('submit', function(){
          document.getElementById('slbLayout').value = JSON.stringify(sbAdd.getLayoutJson());
          document.getElementById('slbTotal').value  = sbAdd.getTotal();
          document.getElementById('slbRows').value   = sbAdd.getRows();
          document.getElementById('slbCols').value   = sbAdd.getCols();
        });

        /* ====== Instance EDIT (dibuat saat modal tampil) ====== */
        let sbEdit = null;

        $('#modal-edit-train').on('shown.bs.modal', function(){
          if(!sbEdit){
            sbEdit = makeSeatBuilder({
              gridId:'slbGrid_edit', rowsId:'slbR_edit', colsId:'slbC_edit',
              genId:'slbGen_edit', fillId:'slbFill_edit', clearId:'slbClear_edit',
              autoId:'slbAuto_edit', sumId:'slbSum_edit'
            });
          }
          // Ambil layout dari textarea yang diisi saat klik Edit
          let layoutText = document.getElementById('edit-layout').value;
          try{
            if(layoutText){
              const parsed = JSON.parse(layoutText);
              sbEdit.setFromLayout(parsed);
            }
          }catch(e){}
        });

        const editForm = document.getElementById('form-edit-train');
        editForm && editForm.addEventListener('submit', function(){
          if(!sbEdit) return;
          document.getElementById('slbLayout_edit').value = JSON.stringify(sbEdit.getLayoutJson());
          document.getElementById('slbTotal_edit').value  = sbEdit.getTotal();
          document.getElementById('slbRows_edit').value   = sbEdit.getRows();
          document.getElementById('slbCols_edit').value   = sbEdit.getCols();
        });
    });
    </script>

    <footer class="main-footer"><strong>Sonic &copy; {{ date('Y') }}.</strong></footer>
</div>
@endsection
