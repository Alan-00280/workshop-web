@extends('layouts.app')

@section('db-page-title', 'Kategori Buku')
@section('icon-page')
    <i class="fa-solid fa-book-bookmark"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>Kategori Buku</x-ui.breadcrumb-item>
@endsection

@section('content')
    {{-- <x-logger :object="$catagories" /> --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ "#" }}" data-bs-toggle="modal" data-bs-target="#modalKategori" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
            Tambahkan Kategori
        </a>
    </div>

    <div class="container mt-1" style="padding-left: 0">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Daftar Buku</h5>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th># ID Kategori</th>
                            <th>Nama Kategori</th>
                            <th>Prefix Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($catagories) > 0)
                            @foreach ($catagories as $category)
                                <tr>
                                    <td><span class="badge bg-dark">{{ $category->idkategori }}</span></td>
                                    <td>{{ $category->nama_kategori }}</td>
                                    <td>{{ $category->kode_kategori }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">

                                            <!-- Update Button -->
                                            <a 
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditKategori"
                                                data-id-kategori="{{ $category->idkategori }}" 
                                                class="btn btn-sm btn-warning update_cat_btn">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                Update
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('delete-book-categories', ['id' => $category->idkategori]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa-solid fa-trash"></i>
                                                    Delete
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>
                                    No Data...
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('modal')
    <!-- Modal Add Kategori -->
    <div class="modal fade" id="modalKategori" tabindex="-1" aria-labelledby="modalKategoriLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ route('create-book-categories') }}" method="POST">
                    @csrf

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalKategoriLabel">
                            <i class="fa-solid fa-tags me-2"></i>
                            Tambah Kategori Buku
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="kode_kategori" class="form-label">
                                Kode Kategori<span class="text-warning star">*</span>
                            </label>

                            <div class="d-flex align-items-center" style="gap: 10px">
                            <input type="text" name="kode_kategori_baru" id="kode_kategori_baru"
                                class="form-control"
                                value="{{ old('kode_kategori_baru') }}" 
                                placeholder="Masukkan kode kategori"
                                minlength="2" maxlength="5">
                            <i class="fa-solid fa-pen-to-square fa-lg"></i>
                            </div>
                            @error('kode_kategori_baru')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">
                                Nama Kategori<span class="text-warning star">*</span>
                            </label>

                            <div class="d-flex align-items-center" style="gap: 10px">
                            <input type="text" name="nama_kategori" id="nama_kategori"
                                class="form-control"
                                value="{{ old('nama_kategori') }}" placeholder="Masukkan nama kategori">
                            <i class="fa-solid fa-pen-to-square fa-lg"></i>
                            </div>

                            @error('nama_kategori')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-success">
                            <i class="fa-solid fa-save"></i>
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endpush

@push('script')
<script>
    const addCategoryModal = document.getElementById('modalKategori')

    const inputKode = addCategoryModal.querySelector('input#kode_kategori_baru');
    inputKode.addEventListener('input', (e) => {
        e.target.value = e.target.value.toUpperCase();
    })

    //reset value when closed
    addCategoryModal.addEventListener('hidden.bs.modal', () => {
        const inputs = addCategoryModal.querySelectorAll('input[name]:not([name^="_"])')
        inputs.forEach((input) => {
            input.value = '' 
        })
    });
</script>
@endpush

@push('modal')
    <!-- Modal Edit Kategori -->
    <div class="modal fade" id="modalEditKategori" tabindex="-1" aria-labelledby="modalEditKategoriLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalEditKategoriLabel">
                            <i class="fa-solid fa-tags me-2"></i>
                            Edit Kategori Buku
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="kode_kategori" class="form-label">
                                Kode Kategori
                            </label>

                            <div class="d-flex align-items-center" style="gap: 10px">
                            <input type="text" name="kode_kategori" id="kode_kategori"
                                class="form-control"
                                value="{{ old('kode_kategori') }}" 
                                placeholder="Masukkan kode kategori"
                                min="2" max="5">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">
                                Nama Kategori
                            </label>

                            <div class="d-flex align-items-center" style="gap: 10px">
                            <input type="text" name="nama_kategori_update" id="nama_kategori"
                                class="form-control"
                                value="" placeholder="Masukkan nama kategori">
                            <i class="fa-solid fa-pen-to-square fa-lg"></i>
                            </div>

                            @error('nama_kategori_update')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                    {{-- Hidden --}}
                    <input type="hidden" name="idkategori" id="id_kategori_field">
                    <input type="hidden" name="kode_kategori" id="kode_kategori_field">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancel-edit" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-success">
                            <i class="fa-solid fa-save"></i>
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endpush

@push('script')
<script>
    const editCategoryModal = document.getElementById('modalEditKategori')

    // To Remove The Stars :)
    editCategoryModal.addEventListener('hidden.bs.modal', () => {
        const stars = document.querySelectorAll('span.star');
        stars.forEach((star) => {
            star.remove();
        });
    });
    
    const setupEditCategory = async (e) => {
        // const inputs = editCategoryModal.querySelectorAll('input') //kocakkk 😭 => ini bakal ngubah nilai CSRF nya

        const inputs = editCategoryModal.querySelectorAll('input[name]:not([name^="_"])')
        inputs.forEach((input) => {
            input.value = 'Loading . . .' 
            input.disabled = true
        })

        const namaKategori = editCategoryModal.querySelector('input#nama_kategori')
        const kodeKategori = editCategoryModal.querySelector('input#kode_kategori')
        const idkategori = e.currentTarget.dataset.idKategori
        // return console.log(idkategori)
        
        if(!idkategori) { return namaKategori.value = `No Data . . .` }

        const idKategoriField = editCategoryModal.querySelector('input#id_kategori_field')
        idKategoriField.value = idkategori

        const kodeKategoryField = editCategoryModal.querySelector('input#kode_kategori_field')

        try {
            const fetchCategory = await fetch(`/book-categories/get/${idkategori}`) // GET /book-categories/get/{id}
            let category = await fetchCategory.json()
            category = category[0]

            if (!category) {
                namaKategori.value = 'Fetch error!'
            }

            // console.log(category)
            inputs.forEach((input) => {
                input.disabled = false
            })
            namaKategori.value = category.nama_kategori

            kodeKategori.disabled = true
            kodeKategori.value = category.kode_kategori
            kodeKategoryField.value = category.kode_kategori
            
            //set the Form Action!
            editCategoryModal.querySelector('form').action = `/book-categories/edit`
            // console.log(editCategoryModal.querySelector('form'))


        } catch (error) {
            console.log(error)
        }
        
    }

    const updateCategoriesBtn = document.querySelectorAll('.update_cat_btn')
    updateCategoriesBtn.forEach((btn) => {
        btn.addEventListener('click', (e) => setupEditCategory(e))
    })
    
    const editModalLabels = editCategoryModal.querySelectorAll('label')
    editModalLabels.forEach((label) => {
        const input = editCategoryModal.querySelector('input#'+label.getAttribute('for'))
        
        input.addEventListener('input', () => {
            if (!label.querySelector('span')) {
                label.innerHTML += ' <span class="text-danger star">*</span>'
            }
        })
    })
</script>
@endpush
