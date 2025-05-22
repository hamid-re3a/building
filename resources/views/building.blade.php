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
    </style>
</head>
<body>
<header>
    <h1>وضعیت مالی ساختمان</h1>
</header>

<div class="container">
    <div class="print-button">
        <button onclick="window.print()">🖨️ پرینت</button>
    </div>

    <div class="summary">
        <span> مانده صندوق: {{toPersianNumber($allPaidAmount)}}  تومان</span>

        @if(auth()->check() && auth()->id() == 1)
            <form method="POST" action="{{ route('create.invoice') }}" style="display:inline;">
                @csrf
                <select name="type">
                    <option value="charge">شارژ</option>
                    <option value="water">آب</option>
                    <option value="elevator">آسانسو</option>
                    <option value="other">متفرقه</option>
                </select>

                <select name="unit_id">
                    <option value="all">همه</option>
                    <option value="building">هزینه ساختمون</option>
                    @foreach($allUnits as $unit)
                        <option value="{{$unit->id}}">{{$unit->name}}</option>
                    @endforeach

                </select>
                <input type="text" name="name" placeholder="اسم قبض" style="width: 70px;">
                <input type="number" name="amount" placeholder="مبلغ" style="width: 70px;">
                <button type="submit">افزودن</button>
            </form>
            @endif
            </p>
    </div>

    <div class="units">
        @foreach($allUnits as $unit)
            @php
                $net = ($unit->water_debt + $unit->charge_debt ?? 0) ;
                $class = $net < 0 ? 'positive' : ($net > 0 ? 'negative' : '');
            @endphp
            <div class="unit {{ $class }}">
                <h3>{{ $unit->name }} - {{ $unit->owner_name }}</h3>
                <p>
                    قبض آب: {{ toPersianNumber($unit->water_debt ?? 0) }} تومان
                @if(auth()->check() && auth()->id() == 1)
                    <form method="POST" action="{{ route('wallet.deposit') }}" style="display:inline;">
                        @csrf
                        <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                        <input type="hidden" name="type" value="water">
                        <input type="number" name="amount" placeholder="مبلغ" style="width: 70px;">
                        <button type="submit">افزودن</button>
                    </form>
                    @endif
                </p>
{{--                <p>بدهی قبض برق: {{ toPersianNumber($unit->electric_debt ?? 0) }} تومان</p>--}}
                    <p>
                        شارژ ماهانه: {{ toPersianNumber($unit->charge_debt ?? 0) }} تومان
                    @if(auth()->check() && auth()->id() == 1)
                        <form method="POST" action="{{ route('wallet.deposit') }}" style="display:inline;">
                            @csrf
                            <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                            <input type="hidden" name="type" value="charge">
                            <input type="number" name="amount" placeholder="مبلغ" style="width: 70px;">
                            <button type="submit">افزودن</button>
                        </form>
                        @endif
                        </p>
                <p>مانده کیف پول: {{ toPersianNumber($unit->unitBalance() ?? 0) }} تومان</p>

            </div>
        @endforeach
    </div>
</div>
<script>
    function formatPersianNumber(number) {
        let formatted = Number(number).toLocaleString('fa-IR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });
        return formatted;
    }
</script>
</body>
</html>
