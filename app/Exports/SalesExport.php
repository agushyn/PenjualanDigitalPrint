<?php

namespace App\Exports;

use App\Models\SaleItem;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $machine;
    protected $status;

    public function __construct($machine = null, $status = null)
    {
        $this->machine = $machine;
        $this->status = $status;
    }

    public function query()
    {
        $query = SaleItem::query()->with('sale');

        if ($this->machine) {
            $query->where('machine', $this->machine);
        }
        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'No. Invoice',
            'Tanggal',
            'Pelanggan',
            'Nama Barang',
            'Mesin',
            'Qty',
            'Harga Satuan',
            'Subtotal',
            'Diskon Nota',
            'Total Akhir Nota',
            'Status Produksi',
        ];
    }

    public function map($item): array
    {
        return [
            $item->sale->invoice_number,
            $item->created_at->format('d/m/Y H:i'),
            $item->sale->customer_name,
            $item->item_name,
            strtoupper($item->machine),
            $item->qty,
            $item->price,
            $item->subtotal,
            $item->sale->discount,
            $item->sale->grand_total,
            strtoupper($item->status),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}