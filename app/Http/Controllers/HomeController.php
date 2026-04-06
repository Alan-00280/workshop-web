<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Buku;
use App\Models\DetailPesananModel;
use App\Models\Kategori;
use App\Models\Keranjang;
use App\Models\MenuModel;
use App\Models\PesananModel;
use Illuminate\Http\Request;
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
        return view(
            'marketplace.products',
            [
                'products' => $products
            ]
        );
    }

    public function storeShow()
    {
        return view(
            'marketplace.store',
            [

            ]
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

    // VENDOR PAGES CONTROLLER
    public function storeVendorShow()
    {
        return view(
            'vendor.store.view',
            [

            ]
        );
    }

    public function productsVendorShow()
    {
        $products = MenuModel::with('vendor')->paginate(8);
        return view('vendor.products.view', [
            'products' => $products
        ]);
    }

    public function productsVendorEdit($id)
    {
        $product = MenuModel::findOrFail($id);
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
        $pesanans = PesananModel::all()->toArray();
        $menus = MenuModel::all()->keyBy('idmenu');

        foreach ($pesanans as &$pesanan) {
            $metodeId = $pesanan['metode_bayar'];
            $pesanan['metode_bayar'] = PesananModel::METODE_ID[$metodeId] ?? 'unknown';
        }

        $detailPesanans = DetailPesananModel::all();
        $groupedDetails = [];

        foreach ($detailPesanans as $detail) {
            $menu = $menus[$detail['idmenu']] ?? null;

            $detail['nama_menu'] = $menu ? $menu->nama_menu : 'menu tidak ditemukan';

            $groupedDetails[$detail['idpesanan']][] = $detail;
        }
        return view('vendor.orders.view', compact('pesanans', 'groupedDetails'));
    }
}
