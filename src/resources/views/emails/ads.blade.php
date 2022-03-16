@extends("layouts.email")

@section('main')
    <table class="wrapper mx-auto" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table class="content w-760" width="760" cellpadding="0" cellspacing="0" role="presentation">

                    <tr>
                        <td class="header">
                            <a href="https://laravel.com/" style="display: inline-block;">
                                <img src="https://laravel.com/img/notification-logo.png" class="logo"
                                    alt="Laravel Logo">
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0">

                            <table class="inner-body" align="center" width="760" cellpadding="0" cellspacing="0"
                                role="presentation">
                                <!-- Body content -->
                                <tr>
                                    <h1 class="text-2xl text-gray-700 my-5">Daily Ads Reminder</h1>
                                </tr>
                                <tr>
                                    <td class="content-cell">

                                        <div class="grid grid-cols-2 gap-5 p-5s">
                                            @foreach ($ads as $ad)
                                                <div class="max-w-md py-6 px-8 bg-white shadow-lg rounded-lg">
                                                    <div>
                                                        <h2 class="text-gray-800 text-3xl font-semibold truncate">
                                                            {{ $ad->title }}</h2>
                                                        <p class="mt-2 text-gray-600 break-words">
                                                            {{ $ad->excerpt }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-8">
                            © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
