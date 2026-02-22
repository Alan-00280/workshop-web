<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function generateCertificate(Request $request) {
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'event_name' => 'required|string|max:255',
            'event_description' => 'required|string',
            'date' => 'required|date',
        ]);

        $pdf = Pdf::loadView('doc.certificate', $validated)->setPaper('a4', 'landscape')->setWarnings(false);
        $filename = 'certificate-'.str_replace(' ', '-', $validated['recipient_name']).'.pdf';
       
        return $pdf->stream($filename);
    }

    public function generateInvitation(Request $request) {
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'event_name' => 'required|string|max:255',
            'event_description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        $pdf = Pdf::loadView('doc.invitation', $validated)->setPaper('a4')->setWarnings(false);
        $filename = 'undangan-'.str_replace(' ', '-', $validated['recipient_name']).'.pdf';

        return $pdf->stream($filename);
    }
}
