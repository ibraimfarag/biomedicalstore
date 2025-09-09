@include('layouts.head')

<!-- شريط تنبيه أحمر أعلى الصفحة -->

<!-- تنبيه رسمي في أسفل يمين الصفحة يظهر حسب متغيرات البيئة -->
@if(env('SUBSCRIPTION_ALERT', true))
    <div
        style="position: fixed; bottom: 24px; right: 24px; background: linear-gradient(90deg, #d32f2f 80%, #b71c1c 100%); color: #fff; padding: 16px 22px; border-radius: 14px; box-shadow: 0 4px 16px rgba(211,47,47,0.18); font-size: 16px; font-family: 'Cairo', 'Tahoma', Arial, sans-serif; font-weight: bold; z-index: 9999; min-width: 260px; max-width: 530px; display: flex; align-items: flex-start; gap: 10px;    direction: rtl;">
        <span style="font-size: 22px; margin-top: 2px;">&#9888;&#65039;</span>
        <span style="line-height: 1.7;">
            تنويه هام: نود إبلاغكم بقرب انتهاء خدمات واستضافة الموقع.<br>
            للتجديد يرجى التواصل مع المطور قبل تاريخ <span
                style="background: #fff3; padding: 2px 8px; border-radius: 6px; color: #fff; font-weight: 900;">{{ env('SUBSCRIPTION_EXPIRE_DATE', '15/09/2025') }}</span>
        </span>
    </div>
@endif



{{-- @include('layouts.sidebar')

@include('layouts.content') --}}




<div class="main-container">
    @include('layouts.sidebar')

    <main>
        @include('layouts.header')
        @if (session('success'))
            <div class="alert alert-p alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-p alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @include('layouts.content')
    </main>
</div>

@include('layouts.footer')