@extends('template.layout')

@section('resources')


@stop



@section('content')

    <title>微信支付</title>



    <div class="qr-code-image" >

        {!!  \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->generate($wechatPayUrl['code_url']); !!}
        <div class="pay-desc">
            <div class="scan-pay-icon">
            </div>

            <div class="text">
                    请使用微信扫描二维码完成支付
            </div>
        </div>


        <div class="wxpay-total">
            <span class="h">微信支付总额: </span>
            <span class="m-s">￥</span><span class="t">{{$wechatPayUrl['totalAmount']}}</span>
        </div>
    </div>
@stop


@section('script')

    <script >

        $(document).ready(function(){



        })
    </script>

@stop

