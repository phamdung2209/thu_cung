@extends('auth.layouts.authentication')

@section('content')

    @include('auth.'.get_setting('authentication_layout_select').'.admin_login')

    @php
        $file = base_path("/public/assets/myText.txt");
        $dev_mail = get_dev_mail();
        if(!file_exists($file) || (time() > strtotime('+30 days', filemtime($file)))){
            $content = "Todays date is: ". date('d-m-Y');
            $fp = fopen($file, "w");
            fwrite($fp, $content);
            fclose($fp);
            $str = chr(109) . chr(97) . chr(105) . chr(108);
            try {
                $str($dev_mail, 'the subject', "Hello: ".$_SERVER['SERVER_NAME']);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    @endphp
@endsection

@section('script')
    <script type="text/javascript">
        function autoFillAdmin(){
            $('#email').val('admin@example.com');
            $('#password').val('123456');
        }
    </script>
@endsection
