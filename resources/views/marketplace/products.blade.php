@extends('layouts.guest')
@section('title', 'Our Products - Purpily Dessert')

@push('page_style')
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">
    </link>
    <style>
        /* Page Style Here */
    </style>
@endpush

@section('content')
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary">Pilihan Untukmu</h1>
        <p class="text-muted fs-5">Pesan hidangan manis untuk harimu</p>
    </div>

    <!-- Filters & Sorting Options -->
    <div class="filter-section mb-5">
        <form action="" id="filter-product-form" method="GET" class="row g-3 align-items-end">
            <!-- Search by Name -->
            <div class="col-md-5">
                <label for="search" class="form-label fw-bold text-muted">Cari Nama Produk</label>
                <input type="text" class="form-control rounded-pill px-3" id="search" name="search"
                    placeholder="Contoh: Cheesecake">
            </div>

            <!-- Filter by Price Range -->
            <div class="col-md-3">
                <label class="form-label fw-bold text-muted">Rentang Harga (Maksimal)</label>
                <div class="input-group">
                    <span class="input-group-text rounded-start-pill bg-light border-end-0">Rp</span>
                    <input type="number" class="form-control rounded-end-pill border-start-0 px-2" id="max_price"
                        name="max_price" placeholder="50000">
                </div>
            </div>

            <!-- Filter by Vendor -->
            <div class="col-md-4">
                <label for="vendor" class="form-label fw-bold text-muted">Pilih Vendor</label>
                <select id="vendor" name="vendor">
                    <option value="">Semua Vendor</option>
                    @foreach($vendors as $v)
                        <option value="{{ $v->idvendor }}">{{ $v->nama_vendor }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Sorting Options -->
            {{-- <div class="col-md-2">
                <label for="sort" class="form-label fw-bold text-muted">Urutkan</label>
                <select class="form-select rounded-pill px-3" id="sort" name="sort">
                    <option value="">Pilih</option>
                    <option value="price_asc">Harga Terendah</option>
                    <option value="price_desc">Harga Tertinggi</option>
                    <option value="name_asc">Nama (A-Z)</option>
                </select>
            </div> --}}

            {{-- <div class="col-md-1 d-flex">
                <button type="button" class="btn btn-primary rounded-pill w-100 shadow-sm"
                    onclick="alert('Ini hanya data dummy. Filter belum aktif.')">Terapkan</button>
            </div> --}}
        </form>
    </div>

    <!-- Product Container (4 columns) -->
    <div id="container-products" class="row g-4 justify-content-center mb-5">
        {{-- diisi oleh AJAX --}}
    </div>
    <div class="d-flex w-75 mx-auto justify-content-end">
        <div class="pagination-container"></div>
    </div>

    {{-- STORES CONTAINER --}}
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary">Our Stores</h1>
        <p class="text-muted fs-5">Buka Store Purpily Dessert & Bakery Kami</p>
    </div>

    <div class="row g-4 justify-content-center mb-5">
        @foreach ($vendors as $vendor)
            <div class="col-md-4">
                <a href="{{ route('store-show', ['id' => $vendor->idvendor]) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 bg-white menu-card shadow-sm p-4 text-center">
                        <div class="display-3 mb-3 text-primary"><i class="fa-solid fa-store"></i></div>
                        <h4 class="card-title fw-bold text-dark mb-2">{{ $vendor->nama_vendor }}</h4>
                        <p class="text-muted fs-6 mb-0">Kunjungi Toko <i class="fa-solid fa-arrow-right ms-1"></i></p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.js"></script>
    <script>
        const storeBaseUrl = "{{ route('store-show', ['id' => '__ID__']) }}";
    </script>
    <script>
        let currentPage = 1;
        let currentParams = {};


        function renderMenu(data) {
            const container = $('#container-products');
            container.empty();

            if (data.length === 0) {
                container.append(`
                                                    <div class="text-center py-5">
                                                        <i class="bi bi-search fs-1 text-muted"></i>
                                                        <p class="text-muted mt-3">Menu tidak ditemukan</p>
                                                    </div>
                                                `);
                return;
            }

            $.each(data, function (index, product) {
                const harga = new Intl.NumberFormat('id-ID').format(product.harga);
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                const storeUrl = storeBaseUrl.replace('__ID__', product.vendor.idvendor);

                const card = `
                                                    <div class="col-md-6 col-lg-3">
                                                        <div class="card h-100 border-0 bg-white menu-card shadow-sm">
                                                            <img src="${product.path_gambar}" alt="${product.nama_menu}"
                                                                class="card-img-top border-bottom border-3 border-white" style="height: 220px; object-fit: cover;">

                                                            <div class="card-body d-flex flex-column text-center">
                                                                <div>
                                                                    <span class="vendor-badge">
                                                                        <i class="bi bi-shop me-1"></i>${product.vendor.nama_vendor}
                                                                    </span>
                                                                </div>

                                                                <h5 class="card-title fw-bold text-dark mb-2">${product.nama_menu}</h5>

                                                                <div class="mt-auto">
                                                                    <p class="card-text text-primary fw-bold fs-5 mb-3">Rp ${harga}</p>

                                                                    <div class="d-flex justify-content-between">
                                                                        <a href="${storeUrl}" 
                                                                        class="btn btn-outline-primary p-2 text-decoration-none d-flex align-items-center rounded-pill shadow-sm fw-bold">
                                                                            <i class="fa-solid fa-store"></i>
                                                                        </a>
                                                                        <form class="w-75 mx-auto" action="/cart" method="post">
                                                                            <input type="hidden" name="_token" value="${csrfToken}">
                                                                            <input type="hidden" name="idmenu" value="${product.idmenu}">
                                                                            <input type="hidden" name="quantity" value="1">
                                                                            <button type="submit"
                                                                                class="btn btn-primary p-2 rounded-pill shadow-sm fw-bold w-100">
                                                                                Tambah ke Keranjang
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                `;

                container.append(card);
            });
        }

        function renderPagination(pagination) {
            const { current_page, last_page } = pagination;
            let html = '<ul class="pagination justify-content-end">';

            // Tombol Prev
            html += `
                                    <li class="page-item ${current_page === 1 ? 'disabled' : ''}">
                                        <a class="page-link" href="#" data-page="${current_page - 1}">«</a>
                                    </li>
                                `;

            // Nomor halaman
            for (let i = 1; i <= last_page; i++) {
                html += `
                                        <li class="page-item ${i === current_page ? 'active' : ''}">
                                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                                        </li>
                                    `;
            }

            // Tombol Next
            html += `
                                    <li class="page-item ${current_page === last_page ? 'disabled' : ''}">
                                        <a class="page-link" href="#" data-page="${current_page + 1}">»</a>
                                    </li>
                                `;

            html += '</ul>';

            $('.pagination-container').html(html);
        }

        function filterMenu(page = 1) {
            currentPage = page;
            currentParams = {
                nama: $('#search').val(),
                idvendor: $('#vendor').val(),
                max_price: $('#max_price').val(),
                page: page,
            };

            $.ajax({
                url: '/products/filter',
                method: 'GET',
                data: currentParams,
                success: function (res) {
                    if (res.success) {
                        renderMenu(res.data);
                        renderPagination(res.pagination);
                    }
                },
                error: function (xhr) {
                    console.error('Filter gagal:', xhr.responseText);
                }
            });
        }

        $(document).ready(function () {
            filterMenu(1)
            var filter_vendor = new SlimSelect({ select: '#vendor' })

            // Listeners
            $('#search').on('input', () => filterMenu(1));
            $('#vendor').on('change', () => filterMenu(1));
            $('#max_price').on('input', () => filterMenu(1));

            $(this).on('click', '.pagination .page-link', function (e) {
                e.preventDefault();
                const page = $(this).data('page');
                if (page) filterMenu(page);
            });
        })

    </script>
@endpush