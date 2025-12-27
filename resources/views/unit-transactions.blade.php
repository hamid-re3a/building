<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>وضعیت مالی ساختمان</title>
    <style>
        @font-face {
            font-family: vazir;
            src: url('/fonts/Vazir.woff') ;

        }

        * {
            font-family: vazir;

        }
        body {
            margin: 0;
            padding: 0;
            background: #f9f9f9;
            direction: rtl;
        }
        header {
            background: #333;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        .container {
            padding: 1rem;
        }
        .summary {
            background: #eef;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            font-size: 1.2rem;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .units {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 0.75rem;
        }
        .unit {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        }
        .unit.positive {
            background: #e8f5e9; /* سبز ملایم */
            border-right: 5px solid #4caf50;
        }
        .unit.negative {
            background: #ffebee; /* قرمز ملایم */
            border-right: 5px solid #f44336;
        }
        .unit h3 {
            margin: 0 0 0.5rem;
            font-size: 1.1rem;
        }
        .unit p {
            margin: 0.3rem 0;
            font-size: 0.9rem;
        }
        .print-button {
            margin-bottom: 1rem;
            text-align: center;
        }
        .print-button button {
            padding: 0.6rem 1.2rem;
            font-size: 1rem;
            border: none;
            background-color: #1976d2;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }

        @media (max-width: 600px) {
            .summary {
                flex-direction: column;
                gap: 0.5rem;
            }
        }

        @media print {
            .print-button {
                display: none;
            }
            header {
                background: none;
                color: black;
            }
            .unit {
                box-shadow: none;
            }
        }

        .container {
    max-width: 1100px;
    margin: 30px auto;
    font-family: sans-serif;
}

.page-title {
    margin-bottom: 15px;
}

.table-wrapper {
    border: 1px solid #e5e5e5;
    border-radius: 6px;
    overflow: hidden;
}

.custom-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
}

.custom-table thead {
    background: #f5f5f5;
}

.custom-table th,
.custom-table td {
    padding: 10px 12px;
    border-bottom: 1px solid #eee;
    text-align: left;
    font-size: 14px;
}

.custom-table tbody tr:hover {
    background: #fafafa;
}

.row-warning {
    background: #fffaf0;
}

.row-success {
    background: #f6fff8;
}

.paid {
    color: #2e7d32;
}

.remaining {
    color: #c62828;
}

.status {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
}

.status.paid {
    background: #e8f5e9;
    color: #2e7d32;
}

.status.not_paid {
    background: #fff3e0;
    color: #e65100;
}

.empty {
    text-align: center;
    padding: 30px;
    color: #888;
}

/* Pagination */
.pagination-wrapper {
    margin-top: 15px;
    display: flex;
    justify-content: center;
}

.pagination {
    display: flex;
    gap: 6px;
    list-style: none;
    padding: 0;
}

.pagination li a,
.pagination li span {
    padding: 6px 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-decoration: none;
    color: #333;
    font-size: 13px;
}

.pagination li.active span {
    background: #333;
    color: #fff;
    border-color: #333;
}

.pagination li.disabled span {
    color: #aaa;
}
.pagination-wrapper {
    margin: 25px 0;
    display: flex;
    justify-content: center;
}

.custom-pagination {
    display: flex;
    gap: 6px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.custom-pagination li {
    min-width: 34px;
    height: 34px;
    line-height: 34px;
    text-align: center;
    border-radius: 6px;
    font-size: 13px;
    background: #f5f5f5;
    color: #333;
    cursor: pointer;
}

.custom-pagination li a {
    display: block;
    width: 100%;
    height: 100%;
    text-decoration: none;
    color: inherit;
}

.custom-pagination li:hover {
    background: #e0e0e0;
}

.custom-pagination li.active {
    background: #333;
    color: #fff;
    font-weight: bold;
}

.custom-pagination li.disabled {
    background: #fafafa;
    color: #aaa;
    cursor: not-allowed;
}

    </style>
</head>
<body>
<header>
    <a style="color:white" href="/"><h1>وضعیت مالی ساختمان</h1></a>
    
</header>

<div class="container">
   <div class="container">

    <h3 class="page-title">ریز تراکنش‌های </h3>

    <div class="table-wrapper">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>واحد</th>
                    <th>نام</th>
                    <th>نوع</th>
                    <th>مبلغ کل</th>
                    <th>پرداخت‌شده</th>
                    <th>باقی‌مانده</th>
                    <th>وضعیت</th>
                    <th>تاریخ</th>
                </tr>
            </thead>

            <tbody>
                @forelse($invoices as $invoice)
                    @php
                        $remaining = $invoice->amount - $invoice->paid_amount;
                    @endphp
                    <tr class="{{ $remaining > 0 ? 'row-warning' : 'row-success' }}">
                        <td>{{ $invoice->id }}</td>
                        <td>{{ $invoice->unit?->name ?? '—' }}</td>
                        <td>{{ $invoice->name }}</td>
                       @php
    $types = [
        'charge' => 'شارژ',
        'water' => 'آب',
        'electricity' => 'برق',
        'elevator' => 'آسانسور',
        'parking' => 'پارکینگ ماهانه',
        'other' => 'متفرقه',
    ];
@endphp

<td>{{ $types[$invoice->type] ?? $invoice->type }}</td>
                        <td>{{ number_format($invoice->amount) }}</td>
                        <td class="paid">{{ number_format($invoice->paid_amount) }}</td>
                        <td class="remaining">{{ number_format($remaining) }}</td>
                        <td>
                            <span class="status {{ $invoice->status }}">
                                {{ $invoice->status === 'paid' ? 'پرداخت شده' : 'پرداخت نشده' }}
                            </span>
                        </td>
                        <td>{{ $invoice->created_at->format('Y/m/d') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty">
                            تراکنشی وجود ندارد
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
   <div class="pagination-wrapper">
    <ul class="custom-pagination">

        {{-- Previous --}}
        @if ($invoices->onFirstPage())
            <li class="disabled">قبلی</li>
        @else
            <li>
                <a href="{{ $invoices->previousPageUrl() }}">قبلی</a>
            </li>
        @endif

        @php
            $current = $invoices->currentPage();
            $last = $invoices->lastPage();
            $start = max(1, $current - 2);
            $end = min($last, $current + 2);
        @endphp

        {{-- First --}}
        @if ($start > 1)
            <li><a href="{{ $invoices->url(1) }}">1</a></li>
            @if ($start > 2)
                <li class="dots">…</li>
            @endif
        @endif

        {{-- Middle --}}
        @for ($page = $start; $page <= $end; $page++)
            @if ($page == $current)
                <li class="active">{{ $page }}</li>
            @else
                <li>
                    <a href="{{ $invoices->url($page) }}">{{ $page }}</a>
                </li>
            @endif
        @endfor

        {{-- Last --}}
        @if ($end < $last)
            @if ($end < $last - 1)
                <li class="dots">…</li>
            @endif
            <li>
                <a href="{{ $invoices->url($last) }}">{{ $last }}</a>
            </li>
        @endif

        {{-- Next --}}
        @if ($invoices->hasMorePages())
            <li>
                <a href="{{ $invoices->nextPageUrl() }}">بعدی</a>
            </li>
        @else
            <li class="disabled">بعدی</li>
        @endif

    </ul>
</div>


</div>
</div>
</body>
</html>
