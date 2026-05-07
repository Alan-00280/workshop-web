<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Buku;
use App\Models\CustomerModel;
use App\Models\DetailPesananModel;
use App\Models\Kategori;
use App\Models\Keranjang;
use App\Models\MenuModel;
use App\Models\PesananModel;
use App\Models\ProvinsiModel;
use App\Models\VendorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        // $this->middleware('auth');
    }

    // ----------------------------------------
    // GUEST PAGES
    // ----------------------------------------

    public function landingPage()
    {
        return view(
            'landing',
            [
                'products' => MenuModel::inRandomOrder()->take(4)->get()
            ]
        );
    }

    public function productsPage()
    {
        $products = MenuModel::with('vendor')->paginate(6);
        $vendors = VendorModel::all();
        return view(
            'marketplace.products',
            compact('products', 'vendors')
        );
    }

    public function storeShow($id)
    {
        $store = VendorModel::find($id);
        $store_products = MenuModel::with('vendor')->where('idvendor', $store->idvendor)->get();

        return view(
            'marketplace.store',
            compact('store', 'store_products')
        );
    }

    public function cartShow()
    {
        $cart_items = Keranjang::with('menu')->get();

        return view(
            'guest.cart',
            [
                'cart_items' => $cart_items
            ]
        );
    }

    public function checkoutShow()
    {
        $cart_items = Keranjang::with('menu.vendor')->get();

        return view(
            'guest.checkout',
            [
                'cart_items' => $cart_items
            ]
        );
    }

    public function ordersShow() 
    {
        $orders = PesananModel::all();
        
        return view(
            'guest.orders',
            compact('orders')
        );
    }
    
    // ----------------------------------------
    // ADMINISTRATOR PAGES
    // ----------------------------------------

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function dashboard()
    {
        $user_role_id = Session::get('user_id_role');
        if ($user_role_id == 1) {
            return view('dashboard.index', [

            ]);
        } elseif ($user_role_id == 3) {
            return view(
                'vendor.index-dashboard',
                [

                ]
            );
        }
        return view('home');
    }

    public function book()
    {
        $books = Buku::with('KategoriBuku')->get();
        return view(
            'dashboard.book',
            [
                'books' => $books
            ]
        );
    }

    public function addBook()
    {
        return view('dashboard.add-book', [
            'catagories' => Kategori::all()
        ]);
    }

    public function editBook($id)
    {
        $catagories = Kategori::all();
        $book = Buku::where('idbuku', $id)->with('KategoriBuku')->first();

        return view(
            'dashboard.edit-book',
            [
                'catagories' => $catagories,
                'book' => $book
            ]
        );
    }

    public function bookCategories()
    {
        $catagories = Kategori::all();
        return view(
            'dashboard.bookCategories',
            [
                'catagories' => $catagories
            ]
        );
    }

    public function createDocument()
    {
        return view('dashboard.create-document');
    }
    public function createCertificate()
    {
        return view('dashboard.create-certificate');
    }
    public function createInvitation()
    {
        return view('dashboard.create-invitation');
    }

    public function showBarang()
    {
        return view(
            'dashboard.barang.show',
            [
                'barangs' => Barang::all()
            ]
        );
    }

    public function editBarang($id)
    {
        $barang = Barang::where('id_barang', $id)->first();
        return view(
            'dashboard.barang.edit',
            [
                'barang' => $barang
            ]
        );
    }

    public function addBarang()
    {
        return view(
            'dashboard.barang.create'
        );
    }

    public function showBarangV2()
    {
        return view(
            'dashboard.barangv2.view'
        );
    }

    public function showScanBarcode() {
        return view(
            'dashboard.barang.scan.view'
        );
    }

    public function showBarangV2Datatable()
    {
        return view(
            'dashboard.barangv2.view-datatable'
        );
    }

    public function daftarKotaShow()
    {
        return view(
            'dashboard.kota.view'
        );
    }

    public function wilayahShow()
    {
        return view(
            'dashboard.wilayah.view'
        );
    }

    public function wilayahShowAxios()
    {
        return view(
            'dashboard.wilayah.view-axios'
        );
    }

    public function POSShow()
    {
        return view(
            'dashboard.pos.view'
        );
    }

    public function POSShowAxios()
    {
        return view(
            'dashboard.pos.view-axios'
        );
    }

    public function customerShow() {
        // $customers = CustomerModel::with('kelurahan.kecamatan.kota.provinsi')->get();
        $customers = DB::select("SELECT 
    c.*,
    json_build_object(
        'nama', v.name,
        'kecamatan', json_build_object(
            'nama', d.name,
            'kota', json_build_object(
                'nama', r.name,
                'provinsi', json_build_object(
                    'nama', p.name
                )
            )
        )
    ) AS kelurahan
FROM customers c
LEFT JOIN reg_villages v ON v.id = c.kelurahan_id
LEFT JOIN reg_districts d ON d.id = v.district_id
LEFT JOIN reg_regencies r ON r.id = d.regency_id
LEFT JOIN reg_provinces p ON p.id = r.province_id;");

        return view(
            'dashboard.customer.view',
            compact('customers')
        );
    }

    public function customerCreatev1() {
        $provinces = ProvinsiModel::all();

        return view(
            'dashboard.customer.create-vone',
            compact('provinces')
        );
    }

    public function customerCreatev2() {
        $provinces = ProvinsiModel::all();

        return view(
            'dashboard.customer.create-vtwo',
            compact('provinces')
        );
    }

    // ---------------------------------
    // VENDOR PAGES CONTROLLER
    // ---------------------------------
    public function storeVendorShow()
    {
        $isAdmin = Session::get('user_id_role') === 1;

        $store = VendorModel::find(Session::get('idvendor'));
        $stores = VendorModel::all();

        if ($isAdmin) {
            return view(
                'vendor.store.admin-view',
                compact('stores')
            );
        }

        return view(
            'vendor.store.view',
            compact('store')
        );
    }

    public function productsVendorShow()
    {
        $idvendor = Session::get('idvendor');
        $isAdmin = Session::get('user_id_role') === 1;

        $products = MenuModel::with('vendor')
            ->where('idvendor', $idvendor)
            ->paginate(8);

        $allProducts = MenuModel::with('vendor')->paginate(8);

        if ($isAdmin) {
            return view(
                'vendor.products.admin-view',
                compact('allProducts')
            );
        }

        return view('vendor.products.view', [
            'products' => $products
        ]);
    }

    public function productsVendorEdit($id)
    {
        $idvendor = Session::get('idvendor');

        $product = MenuModel::where('idmenu', $id)
            ->where('idvendor', $idvendor)
            ->firstOrFail();

        return view('vendor.products.edit', [
            'product' => $product
        ]);
    }

    public function productsVendorAdd()
    {
        return view('vendor.products.create', [

        ]);
    }

    public function ordersVendorShow()
    {
        $isAdmin = Session::get('user_id_role') === 1;

        if ($isAdmin) {
            $menus = MenuModel::with('vendor')->get()->keyBy('idmenu');
            $detailPesanans = DetailPesananModel::all();
            
            $pesananIds = $detailPesanans->pluck('idpesanan')->unique();
            $pesanans = PesananModel::whereIn('idpesanan', $pesananIds)->get()->toArray();
        } else {
            $idvendor = Session::get('idvendor');
            $menus = MenuModel::where('idvendor', $idvendor)->get()->keyBy('idmenu');
            $menuIds = $menus->keys()->toArray();
            
            $detailPesanans = DetailPesananModel::whereIn('idmenu', $menuIds)->get();
            $pesananIds = $detailPesanans->pluck('idpesanan')->unique();
            $pesanans = PesananModel::whereIn('idpesanan', $pesananIds)->get()->toArray();
        }

        foreach ($pesanans as &$pesanan) {
            $metodeId = $pesanan['metode_bayar'];
            $pesanan['metode_bayar'] = PesananModel::METODE_ID[$metodeId] ?? 'unknown';
        }

        $groupedDetails = [];
        $vendorTotals = []; // ← tambah ini

        foreach ($detailPesanans as $detail) {
            $menu = $menus[$detail->idmenu] ?? null;

            $detailArray = $detail->toArray();
            $detailArray['nama_menu'] = $menu ? $menu->nama_menu : 'menu tidak ditemukan';
            if ($isAdmin && $menu && $menu->vendor) {
                $detailArray['nama_vendor'] = $menu->vendor->nama_vendor;
            }

            $groupedDetails[$detail->idpesanan][] = $detailArray;

            // Akumulasi total per pesanan khusus vendor ini (atau total keseluruhan untuk admin)
            $vendorTotals[$detail->idpesanan] = ($vendorTotals[$detail->idpesanan] ?? 0) + $detail->subtotal;
        }

        if ($isAdmin) {
            return view(
                'vendor.orders.admin-view',
                compact('pesanans', 'groupedDetails', 'vendorTotals')
            );
        }

        return view('vendor.orders.view', compact('pesanans', 'groupedDetails', 'vendorTotals'));
    }

    public function scanQRShow()
    {
        return view('vendor.orders.scan-qr');
    }
}
