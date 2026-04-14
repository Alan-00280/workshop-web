@extends('layouts.app')

@section('db-page-title', 'Data Customer')
@section('icon-page')
    <i class="fa-solid fa-users"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>Data Customer</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="container-fluid mt-2" style="padding-left:0">

        <div class="d-flex align-items-center mb-3 gap-3" style="margin-right: 12px">
            <a href="{{ route('create-v1-customer') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i>
                Tambahkan Customer v1
            </a>

            <a href="{{ route('create-v2-customer') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i>
                Tambahkan Customer v2
            </a>
        </div>

        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-users me-2 text-primary"></i>Daftar Seluruh
                    Customer</h5>
            </div>
            {{-- <x-logger object="{{ $customers }}" /> --}}
            {{-- @dd($customers) --}}
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered w-100 align-middle" id="customerTable">
                        <thead class="table-light">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="20%">Nama Customer</th>
                                <th width="40%">Alamat Lengkap</th>
                                <th width="10%">Kode Pos</th>
                                <th width="10%">Foto Customer</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $index => $customer)
                                @php
                                    $kelurahan = $customer->kelurahan ? json_decode($customer->kelurahan) : null;
                                @endphp

                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>

                                    <td class="fw-bold text-dark">{{ $customer->nama }}</td>

                                    <td>
                                        <div class="text-dark">{{ $customer->alamat }}</div>

                                        <div class="text-muted small mt-1">
                                            @if($kelurahan)
                                                <i class="fa-solid fa-map-location-dot me-1 text-primary"></i>

                                                Kel/Desa {{ $kelurahan->nama ?? '-' }},
                                                Kec. {{ $kelurahan->kecamatan->nama ?? '-' }},
                                                {{ $kelurahan->kecamatan->kota->nama ?? '-' }},
                                                Prov. {{ $kelurahan->kecamatan->kota->provinsi->nama ?? '-' }}
                                            @else
                                                <span class="text-danger">
                                                    <i class="fa-solid fa-triangle-exclamation me-1"></i>
                                                    Wilayah tidak ditemukan / terhapus
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge bg-light text-secondary border">
                                            {{ $customer->kode_pos }}
                                        </span>
                                    </td>

                                    <td>
                                        @if($customer->foto_path)
                                            <img src="{{ asset($customer->foto_path) }}" width="60" class="rounded"
                                                 style="cursor:pointer;"
                                                 data-bs-toggle="modal" data-bs-target="#modalFoto"
                                                 data-src="{{ asset($customer->foto_path) }}"
                                                 data-nama="{{ $customer->nama }}">
                                        @elseif($customer->foto_blob)
                                            <img src="{{ route('customer-foto-blob', $customer->id) }}" width="60" class="rounded"
                                                 style="cursor:pointer;"
                                                 data-bs-toggle="modal" data-bs-target="#modalFoto"
                                                 data-src="{{ route('customer-foto-blob', $customer->id) }}"
                                                 data-nama="{{ $customer->nama }}">
                                        @else
                                            <span class="text-muted">Tidak ada foto</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <form action="{{ route('destroy-customer', $customer->id) }}" method="POST" class="form-delete-customer" data-nama="{{ $customer->nama }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">
                                                <i class="fa-solid fa-trash me-1"></i>Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- Modal Preview Foto --}}
    <div class="modal fade" id="modalFoto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold" id="modalFotoNama"></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center pt-2 pb-4">
                    <img id="modalFotoImg" src="" alt="Foto Customer" class="img-fluid rounded-3" style="max-height:400px;">
                </div>
            </div>
        </div>
    </div>

@endsection

{{-- CDNs Datatable & jQuery (Required) --}}
@push('page_style')
    <!-- Datatable CSS CDN -->
    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.3/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .card.shadow-sm {
            box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.05) !important;
        }

        .text-primary {
            color: #7e22ce !important;
        }

        .bg-primary {
            background-color: #a855f7 !important;
        }

        .btn-outline-primary {
            color: #a855f7 !important;
            border-color: #a855f7 !important;
        }

        .btn-outline-primary:hover {
            background-color: #a855f7 !important;
            border-color: #a855f7 !important;
            color: white !important;
        }

        div.dt-container .dt-paging .pagination .page-item.active .page-link {
            background-color: #a855f7;
            border-color: #a855f7;
            border-radius: 5px;
        }
    </style>
@endpush

@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.3/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"
        integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function () {
            // Inisialisasi DataTable
            $('#customerTable').DataTable({
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
                },
                columnDefs: [
                    { orderable: false, targets: [4, 5] }
                ]
            });

            // Modal preview foto
            document.getElementById('modalFoto').addEventListener('show.bs.modal', function (e) {
                const img = e.relatedTarget;
                document.getElementById('modalFotoImg').src  = img.dataset.src;
                document.getElementById('modalFotoNama').textContent = img.dataset.nama;
            });

            // Hapus customer dengan SweetAlert
            $('.form-delete-customer').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                const nama = $(this).data('nama');
                
                Swal.fire({
                    title: 'Hapus Customer?',
                    text: `Anda yakin ingin menghapus data customer "${nama}"? Data tidak dapat dikembalikan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fa-solid fa-trash me-1"></i> Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush