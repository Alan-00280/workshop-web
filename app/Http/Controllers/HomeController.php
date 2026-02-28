<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function dashboard() {
        return view('dashboard.index');
    }

    public function book() {
        $books = Buku::with('KategoriBuku')->get();
        return view('dashboard.book', 
            [
            'books' => $books
        ]);
    }

    public function addBook() {
        return view('dashboard.add-book', [
            'catagories' => Kategori::all()
        ]);
    }

    public function editBook($id) {
        $catagories = Kategori::all();
        $book = Buku::where('idbuku', $id)->with('KategoriBuku')->first();

        return view(
            'dashboard.edit-book', 
            [
            'catagories' => $catagories,
            'book' => $book
        ]);
    }

    public function bookCategories() {
        $catagories = Kategori::all();
        return view(
            'dashboard.bookCategories', 
            [
            'catagories' => $catagories
        ]);
    }

    public function createDocument() {
        return view('dashboard.create-document');
    }
    public function createCertificate() {
        return view('dashboard.create-certificate');
    }
    public function createInvitation() {
        return view('dashboard.create-invitation');
    }

    public function showBarang() {
        return view(
            'dashboard.barang.show',
            [
                'barangs' => Barang::all()
            ]
        );
    }
    public function editBarang($id) {
        $barang = Barang::where('id_barang', $id)->first();
        return view(
            'dashboard.barang.edit',
            [
                'barang' => $barang
            ]
        );
    }
    public function addBarang() {
        return view(
            'dashboard.barang.create'
        );
    }
    
}
