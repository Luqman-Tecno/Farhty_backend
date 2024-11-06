<?php

namespace App\Livewire;

use App\Models\Booking;
use Mpdf\Mpdf;
use Livewire\Component;

class BookingInvoice extends Component
{
    public $booking;

    public function mount( Booking $booking)
    {
        $this->booking = $booking;
    }

    public function downloadPdf()
    {
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'fontDir' => [
                storage_path('fonts'),
            ],
            'fontdata' => [
                'tajawal' => [
                    'R' => 'Tajawal-Regular.ttf',
                    'B' => 'Tajawal-Bold.ttf',
                    'useOTL' => 0xFF,
                    'useKashida' => 75,
                ]
            ],
            'default_font' => 'tajawal'
        ]);

        $mpdf->SetDirectionality('rtl');
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;

        $html = view('bookings.invoice-pdf', [
            'booking' => $this->booking
        ])->render();

        $mpdf->WriteHTML($html);

        return response()->streamDownload(function() use ($mpdf) {
            echo $mpdf->Output('', 'S');
        }, 'invoice-' . $this->booking->id . '.pdf');
    }

    public function render()
    {
        return view('bookings.invoice')->layout('layouts.app');
    }
} 