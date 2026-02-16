<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class TasksExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $dateFrom;
    protected $dateTo;

    public function __construct($dateFrom = null, $dateTo = null)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function collection(): \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
    {
        $query = Task::with(['teacher', 'admin']);

        if (!empty($this->dateFrom)) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if (!empty($this->dateTo)) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            '№',
            'Задача',
            'ФИО автора',
            'Дата подачи',
            'Статус',
            'ФИО админа',
            'Дата одобрения',
            'Дата выполнения'
        ];
    }

    public function map($task): array
    {
        $statusMap = [
            'completed'   => 'Выполнена',
            'in_progress' => 'В процессе',
            'declined'    => 'Отклонена',
            'pending'     => 'На модерации'
        ];

        return [
            $task->id,
            $task->title,
            $task->teacher->name ?? '—',
            $task->created_at ? $task->created_at->format('d.m.Y H:i') : '—',
            $statusMap[$task->status] ?? $task->status,
            $task->admin->name ?? '—',
            $task->approved_at ? Carbon::parse($task->approved_at)->format('d.m.Y H:i') : 'Отсутствует',
            $task->completed_at ? Carbon::parse($task->completed_at)->format('d.m.Y H:i') : 'Отсутствует',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $sheet->getStyle('1')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
        $sheet->getStyle('1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('4F46E5');
        $sheet->getStyle('1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:H' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        return [];
    }
}
