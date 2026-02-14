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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($catagories) > 0)
                            @foreach ($catagories as $category)
                                <tr>
                                    <td><span class="badge bg-dark">{{ $category->idkategori }}</span></td>
                                    <td>{{ $category->nama_kategori }}</td>
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
                                            <form action="" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
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

@section('modal')
    <!-- Modal Add Kategori -->
    <div class="modal fade" id="modalKategori" tabindex="-1" aria-labelledby="modalKategoriLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ '#' }}" method="POST">
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
                            <label for="nama_kategori" class="form-label">
                                Nama Kategori
                            </label>

                            <div class="d-flex align-items-center" style="gap: 10px">
                            <input type="text" name="nama_kategori" id="nama_kategori"
                                class="form-control @error('nama_kategori') is-invalid @enderror"
                                value="{{ old('nama_kategori') }}" placeholder="Masukkan nama kategori">
                            <i class="fa-solid fa-pen-to-square fa-lg"></i>
                            </div>

                            @error('nama_kategori')
                                <div class="invalid-feedback">
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

    <!-- Modal Edit Kategori -->
    <div class="modal fade" id="modalEditKategori" tabindex="-1" aria-labelledby="modalEditKategoriLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ '#' }}" method="POST">
                    @csrf

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalEditKategoriLabel">
                            <i class="fa-solid fa-tags me-2"></i>
                            Edit Kategori Buku
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">
                                Nama Kategori
                            </label>

                            <div class="d-flex align-items-center" style="gap: 10px">
                            <input type="text" name="nama_kategori" id="nama_kategori"
                                class="form-control @error('nama_kategori') is-invalid @enderror"
                                value="{{ old('nama_kategori') }}" placeholder="Masukkan nama kategori">
                            <i class="fa-solid fa-pen-to-square fa-lg"></i>
                            </div>

                            @error('nama_kategori')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

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

@endsection

@section('script')
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

        //set the Form Action!

        const inputs = editCategoryModal.querySelectorAll('input')
        inputs.forEach((input) => {
            input.value = 'Loading . . .'
        })

        const namaKategori = editCategoryModal.querySelector('input#nama_kategori')
        const idkategori = e.currentTarget.dataset.idKategori
        // return console.log(idkategori)
        
        if(!idkategori) { return namaKategori.value = `No Data . . .` }

        try {
            const fetchCategory = await fetch(`/book-categories/${idkategori}`) // GET /book-categories/{id}
            let category = await fetchCategory.json()
            category = category[0]

            if (!category) {
                namaKategori.value = 'Fetch error!'
            }

            // console.log(category)
            namaKategori.value = category.nama_kategori

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
@endsection
