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
                    <option value="electricity">برق</option>
                    <option value="elevator">آسانسو</option>
                    <option value="parking">پارکینگ ماهانه</option>
                    <option value="other">متفرقه</option>
                </select>

                <select name="unit_id">
                    <option value="all">همه</option>
                    <option value="building">هزینه ساختمون</option>
                    @foreach($allUnits as $unit)
                        <option value="{{$unit->id}}">{{$unit->name}}</option>
                    @endforeach

                </select>
                <input type="date" name="from_date" placeholder="از تاریخ" style="width: 70px;">
                <input type="date" name="to_date" placeholder="تا تاریخ" style="width: 70px;">
                <input type="text" name="spot" placeholder="عدد جا" style="width: 70px;">
                <input type="text" name="name" placeholder="اسم قبض" style="width: 70px;">
                <input type="number" name="amount" placeholder="مبلغ" style="width: 70px;">
                <button type="submit">افزودن</button>
            </form>
            @endif
            </p>
    </div>
    @if (session('error'))
        <div style="background-color: #fdd; color: #a00; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div style="background-color: #e6ffed; color: #1a7f37; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; border: 1px solid #a0d8a0;">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <div class="parking-section" style="margin-bottom: 2rem;">
            <h2>رزرو جای پارک</h2>

            @php
                use Carbon\Carbon;
                $today = Carbon::today();
            @endphp

            @for ($spot = 1; $spot <= 2; $spot++)
                <div style="margin: 1rem 0;">
                    <strong>جای پارک {{ $spot }}
                        @if ( $spot == 1) (وسط پارکینگ پایین) @endif
                        @if ( $spot == 2) (انتهای پارکینگ پایین)  @endif
                        @if ( $spot == 3) (واحد ۱۴)  @endif
                        @if ( $spot == 4) ( واحد ۱۹)  @endif
                    </strong>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.5rem;">
                        @for ($i = 0; $i < 7; $i++)
                            @php
                                $date = $today->copy()->addDays($i)->format('Y-m-d');
                                $dayNames = [ 'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه','شنبه'];
                                if($i == 0 ){
                                    $label = 'امروز';
                                } else if( $i == 1) {
                                    $label = 'فردا';
                                } else {
                                    $label = $dayNames[$today->copy()->addDays($i)->dayOfWeek];
                                }
//                                $label = $today->copy()->addDays($i)->format('Y/m/d');
                                $reserved = $reservations[$date][$spot] ?? null;
                            @endphp

                            @if($reserved)
                                <div style="background:#ccc;padding:0.5rem 1rem;border-radius:6px;position:relative;">
                                    {{ $reserved->unit->name }}
                                    <div style="display: flex;  align-items: center; gap: 0.5rem;position: absolute; top :-10px  ; left : -10px">
                                        @if(auth()->check() && auth()->id() == 1)
                                            <form method="POST" action="{{ route('parking.cancel', $reserved->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background:none; border:none; color:red; cursor:pointer;font-size: 20px;font-weight: 900;">X</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>


                            @else
                                <button
                                    onclick="reserveParking('{{ $date }}', {{ $spot }})"
                                    style="padding:0.5rem 1rem;border:none;background:#4caf50;color:white;border-radius:6px;cursor:pointer;">
                                    {{ $label }}
                                </button>
                            @endif
                        @endfor
                    </div>
                </div>
            @endfor
        </div>

    <div class="units">
        @foreach($allUnits as $unit)
            @php
                $net = ($unit->water_debt + $unit->charge_debt  + $unit->parking_debt ?? 0) ;
                $class = $net < 0 ? 'positive' : ($net > 0 ? 'negative' : '');
            @endphp
            <div class="unit {{ $class }}">
                <h3>{{ $unit->name }} - {{ $unit->owner_name }}</h3>
                 <p>
                    قبض برق: {{ toPersianNumber($unit->electricity_debt ?? 0) }} تومان
                @if(auth()->check() && auth()->id() == 1)
                    <form method="POST" action="{{ route('wallet.deposit') }}" style="display:inline;">
                        @csrf
                        <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                        <input type="hidden" name="type" value="electricity">
                        <input type="number" name="amount" placeholder="مبلغ" style="width: 70px;">
                        <button type="submit">افزودن</button>
                    </form>
                    @endif
                </p>
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

                        <p>
                            هزینه پارکینگ: {{ toPersianNumber($unit->parking_debt ?? 0) }} تومان
                        @if(auth()->check() && auth()->id() == 1)
                            <form method="POST" action="{{ route('wallet.deposit') }}" style="display:inline;">
                                @csrf
                                <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                                <input type="hidden" name="type" value="parking">
                                <input type="number" name="amount" placeholder="مبلغ" style="width: 70px;">
                                <button type="submit">افزودن</button>
                            </form>
                            @endif
                            </p>
                <p>مانده کیف پول: {{ toPersianNumber($unit->unitBalance() ?? 0) }} تومان</p>

            </div>
        @endforeach
    </div>
    <div id="unitSelectModal" style="display:none; position:fixed; inset:0; background:#00000088; z-index:1000;">
        <div style="background:white; padding:1rem; border-radius:10px; max-width:300px; margin:10% auto;">
            <h3>واحد مورد نظر را انتخاب کنید:</h3>
            <div id="unitButtons" style="display: flex; flex-direction: column; gap: 0.5rem;margin-bottom: 10px"></div>
            <button onclick="closeUnitModal()">بستن</button>
        </div>
    </div>

        <div id="passwordModal" style="display:none; position:fixed; inset:0; background:#00000088; z-index:1000;">
            <div style="background:white; padding:1rem; border-radius:10px; max-width:300px; margin:10% auto; text-align:center;">
                <h3 style="margin-bottom: 1rem;">پسورد <span id="unitNameInModal"></span> را وارد کنید:</h3>
                <input type="text" id="unitPasswordInput" style="width: 100%; margin-bottom: 1rem;" placeholder="پسورد">
                <br>
                <button onclick="submitUnitPassword()" style="margin-left: 0.5rem;">تأیید</button>
                <button onclick="closePasswordModal()">بستن</button>
            </div>
        </div>

    </div>
<script>
    const unitsList = @json($allUnits);
    function reserveParking(date, spot) {
        showUnitSelect(function(unit) {

            showPasswordModal(unit, (password, unit) => {
                // حالا اینجا واحد انتخاب شده رو داری:
                if (!unit) return;
                console.log('انتخاب شد:', unit.name, unit.id);

                // ادامه رزرو با unit.id یا unit.name
                // مثلاً:
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?php echo e(route('parking.reserve')); ?>';

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '<?php echo e(csrf_token()); ?>';

                const inputDate = document.createElement('input');
                inputDate.type = 'hidden';
                inputDate.name = 'date';
                inputDate.value = date;

                const inputSpot = document.createElement('input');
                inputSpot.type = 'hidden';
                inputSpot.name = 'spot';
                inputSpot.value = spot;


                const inputPassword = document.createElement('input');
                inputPassword.type = 'hidden';
                inputPassword.name = 'password';
                inputPassword.value = password;

                const inputUnit = document.createElement('input');
                inputUnit.type = 'hidden';
                inputUnit.name = 'unit_id';
                inputUnit.value = unit.id;

                form.appendChild(csrf);
                form.appendChild(inputDate);
                form.appendChild(inputPassword);
                form.appendChild(inputSpot);
                form.appendChild(inputUnit);

                document.body.appendChild(form);
                form.submit();

            });
        });



    }


    let onUnitSelectedCallback = null;

    function showUnitSelect(callback) {
        const modal = document.getElementById('unitSelectModal');
        const buttonsDiv = document.getElementById('unitButtons');

        // پاکسازی محتوا و تنظیمات استایل
        buttonsDiv.innerHTML = '';
        buttonsDiv.style.display = 'grid';
        buttonsDiv.style.gridTemplateColumns = 'repeat(4, 1fr)';
        buttonsDiv.style.gap = '0.5rem';

        // ساخت دکمه‌ها
        unitsList.forEach(unit => {
            const btn = document.createElement('button');
            btn.innerText = unit.name;
            btn.style.padding = '0.5rem';
            btn.style.cursor = 'pointer';
            btn.style.boxSizing = 'border-box';
            btn.onclick = () => {
                modal.style.display = 'none';
                callback(unit);
            };
            buttonsDiv.appendChild(btn);
        });

        onUnitSelectedCallback = callback;
        modal.style.display = 'block';
    }
    function closeUnitModal() {
        document.getElementById('unitSelectModal').style.display = 'none';
    }

    let selectedUnit = null;
    let onPasswordSubmitCallback = null;

    function showPasswordModal(unit, callback) {
        selectedUnit = unit;
        onPasswordSubmitCallback = callback;
        document.getElementById('unitNameInModal').innerText = unit.name;
        document.getElementById('unitPasswordInput').value = '';
        document.getElementById('passwordModal').style.display = 'block';
    }

    function closePasswordModal() {
        document.getElementById('passwordModal').style.display = 'none';
    }

    function submitUnitPassword() {
        const password = document.getElementById('unitPasswordInput').value;
        if (!password) {
            alert('لطفا پسورد را وارد کنید.');
            return;
        }

        // ارسال به سرور یا استفاده محلی از پسورد
        closePasswordModal();
        if (onPasswordSubmitCallback) {
            onPasswordSubmitCallback(password, selectedUnit);
        }
    }
</script>
</body>
</html>
